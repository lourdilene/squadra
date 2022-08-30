<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="PessoaResource",
 *     description="Pessoa resource",
 *     @OA\Xml(
 *         name="PessoaResource"
 *     )
 * )
 */
class PessoaResource extends JsonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Pessoa[]
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
            'codigo_pessoa' => $this->codigo_pessoa,
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'idade' => $this->idade,
            'status' => $this->status,
        ];
    }
}
