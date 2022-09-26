<?php

namespace App\Repositories;

use App\Http\Requests\StorePessoaRequest;
use App\Models\Endereco;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EloquentPessoaRepository implements PessoaRepository
{
    public function add(StorePessoaRequest $request): Pessoa
    {
        return DB::transaction(function () use ($request) {
            $pessoa= new Pessoa($request->all());
            $pessoa->save();

            foreach ($request->enderecos as $endereco) {
                $enderecos[] = array_merge($endereco, ['codigo_pessoa'=>$pessoa->codigo_pessoa]);
            }
            Endereco::insert($enderecos);

            return $pessoa;
        });
    }

    public function update($request,$id): Pessoa
    {
        return DB::transaction(function () use ($request, $id) {
            $pessoa = Pessoa::findOrFail($id);
            $pessoa->fill($request->all());
            $pessoa->save();

            foreach ($request->enderecos as $endereco) {

                if (!isset($endereco['codigoEndereco'])){

                    $novosEnderecos[] = new Endereco([
                        //$teste
                        'codigo_bairro' => $endereco['codigoBairro'],
                        'codigo_pessoa' => $id,
                        'nome_rua' => $endereco['nomeRua'],
                        'numero' => $endereco['numero'],
                        'complemento' => $endereco['complemento'],
                        'cep' => $endereco['cep']
                    ]);
                }

                if (isset($endereco['codigoEndereco'])){

                    $enderecosParaAtualizar = [
                        'codigo_endereco' => $endereco['codigoEndereco'],
                        'codigo_bairro' => $endereco['codigoBairro'],
                        'nome_rua' => $endereco['nomeRua'],
                        'numero' => $endereco['numero'],
                        'complemento' => $endereco['complemento'],
                        'cep' => $endereco['cep']
                    ];

                    Log::alert('Para atualizar',[$enderecosParaAtualizar]);

                    $pessoa->enderecos()->where('codigo_endereco', $endereco['codigoEndereco'])->update($enderecosParaAtualizar);

                    $codigosEnderecoRequest[] = $endereco['codigoEndereco'];
                }
            }

            //$user = Endereco::first();

            //dd($user->toArray());

//            Log::alert('novos enderecos',[$novosEnderecos]);
            $pessoa->enderecos()->whereNotIn('codigo_endereco', $codigosEnderecoRequest)->delete();
            $pessoa->enderecos()->saveMany($novosEnderecos);

            return $pessoa;
        });
    }
}
