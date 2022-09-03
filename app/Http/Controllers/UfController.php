<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUfRequest;
use App\Http\Resources\UfResource;
use App\Models\Uf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UfController
{
    protected $classe = Uf::class;

    public function index(Request $request)
    {
        try{
            $parametros = $request->input();

            if ($parametros){
                foreach ($parametros as $index => $parametro) {
                    if ($index == 'codigoUF'){
                        $index = 'codigoUf';
                    }
                    $indexConvertido = Str::snake($index);
                    Log::alert('snake',[$index, $indexConvertido]);
                    $clausulasWhere[] = [$indexConvertido, '=', $parametro];
                }

                $resource = $this->classe::Where($clausulasWhere)->get()->first();

                return response()->json(new UfResource($resource));
            }

            return response()->json(UfResource::collection($this->classe::all()));

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível pesquisar a UF.',
                'status' => '503'
            ],503);
        }
    }

    public function store(StoreUpdateUfRequest $request)
    {
        try{
            if ($this->classe::where('sigla', $request->sigla)->exists()) {
                return response()->json([
                    'mensagem'=>'Não foi possível cadastrar, pois já existe um registro de UF com a mesma sigla.',
                    'status' => '400'
                ],400);
            }

            $this->classe::create($request->all());
            return response()->json([
                'mensagem'=>'UF cadastrada com sucesso.'
            ],200);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível cadastrar a UF.',
                'status' => '503'
            ],503);
        }
    }

    public function update(StoreUpdateUfRequest $request, int $id)
    {
        try{
            $resource =  $this->classe::findOrFail($id);

            if ($resource::where('sigla', $request->sigla)->exists()) {
                return response()->json([
                    'mensagem'=>'Não foi possível alterar, pois já existe um registro de UF com a mesma sigla cadastrada.',
                    'status' => '400'
                ],400);
            }

            $resource->fill($request->all());
            $resource->save();

            return response()->json(
                UfResource::collection($resource::all())
            ,200);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível alterar a UF.',
                'status' => '503'
            ],503);
        }
    }
}
