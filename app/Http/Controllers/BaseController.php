<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUfRequest;
use App\Http\Requests\UpdateUfRequest;
use App\Models\Uf;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

abstract class BaseController extends Controller
{
    public function index(Request $request)
    {
        return $this->classe::paginate($request->per_page);
    }

    public function store(FormRequest $request)
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

    public function show(int $id)
    {
        $resource = $this->classe::find($id);

        if (is_null($resource))
            return response()->json($resource,204);
        return response()->json($resource);
    }

    public function update(int $id, UpdateUfRequest $request)
    {
        $resource = $this->classe::find($id);
        if (is_null($resource))
            return response()->json(['Erro'=>'Recurso não encontrado'],404);
        $resource->fill($request->all());
        $resource->save();

        return $resource;
    }

    public function destroy(int $id)
    {
        $numberOfResource = $this->classe::destroy($id);
        if ($numberOfResource === 0)
            return response()->json(['Erro'=>'Recurso não encontrado'],404);
        return response()->json('',204);
    }
}
