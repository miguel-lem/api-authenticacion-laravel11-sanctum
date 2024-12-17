<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    //funcion para ingrear un registro
    public function register(Request $request){
        //validacion de datos
        $validator = Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'email|string|unique:users',
            'password'=>'required|string|confirmed'
        ]);
        //en caso de fallo de validador
        if($validator->fails()){
            return Response()->json([
                'message'=>'Los datos no estan bien escritos',
                'errors'=>$validator->errors()
            ]);
        }
        //insersion de usuario a la tabla
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password) 
        ]);
        //respuestas
        if (!$user) {
            //respuesta de fallo
            $data = [
                'message' => 'Error al crear el usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }else{
            //respuesta exitosa
            $token = $user->createToken('Apitoken')->plainTextToken; //generacion de token
            return Response()->json([
                'message'=>'Los datos se registraron',
                'content'=>$user,
                'token'=>$token
            ]);
        }
    }
    //funcion para iniciar sesion
    public function login(Request $request){
        //validacion de datos
        if(!Auth::attempt($request->only('email','password'))){//busqueda en la db para validar datos
            return Response()->json([
                'message'=>'No autorizado a iniciar sesion'
            ]);
        }
        //busqueda de dato en la db
        $user = User::where('email',$request->email)->first();
        $token = $user->createToken('Apitoken')->plainTextToken;//creacion de token
        return Response()->json([
            'message'=>'Se inicio la sesion',
            'token'=>$token
        ]);
    }
    //funcion para cerrar sesion
    public function logout(){
        //$user = new User();
        auth()->user()->tokens()->delete();

        return Response()->json([
            'message'=>'se cerro la sesion',
            'status'=>201
        ]);
    }
}
