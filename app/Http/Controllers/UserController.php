<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function validateCreate(Request $request, UserService $userService){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'    
        ]);

        
      
    return $userService->createUser($request);
    }

    public function validateList(UserService $userService){

        return $userService->listUsers();
    }

    public function validateUpdate(Request $request, UserService $userService){
         $request->validate([
            'name' => 'nullable',
            'email' => 'required|email',
            'password' => 'nullable',
            'role' => 'nullable'    
        ]);

        return $userService->updateUser($request);
    }

    public function validateDelete($id, UserService $userService){

        return $userService->deleteUser($id);
        
    }

}
