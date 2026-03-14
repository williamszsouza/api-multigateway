<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class Gateway1Service
{
    private string $baseUrl = 'http://gateways-mock:3001';

    public function cobrar(array $dados)
    {
        $auth = Http::post("{$this->baseUrl}/login", [
            'email' => 'dev@betalent.tech',
            'token' => 'FEC9BB078BF338F464F96B48089EB498'
        ]);

        if ($auth->failed()) {
            throw new Exception("Falha na autenticação com Gateway 1.");
        }

        $token = $auth->json('token');

        $response = Http::withToken($token)->post("{$this->baseUrl}/transactions", [
            'amount'     => $dados['amount'],
            'name'       => $dados['name'],
            'email'      => $dados['email'],
            'cardNumber' => $dados['cardNumber'],
            'cvv'        => $dados['cvv']
        ]);

        if ($response->failed()) {
            throw new Exception("Gateway 1 recusou a transação: " . ($response ?? 'Erro desconhecido'));
        }

        return $response->json();
    }
}