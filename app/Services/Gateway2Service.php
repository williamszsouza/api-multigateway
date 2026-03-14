<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class Gateway2Service
{
    private string $baseUrl = 'http://gateways-mock:3002';

   public function cobrar(array $dados)
{
    $response = Http::withHeaders([
        'Gateway-Auth-Token' => 'tk_f2198cc671b5289fa856',
        'Gateway-Auth-Secret' => '3d15e8ed6131446ea7e3456728b1211f'
    ])->post("{$this->baseUrl}/transacoes", [
        'valor'        => $dados['amount'],
        'nome'         => $dados['name'],
        'email'        => $dados['email'],
        'numeroCartao' => $dados['cardNumber'],
        'cvv'          => $dados['cvv']
    ]);

    $dadosJson = $response->json();

    if ($response->failed() || !isset($dadosJson['id'])) {
        throw new Exception("Gateway 2 recusou: " . ($dadosJson['mensagem'] ?? 'Resposta sem ID de transação'));
    }

    return $dadosJson;
}
}