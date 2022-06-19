<?php

namespace App\Http\Resources\Product;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed code
 * @property mixed description
 * @property mixed cost
 * @property mixed quantity_available
 * @method
 */


class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'description' => $this->description,
            'cost' => $this->cost,
            'quantity_available' => $this->quantity_available,
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
