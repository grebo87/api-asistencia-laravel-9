<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use PasswordValidationRules;

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        return response()->json(['data' => $request->user()]) ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users = User::jsonPaginate();

        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ]
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all(), 'status' => false, 'message' => 'Error de validacion']);
        }

        // $pass = Str::random();
        $pass = 'abc123def';

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($pass),
        ]);

        return response()->json([
            'status' =>true,
            'message' => 'Usuario creado',
            'data' => UserResource::make($user) 
        ],201);
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $user = User::find($id);
        if(empty($user)){
            return response()->json(['erros' => 'Usuario no encontrado', 'status' => false], 404);
        }

        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $user = User::find($id);

        if(empty($user)){
            return response()->json(['erros' => 'Usuario no encontrado', 'status' => false], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ]
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all(), 'status' => false, 'message' => 'Error de validacion']);
        }

        $user->fill($request->all());
        $user->save();

        return response()->json([
            'data' => UserResource::make($user), 
            'message' => 'Usuario modificado',
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

     public function destroy($id)
     {
        $user = User::find($id);

        if(empty($user)){
            return response()->json(['erros' => 'Usuario no encontrado', 'status' => false], 404);
        }

        if (request()->user()->id == $user->id) {
            return response()->json([
                'message' => 'No puedes eliminar tu propio usuario',
                'status' => false
            ], 403);
        }

        if($user->delete()){
            return response()->json([
                'message' => 'Usuario eliminado',
                'status' => true
            ]);
        }

        return response()->json([
            'message' => 'Usuario no eliminado',
            'status' => false
        ]);
     }
}
