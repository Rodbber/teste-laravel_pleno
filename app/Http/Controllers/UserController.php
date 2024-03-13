<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request){
        return $this->applyFilters($request, User::class);
    }

    public function store(UserRequest $request){
        try {
            $create = $request->all();
            $password = Hash::make(Str::random());
            $create['password'] = $password;
            $user = User::create($create);
            return response()->json(['message' => "user criado com sucesso", 'data' => $user]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "erro ao tentar criar novo usuario"], 500);
        }
    }

    public function update(UserRequest $request, $id){
        try {
            User::find($id)->update($request->all());
            return response()->json(['message' => "user atualizado com sucesso"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "erro ao tentar atualizar novo usuario"], 500);
        }
    }

    public function destroy($id){
        try {
            User::find($id)->delete();
            return response()->json(['message' => "user excluido com sucesso"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "erro ao tentar excluir novo usuario"], 500);
        }
    }
}
