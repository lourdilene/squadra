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
            'codigo_endereco' => $this->codigo_endereco,
            'codigo_pessoa' => $this->codigo_pessoa,
            'nome_rua' => $this->nome_rua,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'cep' => $this->cep,
        ];
    }
}
