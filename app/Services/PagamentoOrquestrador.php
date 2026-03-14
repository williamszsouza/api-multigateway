<?php

namespace App\Services;

use App\Models\Gateway; 
use Exception;
use Illuminate\Support\Facades\Log;

class PagamentoOrquestrador
{
    protected array $mapaGateways = [
        'gateway_1' => Gateway1Service::class,
        'gateway_2' => Gateway2Service::class,
    ];

    public function processarPagamento(array $dados)
    {
        $gatewaysNoBanco = Gateway::where('is_active', true)
            ->orderBy('priority', 'asc')
            ->get();

        if ($gatewaysNoBanco->isEmpty()) {
            throw new Exception("Nenhum gateway de pagamento está ativo no sistema.");
        }

        $ultimoErro = null;

        foreach ($gatewaysNoBanco as $registro) {
            try {
                $classeNome = $this->mapaGateways[$registro->name] ?? null;

                if (!$classeNome) {
                    Log::error("Gateway '{$registro->name}' definido no banco não possui Service implementado.");
                    continue; 
                }

                $gateway = new $classeNome();
                $resultado = $gateway->cobrar($dados);

                return [
                    'sucesso'  => true,
                    'gateway'  => $registro->name,
                    'resposta' => $resultado
                ];

            } catch (Exception $e) {
                $ultimoErro = $e->getMessage();
                Log::warning("Falha no gateway {$registro->name}: {$ultimoErro}");
            }
        }

        throw new Exception("Pagamento recusado em todos os gateways ativos. Último erro: " . $ultimoErro);
    }
}