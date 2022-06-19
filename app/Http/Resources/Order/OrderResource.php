<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderItem\OrderItemResource;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Mixed_;

/**
 * @property mixed id
 * @property mixed quantity
 * @property mixed description
 * @property mixed cost
 * @property mixed delivery_address
 * @method  order_item()
 */
class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'cost' => $this->cost,
            'delivery_address' => $this->delivery_address,
            'order_item' => OrderItemResource::collection($this->order_items),
            $this->mergeWhen($this->created_at, [
                "created_at" => $this->created_at?->format("Y-m-d (h:i)A"),
                "created_from" => $this->created_at?->diffForHumans(),
            ]),
            $this->mergeWhen($this->updated_at, [
                "updated_at" => $this->updated_at?->format("Y-m-d (h:i)A"),
                "updated_from" => $this->updated_at?->diffForHumans(),
            ]),
        ];
    }
}
