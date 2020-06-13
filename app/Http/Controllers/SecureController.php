<?php

namespace App\Http\Controllers;

use App\Token;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\IOException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use Defuse\Crypto\Key;
use Http\Client\Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\File as File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class SecureController extends Controller
{
    public function elements(Request $request)
    {

        $token = $request->header('APP_KEY');
        $results = DB::select('select * from tokens where token = :token', ['token' => $token]);

        // comprobación del token recibido
        $tokenuser = $results[0]->usuario;
        $file = $request->file('file');
        $file = $request->file;
        $modo = $request->get('mode');

        // --VALIDACION DEL TOKEN --
        // modo encriptacion
        if (!empty($results)) {
            if ($modo == 'E') {
                try {
                    //formateo del nombre del fichero
                    $destinationPath = './uploads/' . $tokenuser;
                    $nameFile = $file->getClientOriginalName() . '_' . md5(date('U'));
                    $destinacion = $file->move($destinationPath, $nameFile);
                    //Tareas: manejar error de la rutina de arriba
                    $destinacion->getFilename();
                    // clave altora alfanumerica de 8 digitos
                    $secret_key = substr(md5(date('U')), -8);
                    $retornoAccion = $this->encriptar($nameFile, $secret_key);
                    $retornoAccion = json_encode($retornoAccion);
                    return response()->json($retornoAccion, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_SLASHES);
                } catch (\Exception $e) {
                    return $e->getMessage();

                }
            }

            // modo desencriptacion
            if ($modo == 'D') {
                try {
                    $secret_key = $request->get('key');
                    $nameFile = $request->get('name');
                    $retornoAccion = $this->desencriptar($nameFile, $secret_key);
                    $retornoAccion = json_encode($retornoAccion);
                    return response()->json($retornoAccion, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_SLASHES);
                } catch (\Exception $e) {
                    return $e->getMessage();

                }
            }


        } else {
            $error = array(
                'status' => '403',
                'message' => 'Token Invalido'
            );
            $retornoAccion = json_decode($error, true);
            return response()->json($error, 403, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8']);
        }

    }

    public function encriptar($nameFile, $originKey)
    {
        // encripto el contenido del fichero y lo subo a una carpeta
        $contenidoFic = file_get_contents(public_path() . '/uploads/prueba/' . $nameFile);
        // securizo con OPENSLL
        $encrypt_method = "AES-256-CBC";
        $secret_iv = 'WS-SERVICE-VALUE';
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $key = hash('sha256', $originKey);
        $output = base64_encode(openssl_encrypt($contenidoFic, $encrypt_method, $key, 0, $iv));
        file_put_contents(public_path() . '/uploads/'.$nameFile.'.txt', $output);
        $retorno = array(
            'status' => '200',
            'fichero' =>$nameFile,
            'accion' => 'Encriptar',
            'clave' => $originKey
        );
        return $retorno;
    }

    public function desencriptar($nameFile, $originKey)
    {
        // desencripto el contenido del fichero y lo subo a una carpeta
        $contenidoFic_key = file_get_contents(public_path() . '/uploads/'.$nameFile.'.txt');
        // securizo con OPENSLL
        $encrypt_method = "AES-256-CBC";
        $secret_iv = 'WS-SERVICE-VALUE';
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $key = hash('sha256', $originKey);
        $output = openssl_decrypt(base64_decode($contenidoFic_key), $encrypt_method, $key, 0, $iv);
        file_put_contents(public_path().'/uploads/'.$nameFile.'.pdf', $output);
        $retorno = array(
            'status' => '200',
            'fichero' => $nameFile,
            'accion' => 'Desencriptar',
            'clave' => $originKey
        );
        return $retorno;
    }
}


