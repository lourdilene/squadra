<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePessoaRequest;
use App\Models\Pessoa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//use function GuzzleHttp\Psr7\Utils;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            $pessoas = Pessoa::all();
            if (!$pessoas){
                return response()->json([]);
            }
            return response()->json($pessoas);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível pesquisar a Pessoa.',
                'status' => '503'
            ],503);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUpdatePessoaRequest $request)
    {
        try{
            Pessoa::create($request->all());
            return response()->json([
                'mensagem' => 'Pessoa cadastrada com sucesso.',
            ]);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível cadastrar a pessoa.',
                'status' => '503'
            ],503);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdatePessoaRequest $request, int $id)
    {
        try{
            $pessoa = Pessoa::findOrFail($id);
            $pessoa->fill($request->all());
            $pessoa->save();

            return response()->json([$pessoa]);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível alterar a Pessoa.',
                'status' => '503'
            ],503);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
