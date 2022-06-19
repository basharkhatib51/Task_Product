<?php


namespace App\Http\Requests\OrderItem;

use Illuminate\Foundation\Http\FormRequest;


class UpdateOrderItemRequest extends FormRequest
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
            'code' => "string|required",
            'description' => "required",
            'cost' => "required|numeric|regex:/^\d+(\.\d{1,2})?$/",
            'quantity_available' => "required",
        ];
    }
}
