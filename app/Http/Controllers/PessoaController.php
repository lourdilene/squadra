<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePessoaRequest;
use App\Http\Resources\PessoaResource;
use App\Models\Pessoa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//use function GuzzleHttp\Psr7\Utils;

class PessoaController extends Controller
{
    /**
     * @OA\Get(
     *      path="/pessoa",
     *      operationId="getPessoaList",
     *      tags={"Pessoa"},
     *      summary="Lista de pessoas",
     *      description="Retorna lista de pessoas",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PessoaCollection")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     *
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
     * @OA\Post(
     *     path="/api/pessoa",
     *     operationId="storePessoa",
     *     tags={"Pessoa"},
     *     summary="Cadastra nova pessoa",
     *     description="Retorna mensagem de sucesso",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreUpdatePessoaRequest"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Pessoa cadastrada com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="messagem",
     *                  type="string",
     *                  example="Pessoa cadastrada com sucesso."
     *              ),
     *          ),
     *       ),
     *      @OA\Response(
     *          response=503,
     *          description="Erro ao tentar cadastrar pessoa.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="messagem",
     *                  type="string",
     *                  example="Não foi possível cadastrar a pessoa."
     *              ),
     *          ),
     *      )
     * )
     *
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
