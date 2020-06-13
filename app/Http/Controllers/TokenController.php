<?php

namespace App\Http\Controllers;

use App\Token;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    /*gestion de tokens*/

    public function gotokens(Request $request)
    {
        $tokens = DB::table('token')->get();
        $collection = collect($tokens);
        $page = $request['page'];
        $perPage = 10;
        $paginat = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path' => url('tokens/edicion')]);
        return view('tokens/edicion', [ 'paginado' => $paginat]);

    }
   protected function create(Request $request)
    {

        Token::create([
            'usuario' => $request->get('usuario'),
            'titulo' =>$request->get('titulo'),
            'token' => Str::random(32),
        ]);
        $tokens = DB::table('tokens')->get();
        $collection = collect($tokens);
        $page = $request['page'];
        $perPage = 10;
        $paginat = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path' => url('tokens/edicion')]);
        return view('tokens/edicion', [ 'paginado' => $paginat]);

    }

    public function delete(Request $request)
    {
        $token = Token::find($request->get('idd'));
        $token->delete();
        $tokens = DB::table('tokens')->get();
        $collection = collect($tokens);
        $page = $request['page'];
        $perPage = 10;
        $paginat = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path' => url('tokens/edicion')]);
        return view('tokens/edicion', [ 'paginado' => $paginat]);
    }


    public function gotokensegister(Request $request)
    {
        return view('tokens/register');
    }



    public function goupdate(Request $request)
    {

        $token = Token::find($request->get('id'));
        // $user = DB::table('users')->where('id', $request->get('id'))->get();
        return view("tokens/update")->with('token',$token);
    }


    public function update(Request $request)
    {


        DB::table('token')
            ->where('id',$request->get('id'))
            ->update([  'usuario' => $request->get('usuario'),
                'titulo' => $request->get('titulo') ,
                'token' => Str::random(32)
            ]);

        $tokens = DB::table('token')->get();
        $collection = collect($tokens);
        $page = $request['page'];
        $perPage = 10;
        $paginat = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path' => url('tokens/edicion')]);
        return view('tokens/edicion', [ 'paginado' => $paginat]);
    }






}
