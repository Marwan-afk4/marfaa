<?php

namespace App\Http\Controllers\Api\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    public function getProcessingOrders(){
        $orders = Order::where('status', 'processing')
        ->with('orderItems.product.productImages')
        ->get();
        foreach ($orders as $order) {
            foreach ($order->orderItems as $orderItem) {
                foreach ($orderItem->product->productImages as $productImage) {
                    if (!str_starts_with($productImage->image, 'http')) {
                        $productImage->image = asset('storage/'.$productImage->image);
                    }
                }
            }
        }
        $data = [
            'orders' => $orders
        ];
        return response()->json($data);
    }


    public function deliveredOrder($order_id){
        $order = Order::find($order_id);
        $order->status = 'completed';
        $order->save();
        return response()->json([
            'message' => 'Order delivered successfully'
        ]);
    }

    public function canceledOrder($order_id){
        $order = Order::find($order_id);
        $order->status = 'cancelled';
        $order->save();
        return response()->json([
            'message' => 'Order canceled successfully'
        ]);
    }
}
