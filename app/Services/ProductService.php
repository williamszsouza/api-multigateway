<?php

namespace App\Services;

use App\Models\Products;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProductService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createProduct($data){
        
        DB::beginTransaction();
    try{
        
        $product = new Products();
        $product->name = $data->name;
        $product->quantity = $data->amount;
        $product->save();

        DB::commit();

        return response()->json([
            'message' => 'Produto criado com sucesso!',
            'Product' => $product,
        ],200);
    }catch (\Exception $e){
        DB::rollback();
        return response()->json([
            'message' => 'erro ao criar produto',
            'error' => $e
        ],500);
    }
        
    }


    public function listProducts(){
        $products = Products::all();

        return response()->json([
            'Products' => $products
        ]);
    }

    public function updateProduct($data){
        DB::beginTransaction();
        try{
            $product = Products::where('id',$data->id)->first();

            if($data->has('name')){
                $product->name = $data->name;
            }
            if($data->has('amount')){
                $product->quantity = $data->amount;
            }
            
            $product->save();

            DB::commit();

            return response()->json([
                'message' => 'Produto atualizado com sucesso',
                'Product' => $product
            ],200);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar produto',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function deleteProduct($id){

        DB::beginTransaction();

        try{
            $product = Products::findOrFail($id);
            $product->delete();

            DB::commit();

            return response()->json([
              'message'  => 'Produto deletado com sucesso'
            ],200);
        }catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Erro ao tentar excluir o produto.',
            'error' => $e->getMessage()
        ], 500);
    }
        }
        
    }



