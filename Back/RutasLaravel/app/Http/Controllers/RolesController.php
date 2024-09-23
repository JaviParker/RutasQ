<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
// Llama al Modelo el cual es el que tiene la tabla de la bd
use App\Models\rol;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{

    // Funcion que saca todos los datos de la tabla
    public function listar(){

        // Saca todos los datos de la tabla
        $rol = Rol::all();

        return response()->json([
            'code'      => '200',
            'status'    => 'success',
            'rol'       =>  $rol

        ]);

    }

    public function crear(Request $request){

        $date = Carbon::now();

         // Recoger datos
        $rolnombre  =$request->rolnombre;
        $usuarioid  =$request->usuarioid;

        if(!empty($request)){

            // Validad datos
            $validate = Validator::make($request->all(),[
               'rolnombre'         => 'required'
            ]);

         if($validate->fails()){
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message'=> 'Error al Registrar'
            );

         }else {
             $rol = new rol();
             $rol->rolnombre    = $rolnombre;
             $rol->rolfecha     = $date->toDateString();
             $rol->rolestatus   = 1;
             $rol->usuarioid    = $usuarioid;
             $rol->save();

             $data = array(
                'status'    => 'succes',
                'code'      => '200',
                'rol'       => $rol,
            );
         }

        }else {

            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message'=> 'No se ha Enviado Ningun Registro'
            );


        }


         return response()->json($data,$data['code']);



    }

    public function actualizar(Request $request){

        $date = Carbon::now();

         // Recoger datos
         $rolid       =$request->rolid;
         $rolnombre  =$request->rolnombre;
         $usuarioid  =$request->usuarioid;

        if(!empty($request)){

         // Validad datos
         $validate = Validator::make($request->all(),[
            'rolid'        => 'required',
            'rolnombre'    => 'required'
         ]);

         $rol_array['rolnombre']  =$rolnombre;
         $rol_array['usuarioid']  =$usuarioid;

         $rol= Rol::where('rolid',$rolid)->update($rol_array);

         $data = array(
            'status'   => 'succes',
            'code'     => '200',
            'rol'      => $rol,
        );

        }else{
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message'=> 'No se ha Enviado Ningun Registro'
            );

        }

        return response()->json($data,$data['code']);

    }









}
