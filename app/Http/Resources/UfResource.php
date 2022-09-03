<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UfResource extends JsonResource
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
            'codigoUF' => $this->codigo_uf,
            'sigla' => $this->sigla,
            'nome' => $this->nome,
            'status' => $this->status
        ];
    }
}
