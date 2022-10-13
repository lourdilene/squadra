<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateMunicipioRequest;
use App\Http\Resources\MunicipioResource;
use App\Models\Municipio;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MunicipioController
{
    protected $classe = Municipio::class;

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

                if (!$resource){
                    return response()->json([]);
                }

                return response()->json(new MunicipioResource($resource));
            }

            return response()->json(MunicipioResource::collection($this->classe::all()));

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível pesquisar o Município.',
                'status' => '503'
            ],503);
        }
    }

    public function store(StoreUpdateMunicipioRequest $request)
    {
        try{
            if ($this->classe::where('nome', $request->nome)->exists()) {
                return response()->json([
                    'mensagem'=>'Não foi possível cadastrar, pois já existe um registro de Município com o mesmo nome para a UF informada.',
                    'status' => '400'
                ],400);
            }

            $this->classe::create($request->all());
            return response()->json([
                'mensagem'=>'Município cadastrado com sucesso.'
            ],200);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível cadastrar o município.',
                'status' => '503'
            ],503);
        }
    }

    public function update(StoreUpdateMunicipioRequest $request, int $id)
    {
        try{
            $resource =  $this->classe::findOrFail($id);

            if ($resource::where('nome', $request->nome)->exists()) {
                return response()->json([
                    'mensagem'=>'Não foi possível alterar, pois já existe um registro de Município com o mesmo nome para a UF informada.',
                    'status' => '400'
                ],400);
            }

            $resource->fill($request->all());
            $resource->save();

            return response()->json(
                MunicipioResource::collection($resource::all())
                ,200);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível alterar o Muncípio.',
                'status' => '503'
            ],503);
        }
    }

    public function destroy(int $id)
    {
        $numberOfResource = $this->classe::destroy($id);
        if ($numberOfResource === 0)
            return response()->json(['Erro'=>'Recurso não encontrado'],404);
        return response()->json('',204);
    }
}
