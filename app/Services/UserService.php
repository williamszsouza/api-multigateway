<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createUser($data){
        
        DB::beginTransaction();
    try{
        
        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->role = $data->role;
        $user->password = Hash::make($data->password);
        $user->save();

        DB::commit();

        return response()->json([
            'message' => 'usuário criado com sucesso!',
            'user' => $user,
        ],200);
    }catch (\Exception $e){
        DB::rollback();
        return response()->json([
            'message' => 'erro ao criar usuário',
            'error' => $e
        ],500);
    }
        
    }


    public function listUsers(){
        $users = User::all();

        return response()->json([
            'users' => $users
        ]);
    }

    public function updateUser($data){
        DB::beginTransaction();
        try{
            $user = User::where('email',$data->email)->first();

            if($data->has('password')){
                $user->password = Hash::make($data->password);
            }
            if($data->has('name')){
                $user->password = Hash::make($data->name);
            }
            if($data->has('role')){
                $user->password = Hash::make($data->role);
            }

            $user->save();

            DB::commit();

            return response()->json([
                'message' => 'usuário atualizado com sucesso',
                'user' => $user
            ],200);

        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Erro ao atualizar usuário',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function deleteUser($id){

        DB::beginTransaction();

        try{
            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();

            return response()->json([
              'message'  => 'Usuario deletado com sucesso'
            ],200);
        }catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Erro ao tentar excluir o usuário.',
            'error' => $e->getMessage()
        ], 500);
    }
        }
        
    }



