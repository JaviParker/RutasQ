<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
// Llama al Modelo el cual es el que tiene la tabla de la bd
use App\Models\sucursal;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

class SucursalesController extends Controller
{

    // Funcion que saca todos los datos de la tabla
    public function listar(){

        // Saca todos los datos de la tabla
        $sucursal = Sucursal::all();

        return response()->json([
            'code'      => '200',
            'status'    => 'success',
            'sucursal'  =>  $sucursal

        ]);

    }

    public function crear(Request $request){

        $date = Carbon::now();

         // Recoger datos
        $sucursalnombre  =$request->sucursalnombre;
        $usuarioid       =$request->usuarioid;

        if(!empty($request)){

            // Validad datos
            $validate = Validator::make($request->all(),[
               'sucursalnombre'         => 'required'
            ]);

         if($validate->fails()){
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message'=> 'Error al Registrar'
            );

         }else {
             $sucursal = new sucursal();
             $sucursal->sucursalnombre    = $sucursalnombre;
             $sucursal->sucursalfecha     = $date->toDateString();
             $sucursal->sucursalestatus   = 1;
             $sucursal->usuarioid         = $usuarioid;
             $sucursal->save();

             $data = array(
                'status'    => 'succes',
                'code'      => '200',
                'sucursal'  => $sucursal,
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
         $sucursalid      =$request->sucursalid;
         $sucursalnombre  =$request->sucursalnombre;
         $usuarioid       =$request->usuarioid;

        if(!empty($request)){

         // Validad datos
         $validate = Validator::make($request->all(),[
            'sucursalid'        => 'required',
            'sucursalnombre'    => 'required'
         ]);

         $sucursal_array['sucursalnombre']  =$sucursalnombre;
         $sucursal_array['usuarioid']       =$usuarioid;

         $sucursal= Sucursal::where('sucursalid',$sucursalid)->update($sucursal_array);

         $data = array(
            'status'   => 'succes',
            'code'     => '200',
            'sucursal' => $sucursal,
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
