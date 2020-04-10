<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "issue_date" => "required|date|after_or_equal:now",
            "due_date" => "required|date|after:issue_date",
            "customer_id" => "required|exists:users,id",
            "project_id" => "required|exists:projects,id",
            "items" => "required|array",
            "price_items" => "required|array",
            "qty_items" => "required|array",
            "additionnal" => "string|max:255|nullable",
        ];
    }
}
