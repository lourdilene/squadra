<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *      title="Store Project request",
 *      description="Store Project request body data",
 *      type="object",
 *      required={"nome, sobrenome"},
 *      @OA\Property(property="nome", type="string", example="Fulano"),
 *      @OA\Property(property="sobrenome", type="string", example="Souza"),
 *      @OA\Property(property="idade", type="string", example="31"),
 *      @OA\Property(property="login", type="string", example="fulano@gmail.com"),
 *      @OA\Property(property="senha", type="password", example="123456"),
 *      @OA\Property(property="status", type="int", example="1")
 * )
 */
class StorePessoaRequest extends FormRequest
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
     *
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
            'status' => 'required',
            'enderecos' => 'required',
            'enderecos.*.codigo_bairro' => 'required'
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
            'enderecos.required' => 'É necessário cadastrar pelo menos um endereço',
            'enderecos.*.codigo_bairro.required' => 'É necessário cadastrar um bairro'
        ];
    }

    protected function prepareForValidation()
    {
        foreach ($this->enderecos as $endereco) {
            foreach (array_keys($endereco) as $key) {
                $keyFormat = Str::snake($key, '_');
                $enderecoToSnakeCase[$keyFormat] = $endereco[$key];
            }
            $enderecos[] = $enderecoToSnakeCase;
        }
        return $this->merge(['enderecos' => $enderecos]);
    }
}
