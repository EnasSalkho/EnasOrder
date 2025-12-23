<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Notifications\OperationFailedNotification;
use App\Notifications\OrderStatusChangedNotification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function changeStatus(Order $order)
    {
        $order->update([
            'status' => 'paid'
        ]);
        $this->notificationService->send(
            $order->user,
            new OrderStatusChangedNotification([
                'order_id' => $order->id,
                'status' => $order->status
            ])
        );
        return response()->json(['message' => 'Order status updated']);
    }
    public function index() {
        return OrderResource::collection(Order::with('items')->paginate(15));
    }
    public function store(Request $request)
    {
        try {
            $order = Order::create([
            ]);
            return response()->json(['message' => 'Order created']);
        } catch (\Exception $e) {

            $this->notificationService->send(
                auth()->user(),
                new OperationFailedNotification([
                    'reason' => 'Order creation failed'
                ]),
                now()->addMinutes(5)
            );
            return response()->json(['message' => 'Error'], 500);
        }
    }
    public function show(Order $order) {
        return new OrderResource($order->load('items'));
    }
    public function update(UpdateOrderRequest $request, Order $order) {
        $order->update($request->validated());
        return new OrderResource($order->load('items'));
    }
    public function destroy(Order $order) {
        $order->delete();
        return response()->json(null,204);
    }
    public function customerOrders($customerId){
        $orders = Order::with('items')->where('customer_id',$customerId)->paginate(15);
        return OrderResource::collection($orders);
    }
}
