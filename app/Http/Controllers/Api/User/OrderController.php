<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{


    public function previousOrder(Request $request)
    {
        $user = $request->user();

        $previousOrders = Order::where('user_id', $user->id)
            ->with(['orderItems.product.category', 'orderItems.product.subCategory', 'orderItems.product.productImages'])
            ->get();

        $data = $previousOrders->map(function ($order) {
            return [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'total_price' => $order->total_price,
                'status' => $order->status,
                'order_items' => $order->orderItems->map(function ($orderItem) {
                    return [
                        'product_id' => $orderItem->product_id,
                        'quantity' => $orderItem->quantity,
                        'price' => $orderItem->price,
                        'product' => [
                            'id' => $orderItem->product->id,
                            'category_id' => $orderItem->product->category_id,
                            'category_name' => optional($orderItem->product->category)->name,
                            'sub_category_id' => $orderItem->product->sub_category_id,
                            'sub_category_name' => optional($orderItem->product->subCategory)->name,
                            'product_name' => $orderItem->product->name,
                            'product_description' => $orderItem->product->description,
                            'product_price' => $orderItem->product->price,
                            'product_size' => $orderItem->product->size,
                            'product_color' => $orderItem->product->color,
                            'product_quality' => $orderItem->product->product_quality,
                            'product_type' => $orderItem->product->type,
                            'product_images' => $orderItem->product->productImages->map(function ($image) {
                                return [
                                    'image' => url('storage/' . $image->image),
                                ];
                            }),
                        ]
                    ];
                })
            ];
        });

        return response()->json(['previous_orders'=>$data]);
    }

    public function makeOrder(Request $request){
        $user = $request->user();
        $products = $request->products;
        $validation = Validator::make($request->all(), [
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
        ]);
        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => 'ORD'.rand(1000,9999),
            'total_price' => 0,
            'status' => 'processing'
        ]);
        $totalPrcice = 0 ;
        foreach($request->products as $product){}
    }
}
