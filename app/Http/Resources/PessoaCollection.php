<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 *     title="PessoaResource",
 *     description="Pessoa resource",
 *     @OA\Xml(
 *         name="PessoaResource"
 *     )
 * )
 */
class PessoaCollection extends ResourceCollection
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper",
     *     property="data"
     * )
     *
     * @var \App\Models\Pessoa[]
     *
     *
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}
