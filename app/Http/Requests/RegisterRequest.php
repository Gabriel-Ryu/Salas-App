<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|',
            'password' => 'required|string',
            'adm' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Input the user login',
            'password.required' => 'Input the user password',
            'adm.boolean' => 'The adm field its boolean'
        ];
    }
}
