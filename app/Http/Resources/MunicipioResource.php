<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MunicipioResource extends JsonResource
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
            'codigoMunicipio' => $this->codigo_municipio,
            'codigoUF' => $this->codigo_uf,
            'sigla' => $this->sigla,
            'nome' => $this->nome,
            'status' => $this->status
        ];
    }
}
