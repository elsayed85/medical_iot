<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class userProfile extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'numeric', 'min:1' , 'max:100'],
            'geneder' => ['required', 'string' , 'in:male,female'],
            'email' => ['required', 'string', 'email', 'max:255' , \Illuminate\Validation\Rule::unique('users')->ignore($this->user()->id)],
            'password' => ['required', 'string', 'min:4' , 'confirmed'],
            'phone' => "numeric|min:6",
            'start_sleep' => "nullable|date_format:H:i",
            'end_sleep' => "nullable|date_format:H:i"
        ];
    }
}
