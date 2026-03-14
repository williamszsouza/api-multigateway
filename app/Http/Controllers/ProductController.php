<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;



class ProductController extends Controller
{
     public function validateCreate(Request $request, ProductService $ProductService){
        $request->validate([
            'name' => 'required',
            'amount' => 'required',    
        ]);

        
      
    return $ProductService->createProduct($request);
    }

    public function validateList(ProductService $ProductService){

        return $ProductService->listProducts();
    }

    public function validateUpdate(Request $request, ProductService $ProductService){
         $request->validate([
            'id' => 'required',
            'name' => 'nullable',
            'amount' => 'nullable',
        ]);

        return $ProductService->updateProduct($request);
    }

    public function validateDelete($id, ProductService $ProductService){

        return $ProductService->deleteProduct($id);
        
    }

}
