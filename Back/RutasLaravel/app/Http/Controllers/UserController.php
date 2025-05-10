<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    // Funcion que saca todos los datos de la tabla
    public function listar(){

        // Saca todos los datos de la tabla
        //$vehiculos = vehiculo::all()->orderBy('vehiculoid', 'desc');
        $usuarios =  user::select('*')
        ->orderBy('usuarioid', 'desc')
        ->get();

        return response()->json([
            'code'     => '200',
            'status'    => 'success',
            'usuarios' =>  $usuarios
        ]);

    }

    public function crear(Request $request){

        $usuarionombre      =$request->usuarionombre;
        $usuariomail        =$request->usuariomail;
        $usuario            =$request->usuario;
        $usuariopassword    =$request->usuariopassword;
        $rolid              =$request->rolid;
        $sucursalid         =$request->sucursalid;

        // Valida el json que este bien formado
        if(!empty($request)){

            // Validad datos
            $validate = Validator::make($request->all(),[
                'usuarionombre'   => 'required',
                'usuariomail'     => 'required',
                'usuario'         => 'required',
                'usuariopassword' => 'required',
                'rolid'           => 'required',
                'sucursalid'      => 'required',

            ]);

            if ($validate->fails()){

                $data = array(
                    'status' => 'error',
                    'code'   => '404',
                    'message'=> 'El Usuario no se ha Creado',
                    'errors' => $validate->errors()
                );
            }else {

                // Cifrado de contesenia
                //$password = password_hash($params->usuariopassword,PASSWORD_BCRYPT,['cost'=>4]);

                $password= hash('sha256',$usuariopassword);

                // Crear el Usuario
                $user = new User();
                $user->usuarionombre    =$usuarionombre;
                $user->usuariomail      =$usuariomail;
                $user->usuario          =$usuario;
                $user->usuariopassword  =$password;
                $user->usuarioestatus   =1;
                $user->rolid            =$rolid;
                $user->sucursalid       =$sucursalid;

                // Guardar Usuario
                $user->save();

                $data = array(
                    'status' => 'success',
                    'code'   => '200',
                    'message'=> 'El Usuario se a Creado Correctamente'
                );
            }
        }else {
            $data = array(
                'status' => 'error',
                'code'   => '404',
                'message'=> 'Los Datos no son Correctos'
            );
        }

        return response()->json($data,$data['code']);

        //var_dump($params->usuarionombre);
        //var_dump($params_array);
        //die();


    }

    public function login(Request $request){
        $jwtAuth = new \App\Helpers\JwtAuth();
    
        $usuariomail = strtolower(trim($request->usuariomail));
        $usuariopassword = $request->usuariopassword;
    
        // Validación
        $validate = Validator::make($request->all(), [
            'usuariomail'     => 'required',
            'usuariopassword' => 'required',
        ]);
    
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => '404',
                'message'=> 'El Usuario no se ha Logueado',
                'errors' => $validate->errors()
            ], 404);
        }
    
        // Encriptar el password
        $password = hash('sha256', $usuariopassword);
    
        // 🔍 Debug temporal
        $usuarioEncontrado = User::where('usuariomail', $usuariomail)->first();
        if (!$usuarioEncontrado) {
            return response()->json([
                'status' => 'error',
                'code'   => 404,
                'message' => 'Correo no encontrado en la base de datos',
                'correo_enviado' => $usuariomail
            ], 404);
        }
    
        if ($usuarioEncontrado->usuariopassword !== $password) {
            return response()->json([
                'status' => 'error',
                'code'   => 401,
                'message' => 'Contraseña incorrecta',
                'password_esperado' => $usuarioEncontrado->usuariopassword,
                'password_enviado' => $password
            ], 401);
        }
    
        // Si todo está bien, genera el token
        $signup1 = $jwtAuth->signup($usuariomail, $password);
    
        return response()->json([
            'token' => $signup1
        ], 200);
    }
    

    public function update(Request $request){

        $usuarioid          =$request->usuarioid;
        $usuarionombre      =$request->usuarionombre;
        $usuariomail        =$request->usuariomail;
        $usuario            =$request->usuario;
        $usuariopassword    =$request->usuariopassword;
        $rolid              =$request->rolid;
        $sucursalid         =$request->sucursalid;

        if(!empty($request)){

            // Sacar usuario identificado
            //$user = $jwtAuth->checkToken($token,true);

            // Validad datos
            // Validad datos
            $validate = Validator::make($request->all(),[
                'usuarionombre'   => 'required',
                'usuariomail'     => 'required',
                'usuario'         => 'required',
                'usuariopassword' => 'required',
                'rolid'           => 'required',
                'sucursalid'      => 'required',

            ]);

            $password= hash('sha256',$usuariopassword);
            $params_array['usuarionombre']  =$usuarionombre;
            $params_array['usuariomail']    =$usuariomail;
            $params_array['usuario']        =$usuario;
            $params_array['usuariopassword']=$password;
            $params_array['rolid']          =$rolid;
            $params_array['sucursalid']     =$sucursalid;


            unset($params_array['created_at']);
            unset($params_array['updated_at']);
            unset($params_array['remember_token']);
            unset($params_array['usuarioestatus']);
            // actualizar el la bd
            $update =User::where('usuarioid',$usuarioid)->update($params_array);
            // devolver array con resultado
            $data = array(
                'status' => 'succes',
                'code'   => '200',
                'message'=> 'actualizado',
                'change' => $params_array
            );
        }else {
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message'=> 'El usuario no esta identificado'
            );
        }

        return response()->json($data,$data['code']);

    }

    public function cambio(Request $request){
        // recibe el valor de la cabecera
        $token = $request->header('Authorization');
        // Llama a la clase JwtAuth y cre una variable
        $jwtAuth = new \App\Helpers\JwtAuth();
        // le pasa el valor del token para decifrar
        $checkToken = $jwtAuth->checkToken($token);

        // Recoger datos
        $json=$request->input('json',null);
        $params= json_decode($json);// Objeto
        $params_array= json_decode($json,true);// Array

        if($checkToken && !empty($params_array)){

            // Sacar usuario identificado
            $user = $jwtAuth->checkToken($token,true);

            // Validad datos
            $validate = Validator::make($params_array,[
                'usuariopassword'   => 'required',
            ]);

            $password= hash('sha256',$params->usuariopassword);
            $params_array['usuariopassword']=$password;

            // actualizar el la bd
            $update =User::where('usuarioid',$user->usuarioid)->update($params_array);
            // devolver array con resultado
            $data = array(
                'status' => 'succes',
                'code'   => '200',
                'message'=> $user,
                'change' => $params_array
            );
        }else {
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message'=> 'El usuario no esta identificado'
            );
        }

        return response()->json($data,$data['code']);

    }

    public function upload(Request $request){

        $data = array(
            'status' => 'error',
            'code'   => '400',
            'message'=> 'Error al subir imagen'
        );

         return response()->json($data, $data['code']);

    }

    public function usuarioid($usuarioid){
        // Busca en la bd el usuario
        //$usuario = User::find($usuarioid);
        $usuario = DB::table('users')->where('usuarioid', $usuarioid)->first();

        if(is_object($usuario)){
            $data = array(
                'code'  =>200,
                'status'=>'success',
                'user'  =>$usuario
            );

        }else {
            $data = array(
                'code'  =>400,
                'status'=>'error',
                'user'  =>'El usuario no Existe'
            );

        }

        return response()->json($data, $data['code']);

    }

    public function activar($usuarioid, Request $request){
        // Recoger datos
        $json=$request->input('json',null);
        $params= json_decode($json);// Objeto
        $params_array= json_decode($json,true);// Array

        if(!empty($params_array)){

        // Validad datos
         $validate = Validator::make($params_array,[
            'usuarioid'       => 'required'
         ]);

         $usuario= User::where('usuarioid',$usuarioid)->update($params_array);

         $data = array(
            'status' => 'succes',
            'code'   => '200',
            'usuario'=> $params_array,
        );

        }else{
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message'=> 'No se ha Enviado Ninguna '
            );

        }

        return response()->json($data,$data['code']);

    }

}
