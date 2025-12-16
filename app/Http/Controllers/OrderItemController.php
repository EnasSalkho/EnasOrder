<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    public function store(StoreOrderItemRequest $request){
        return DB::transaction(function() use ($request) {
            $item = OrderItem::create($request->validated());
            return new OrderItemResource($item);
        });
    }
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem){
        return DB::transaction(function() use ($request, $orderItem) {
            $orderItem->update($request->validated());
            return new OrderItemResource($orderItem);
        });
    }
    public function destroy(OrderItem $orderItem){
        $orderItem->delete();
        return response()->json(null,204);
    }
}
