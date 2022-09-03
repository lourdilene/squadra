<?php

namespace App\Repositories;

use App\Http\Requests\StoreUpdatePessoaRequest;
use App\Models\Endereco;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EloquentPessoaRepository implements PessoaRepository
{
    public function add(StoreUpdatePessoaRequest $request): Pessoa
    {
        return DB::transaction(function () use ($request) {
            $pessoa= new Pessoa($request->all());
            $pessoa->save();

            Log::alert('request teste',[$pessoa]);

            foreach ($request->enderecos as $endereco) {
                Log::alert('enderecoRepostity',[$request->enderecos]);
                $enderecos[] = [
                    'codigo_pessoa' => $pessoa->codigo_pessoa,
                    //'codigo_endereco' => $endereco['codigoEndereco'],
                    'codigo_bairro' => $endereco['codigoBairro'],
                    'nome_rua' => $endereco['nomeRua'],
                    'numero' => $endereco['numero'],
                    'complemento' => $endereco['complemento'],
                    'cep' => $endereco['cep']
                ];
            }

            Endereco::insert($enderecos);

            return $pessoa;
        });
    }
}
