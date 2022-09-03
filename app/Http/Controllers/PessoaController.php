<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePessoaRequest;
use App\Http\Requests\UpdateUfRequest;
use App\Http\Resources\EnderecoCollection;
use App\Http\Resources\EnderecoResource;
use App\Http\Resources\PessoaResource;
use App\Models\Endereco;
use App\Models\Pessoa;
use App\Models\Uf;
use App\Repositories\PessoaRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\Input;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

//use function GuzzleHttp\Psr7\Utils;

class PessoaController extends Controller
{
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
//            Pessoa::create($request->all());
//            return response()->json([
//                'mensagem' => 'Pessoa cadastrada com sucesso.',
//            ]);

            //Pessoa::create($request->all());
            return response()->json($this->pessoaRepository->add($request), 200);
            //return response()->json($request->all()));

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

            $enderecosCodigo = [];
            foreach ($request->enderecos as $endereco) {

                Log::alert('isset',[isset($endereco['codigoEndereco'])]);

                if (!isset($endereco['codigoEndereco'])){

                    Log::alert('não tem código endereco',[$endereco]);

                    $novosEnderecos[] = new Endereco([
                        'codigo_bairro' => $endereco['codigoBairro'],
                        'codigo_pessoa' => $id,
                        'nome_rua' => $endereco['nomeRua'],
                        'numero' => $endereco['numero'],
                        'complemento' => $endereco['complemento'],
                        'cep' => $endereco['cep']
                    ]);
                }

                if (isset($endereco['codigoEndereco'])){

                    $teste = [
                        //'codigo_pessoa' => $pessoa->codigo_pessoa,
                        'codigo_endereco' => $endereco['codigoEndereco'],
                        'codigo_bairro' => $endereco['codigoBairro'],
                        'nome_rua' => $endereco['nomeRua'],
                        'numero' => $endereco['numero'],
                        'complemento' => $endereco['complemento'],
                        'cep' => $endereco['cep']
                    ];

                    $pessoa->enderecos()->where('codigo_endereco', $endereco['codigoEndereco'])->update($teste);

                    $enderecosCodigo[] = $endereco['codigoEndereco'];
                }
            }

            $pessoa->enderecos()->whereNotIn('codigo_endereco', $enderecosCodigo)->delete();
            $pessoa->enderecos()->saveMany($novosEnderecos);

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

    public function filter(Request $request)
    {
        $parametros = $request->input();

        if ($parametros){
            foreach ($parametros as $index => $parametro) {
                $indexConvertido = Str::snake($index, '_');
                $clausulasWhere[] = [$indexConvertido, '=', $parametro];
            }

            return response()->json(Pessoa::Where($clausulasWhere)->get());
        }

        return response()->json(Pessoa::all());
    }
}
