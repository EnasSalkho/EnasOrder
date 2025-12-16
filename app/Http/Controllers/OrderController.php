<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index() {
        return OrderResource::collection(Order::with('items')->paginate(15));
    }
    public function store(StoreOrderRequest $request) {
        $order = Order::create($request->validated());
        return new OrderResource($order->load('items'));
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
