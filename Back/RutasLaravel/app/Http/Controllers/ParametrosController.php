<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
// Llama al Modelo el cual es el que tiene la tabla de la bd
use App\Models\Parametro;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

class ParametrosController extends Controller
{

    // Funcion que saca todos los datos de la tabla
    public function listar()
    {

        // Saca todos los datos de la tabla
        $parametro = Parametro::all();

        return response()->json([
            'code'     => '200',
            'status'    => 'success',
            'parametro' =>  $parametro

        ]);
    }

    public function crear(Request $request)
    {

        $date = Carbon::now();

        // Recoger datos
        $parametronombre       = $request->parametronombre;
        $parametrodescripcion  = $request->parametrodescripcion;
        $parametrovalor        = $request->parametrovalor;
        $parametrofecha        = $request->parametrofecha;
        $usuarioid             = $request->usuarioid;

        if (!empty($request)) {

            // Validad datos
            $validate = Validator::make($request->all(), [
                'parametronombre'         => 'required',
                'parametrodescripcion'    => 'required',
                'parametrovalor'          => 'required',
                'parametrofecha'          => 'required'
            ]);

            if ($validate->fails()) {
                $data = array(
                    'status' => 'error',
                    'code'   => '400',
                    'message' => 'Error al Registrar'
                );
            } else {
                $parametro = new parametro();
                $parametro->parametronombre          = $parametronombre;
                $parametro->parametrodescripcion     = $parametrodescripcion;
                $parametro->parametrovalor           = $parametrovalor;
                $parametro->parametrofecha           = $parametrofecha;
                $parametro->parametroestatus         = 1;
                $parametro->usuarioid                = $usuarioid;
                $parametro->save();

                $data = array(
                    'status'    => 'succes',
                    'code'      => '200',
                    'parametro' => $parametro,
                );
            }
        } else {

            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message' => 'No se ha Enviado Ningun Registro'
            );
        }


        return response()->json($data, $data['code']);
    }

    public function actualizar(Request $request)
    {

        // Recoger datos
        $parametroid           = $request->parametroid;
        $parametronombre       = $request->parametronombre;
        $parametrodescripcion  = $request->parametrodescripcion;
        $parametrovalor        = $request->parametrovalor;
        $parametrofecha        = $request->parametrofecha;


        if (!empty($request)) {

            // Validad datos
            $validate = Validator::make($request->all(), [
                'parametronombre'         => 'required',
                'parametrodescripcion'    => 'required',
                'parametrovalor'          => 'required',
                'parametrofecha'          => 'required'
            ]);

            $parametro_array['parametronombre']      = $parametronombre;
            $parametro_array['parametrodescripcion'] = $parametrodescripcion;
            $parametro_array['parametrovalor']       = $parametrovalor;
            $parametro_array['parametrofecha']       = $parametrofecha;

            $parametro = parametro::where('parametroid', $parametroid)->update($parametro_array);

            $data = array(
                'status' => 'succes',
                'code'   => '200',
                'parametro' => $parametro,
            );
        } else {
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message' => 'No se ha Enviado Ningun Registro'
            );
        }

        return response()->json($data, $data['code']);
    }

    public function cierre(Request $request)
    {

        $parametro =  parametro::select('parametrofecha')
            ->where('parametroid', 1)
            ->orderBy('parametroid', 'desc')
            ->first();

        $date = Carbon::parse($parametro->parametrofecha);

        $parametro_array['parametrofecha'] = $date->addDays(1);
        $parametro = parametro::where('parametroid', 1)->update($parametro_array);

        $data = array(
            'status' => 'succes',
            'code'   => '200',
            'parametro' => $parametro,
        );

        return response()->json($data, $data['code']);
    }

    public function activar($parametroid,Request $request)
    {
        $parametroestatus         = $request->parametroestatus;

        if (!empty($parametroid)) {

            $parametro_array['parametroestatus']      = $parametroestatus;

            $parametro = parametro::where('parametroid', $parametroid)->update($parametro_array);

            $data = array(
                'status' => 'succes',
                'code'   => '200',
                'parametro' => $parametro,
            );
        } else {
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message' => 'No se ha Enviado Ningun Registro'
            );
        }

        return response()->json($data, $data['code']);
    }

    public function desactivar($parametroid,Request $request)
    {
        $parametroestatus         = $request->parametroestatus;

        if (!empty($parametroid)) {

            $parametro_array['parametroestatus']      = $parametroestatus;

            $parametro = parametro::where('parametroid', $parametroid)->update($parametro_array);

            $data = array(
                'status' => 'succes',
                'code'   => '200',
                'parametro' => $parametro,
            );
        } else {
            $data = array(
                'status' => 'error',
                'code'   => '400',
                'message' => 'No se ha Enviado Ningun Registro'
            );
        }

        return response()->json($data, $data['code']);
    }
}
