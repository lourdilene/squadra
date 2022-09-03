<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BairroResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'codigoBairro' => $this->codigo_bairro,
            'codigoMunicipio' => $this->codigo_municipio,
            'nome' => $this->nome,
            'status' => $this->status
        ];
    }
}
