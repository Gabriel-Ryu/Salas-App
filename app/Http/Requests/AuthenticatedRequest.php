<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Contracts\Service\Attribute\Required;

class AuthenticatedRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'password' => 'required|string|max:50',
            'adm' => 'integer|in:0,1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Input the user login',
            'password.required' => 'Input the user password',
            'adm.in:0,1' => 'The adm field accept only 0 and 1 values'
        ];
    }
}
