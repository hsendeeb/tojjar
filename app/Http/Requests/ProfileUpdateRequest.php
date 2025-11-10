<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username'=>['required',Rule::unique(User::class)->ignore($this->user()->id)],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'bio'=>['nullable'],
            'image'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'phone' => [
        'required',
        'string',
        'regex:/^(?:\+961|961|0)?(3|70|71|76|78|79|81|82|83|84|85|88|89)\d{6}$/',
        ]
             ];
    }
}
