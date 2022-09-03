<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
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
class StoreUpdateUfRequest extends FormRequest
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
            'codigo_uf' => 'required',
            'sigla' => 'required | min:2 | max:255',
            'nome' => 'required | min:3 | max:255',
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
            'sigla.required' => 'O campo :attribute é necessário',
            'nome.required' => 'O campo :attribute é necessário',
            'status.required' => 'O campo :attribute é necessário'
        ];
    }

    protected function prepareForValidation()
    {
        $teste = $this->merge([
            'codigo_uf' => Str::snake($this->codigoUf, '_'),
        ]);

        Log::alert('Data prepareForValidation',[$teste]);
    }
}
