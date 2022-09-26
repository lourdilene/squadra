<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnderecoResource extends JsonResource
{
    /**
     *
     *
     *
     *
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'codigo_bairro' => $request['codigoBairro'],
            'codigo_pessoa' => 1,
            'nome_rua' => $request['nomeRua'],
            'numero' => $request['numero'],
            'complemento' => $request['complemento'],
            'cep' => $request['cep']
        ];
    }
}
