<?php


namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;


class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'delivery_address' => "required",
            'description' => "required",
            'order_items.*.quantity' => "required",
            'order_items.*.product_id' => "required|exists:products,id",
        ];
    }
}
