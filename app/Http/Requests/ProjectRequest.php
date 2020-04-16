<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'customer_id' => 'required|exists:users,id',
            'status_id' => 'required|exists:statuses,id',
            'name' => 'required|string|max:255',
            'news' => 'string|max:255',
            'body' => 'required|string|min:25',
        ];
    }
}
