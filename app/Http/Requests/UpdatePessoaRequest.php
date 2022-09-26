<?php

namespace App\Http\Requests;

use App\Http\Resources\EnderecoResource;
use App\Models\Endereco;
use Illuminate\Foundation\Http\FormRequest;

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
class UpdatePessoaRequest extends FormRequest
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
            'enderecos.*.codigoBairro' => 'required'
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
            'enderecos.*.codigoBairro.required' => 'É necessário cadastrar um bairro'
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge(['enderecos' => $this->enderecos]);
    }

//    public function requestComEnderecosFormatados ()
//    {
//        foreach ($this->enderecos as $endereco) {
//            $enderecos[] =
//                [
//                    new EnderecoResource([$endereco])
////                    'codigo_endereco' => $endereco['codigoEndereco'],
////                    'codigo_bairro' => $endereco['codigoBairro'],
////                    'nome_rua' => $endereco['nomeRua'],
////                    'numero' => $endereco['numero'],
////                    'complemento' => $endereco['complemento'],
////                    'cep' => $endereco['cep']
//                ];
//        }
//        return $this->merge(['enderecos' => $enderecos]);
//    }
}
