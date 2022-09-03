<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateBairroRequest;
use App\Http\Resources\BairroResource;
use App\Models\Bairro;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BairroController
{
    protected $classe = Bairro::class;

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

                return response()->json(new BairroResource($resource));
            }

            return response()->json(BairroResource::collection($this->classe::all()));

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível pesquisar o Município.',
                'status' => '503'
            ],503);
        }
    }

    public function store(StoreUpdateBairroRequest $request)
    {
        try{
            if ($this->classe::where('nome', $request->nome)->exists()) {
                return response()->json([
                    'mensagem'=>'Não foi possível cadastrar, pois já existe um registro de Bairro com o mesmo nome para o Município informado.',
                    'status' => '400'
                ],400);
            }

            $this->classe::create($request->all());
            return response()->json([
                'mensagem'=>'Bairro cadastrado com sucesso.'
            ],200);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível cadastrar o bairro.',
                'status' => '503'
            ],503);
        }
    }

    public function update(StoreUpdateBairroRequest $request, int $id)
    {
        try{
            $resource =  $this->classe::findOrFail($id);

            if ($resource::where('nome', $request->nome)->exists()) {
                return response()->json([
                    'mensagem'=>'Não foi possível alterar, pois já existe um registro de Bairro com o mesmo nome para o Município informado.',
                    'status' => '400'
                ],400);
            }

            $resource->fill($request->all());
            $resource->save();

            return response()->json(
                BairroResource::collection($resource::all())
                ,200);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível alterar o Muncípio.',
                'status' => '503'
            ],503);
        }
    }
}
