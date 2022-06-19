<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->Data(['orders' => OrderResource::collection(Order::all())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();
        $products = Product::whereIn('id', collect($validated['order_items'])->pluck('product_id'))->get();
        foreach ($products as $product) {
            if (collect($validated['order_items'])->pluck('quantity', 'product_id')[$product['id']] > $product['quantity_available'])
                return $this->Error("Quantity is not available");
        }
        $products_cost = $products->pluck('cost', 'id');
        foreach ($validated['order_items'] as $orderItem) {
            $totalcost = (isset($totalcost) ? $totalcost : 0) + $products_cost[$orderItem['product_id']] * $orderItem['quantity'];
            Product::where('id', $orderItem['product_id'])->decrement('quantity_available', $orderItem['quantity']);
            $order_item_data[] = ['quantity' => $orderItem['quantity'], 'product_id' => $orderItem['product_id']];
        }
        $order = new Order();
        $order->delivery_address = $validated['delivery_address'];
        $order->description = $validated['description'];
        $order->cost = $totalcost;
        $order->save();
        $order->order_items()->createMany($order_item_data);
        return $this->Success('Your order has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public
    function show(Order $order): JsonResponse
    {
        return $this->Data(['order' => new OrderResource($order)]);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public
    function destroy(Order $order)
    {
        foreach ($order->order_items as $item) {
            $item->product->increment('quantity_available',$item->quantity);
            $item->delete();
        }
        $order->delete();
        return $this->Success('order has been Deleted successfully');
    }
}
