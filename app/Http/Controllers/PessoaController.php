<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Http\Resources\PessoaResource;
use App\Models\Pessoa;
use App\Repositories\PessoaRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PessoaController extends Controller
{
    protected $classe = Pessoa::class;

    public function __construct(private PessoaRepository $pessoaRepository)
    {
    }

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
     *          @OA\JsonContent(ref="#/components/schemas/Pessoa")
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
    public function index(Request $request)
    {
        try{
            $parametros = $request->input();

            if ($parametros){
                foreach ($parametros as $index => $parametro) {
                    $clausulasWhere[] = [Str::snake($index, '_'), '=', $parametro];
                }
                $resource = $this->classe::Where($clausulasWhere)->get()->first();

                if (!$resource){
                    return response()->json([]);
                }
                return response()->json(new PessoaResource($resource));
            }

            return response()->json(PessoaResource::collection($this->classe::all()));

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
     *          @OA\JsonContent(ref="#/components/schemas/StorePessoaRequest"),
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
    public function store(StorePessoaRequest $request)
    {
        try{
            $this->pessoaRepository->add($request);

            return response()->json([
                'mensagem'=>'Pessoa cadastrada com sucesso.'
            ],200);

        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível cadastrar a pessoa.',
                'status' => '503'
            ],503);
        }
    }

    public function update(UpdatePessoaRequest $request, int $id)
    {
        try{
            $pessoa = $this->pessoaRepository->update($request, $id);

            return response()->json(
                PessoaResource::collection($pessoa::all())
            ,200);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json([
                'mensagem'=>'Não foi possível alterar a Pessoa.',
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
