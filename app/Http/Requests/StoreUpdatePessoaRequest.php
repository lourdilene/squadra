<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePessoaRequest extends FormRequest
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
            'nome' => 'required | min:3 | max:255',
            'sobrenome' => 'required | min:3 | max:255',
            'idade' => 'required | max:3',
            'login' => 'required | min:3 | max:255',
            'senha' => 'required | min:3 | max:255',
            'status' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nome.required' => 'O campo :attribute é necessário',
            'sobrenome.required' => 'O campo :attribute é necessário',
            'idade.required' => 'O campo :attribute é necessário',
            'login.required' => 'O campo :attribute é necessário',
            'senha.required' => 'O campo :attribute é necessário',
            'status.required' => 'O campo :attribute é necessário',
        ];
    }
}
