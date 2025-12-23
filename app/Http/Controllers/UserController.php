<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Notifications\OrderStatusChangedNotification;
use App\Notifications\UserCreatedNotification;
use App\Notifications\OperationFailedNotification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private NotificationService $notificationService) {}


    public function createUser(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $this->notificationService->send(
            $user,
            new UserCreatedNotification(['name' => $user->name])
        );

        return response()->json(['message' => 'User created']);
    }

    public function changeOrderStatus(Order $order, $status)
    {
        $order->update(['status' => $status]);

        $this->notificationService->send(
            $order->user,
            new OrderStatusChangedNotification([
                'order_id' => $order->id,
                'status' => $status
            ])
        );

        return response()->json(['message' => 'Order status updated']);
    }


    public function failOperation(User $user)
    {
        $this->notificationService->send(
            $user,
            new OperationFailedNotification(['reason' => 'Payment failed'
            ])
        );

        return response()->json(['message' => 'Operation failed notification sent']);
    }
}
