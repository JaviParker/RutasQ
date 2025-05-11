<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\parametro;



class JwtAuth{

    public $key;

    public function __construct(){
        $this->key = 'ModuloII';
    }

    // Funcion
    public function signup($usuariomail, $usuariopassword, $getToken = null){

        // Busca si existe el usuario
        $user =User::where([
            'usuariomail'=>$usuariomail,
            'usuariopassword'=>$usuariopassword,
            'usuarioestatus'=>1
        ])->first();

        $parametro =parametro::where([
            'parametroid'=>1
        ])->first();

        // Comprobar si existe
        $signup = false;
        if (is_object($user)){
            $signup = true;
        }

        // Genera token
        if($signup){
            $token= array(
                'usuarioid'     => $user->usuarioid,
                'usuarionombre' => $user->usuarionombre,
                'usuariomail'   => $user->usuariomail,
                'usuario'       => $user->usuario,
                'fecha'         => time(),
                'caduca'        => time()+(7*24*60*60),//Dias Horas minutos segundos
                'rol'           => 'Administrador',
                'exp'           => time()+(60),
                'rolid'         => $user->rolid,
                'fecha'         => $parametro->parametrofecha,
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);

            // devolver las datos decodificados del token
            if(is_null($getToken)){
                $data= $jwt;
            }else{
                $data= $decoded;
            }

        }else {
            $data = array(
                'status'=> 'error',
                'message'=> 'Login incorrecto'
            );

        }
        return $data;
    }

    public function checkToken($jwt, $getIdentity = false){
        // Variable falsa
        $auth = false;
        try {
            // quita las comillas del token
            $jwt=str_replace('"','',$jwt);
            // Decencripta el token
            $decoded = JWT::decode($jwt,$this->key,['HS256']);
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
        }
        // si  $decoded tiene datos y es un objeto y tiene el id
        if(!empty($decoded) && is_object($decoded) && isset($decoded->usuarioid)){
            $auth=true;
        }else {
            $auth = false;
        }
        if ($getIdentity){
            return $decoded;
        }
        return $auth;




    }


}
