<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUfRequest;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MunicipioController
{
    protected $classe = Municipio::class;

    public function index(Request $request)
    {
        return $this->classe::paginate($request->per_page);
    }

    public function store(StoreUpdateUfRequest $request)
    {
        Log::alert('Prepara Uf',[$request]);
        return response()->json($this->classe::create($request->all(),201));
    }

    public function show(int $id)
    {
        $resource = $this->classe::find($id);

        if (is_null($resource))
            return response()->json($resource,204);
        return response()->json($resource);
    }

    public function update(int $id, StoreUpdateUfRequest $request)
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
