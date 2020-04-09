<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
{
    protected $userId;

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
            'user.firstname' => 'required|string|max:255',
            'user.lastname' => 'required|string|max:255',
            'user.email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($this->userId),
            ],
            'user.knew' => 'boolean',
            'address.phone_1' => 'required|digits_between:10,12',
            'address.phone_2' => 'digits_between:10,12|nullable',
            'address.address_1' => 'required|string|max:255',
            'address.address_2' => 'string|max:255|nullable',
            'address.city' => 'required|string|max:255',
            'address.country' => 'required|string|max:255',
            'address.zipcode' => 'required|digits:5',
        ];
    }

    /**
     * Check if user is in url, otherwise use auth id
     *  /!\
     *
     * @return void
     */
    public function prepareForValidation()
    {
        $this->userId = $this->route()->customer ? $this->route()->customer->id : auth()->id();
    }
}
