<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Services\PagamentoOrquestrador;
use App\Models\Clients;


class TransactionController extends Controller
{
    public function validatePurchase (Request $request, PagamentoOrquestrador $orquestrador){

    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'name' => 'required|string',
        'email' => 'required|email',
        'cardNumber' => 'required|string|size:16',
        'cvv' => 'required|string|size:3'
    ]);

    $product = Products::findOrFail($request->product_id);
    $totalAmount = ($product->amount * $request->quantity);

    try {
        $paymentData = [
            'amount' => $totalAmount,
            'name' => $request->name,
            'email' => $request->email,
            'cardNumber' => $request->cardNumber,
            'cvv' => $request->cvv
            ];

            $client = Clients::firstOrCreate(
                ['email' => $request->email],
                ['name'  => $request->name]
            );

            $paymentResult = $orquestrador->processarPagamento($paymentData);
            

            $transaction = Transactions::create([
                'client_id'         => $client->id,      
                'product_id'        => $product->id,     
                'quantity'          => $request->quantity,
                'gateway'           => $paymentResult['gateway'],
                'external_id'       => $paymentResult['resposta']['id'] ?? null,
                'status'            => 'paid',
                'amount'            => $totalAmount,
                'card_last_numbers' => substr($request->cardNumber, -4),
            ]);

            return response()->json([
                'message' => 'Compra realizada com sucesso!',
                'transaction' => $transaction
            ], 201);

    }catch (\Exception $e){
        return response()->json([
                'message' => 'Erro ao processar compra',
                'error' => $e->getMessage()
            ], 422);
    }
    }


    public function getTransaction($id){
        $transaction = Transactions::where('id',$id)->first();
        
        return response()->json([
            'transaction' => $transaction
        ]);

    }
    public function getTransactions(){
        $transaction = Transactions::all();
        
        return response()->json([
            'transactions' => $transaction
        ]);

    }
}
