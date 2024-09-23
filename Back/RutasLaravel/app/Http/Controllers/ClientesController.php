<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
// Llama al Modelo el cual es el que tiene la tabla de la bd
use App\Models\Cliente;
use App\Models\Sucursal;
use Carbon\Carbon;
//
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{

    // Funcion que saca todos los datos de la tabla
    public function listar(){

        // Funcion que saca todos los datos de la tabla
        $cliente = cliente::select('cliente.clienteid','cliente.clientenombre','cliente.clientenumero','cliente.sucursalid','sucursal.sucursalnombre')
        ->join('sucursal', 'sucursal.sucursalid', '=', 'cliente.sucursalid')
        ->orderBy('clienteid','desc')
        ->get();

        return response()->json([
        'code'      => '200',
        'status'    => 'success',
        'cliente'    =>  $cliente

]);

    }

    public function crear(Request $request){

        $date = Carbon::now();

         // Recoger datos
        $clientenombre  =$request->clientenombre;
        $clientenumero  =$request->clientenumero;
        $sucursalid     =$request->sucursalid;
        $usuarioid      =$request->usuarioid;

        if(!empty($request)){

            // Validad datos
            $validate = Validator::make($request->all(),[
               'clientenombre'         => 'required',
               'clientenumero'         => 'required',
               'sucursalid'            => 'required'
            ]);

         if($validate->fails()){
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message'=> 'Error al Registrar'
            );

         }else {
             $cliente = new cliente();
             $cliente->clientenombre    = $clientenombre;
             $cliente->clientenumero    = $clientenumero;
             $cliente->clientefecha     = $date->toDateString();
             $cliente->clienteestatus   = 1;
             $cliente->sucursalid       = $sucursalid;
             $cliente->usuarioid         = $usuarioid;
             $cliente->save();

             $data = array(
                'status'    => 'succes',
                'code'      => '200',
                'cliente'   => $cliente,
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
         $clienteid      =$request->clienteid;
         $clientenombre  =$request->clientenombre;
         $clientenumero  =$request->clientenumero;
         $sucursalid     =$request->sucursalid;
         $usuarioid      =$request->usuarioid;

        if(!empty($request)){

         // Validad datos
         $validate = Validator::make($request->all(),[
            'clienteid'             => 'required',
            'clientenombre'         => 'required',
            'clientenumero'         => 'required',
            'sucursalid'            => 'required',
            'usuarioid'             => 'required'
         ]);

         $cliente_array['clientenombre']  =$clientenombre;
         $cliente_array['clientenumero']  =$clientenumero;
         $cliente_array['sucursalid']     =$sucursalid;
         $cliente_array['usuarioid']      =$usuarioid;

         $cliente= cliente::where('clienteid',$clienteid)->update($cliente_array);

         $data = array(
            'status'   => 'succes',
            'code'     => '200',
            'cliente'  => $cliente,
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
