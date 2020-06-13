<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /*gestion de usuario*/

    public function gouser(Request $request)
    {
        $usuarios = DB::table('users')->get();
        $collection = collect($usuarios);
        $page = $request['page'];
        $perPage = 10;
        $paginat = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path' => url('auth/edicion')]);
        return view('auth/edicion', [ 'paginado' => $paginat]);
    }



    public function goregister()
    {
        return view("auth/register");
    }



    protected function create(Request $request)
    {
         User::create([
            'name' => $request->get('name'),
            'email' =>$request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        $usuarios = DB::table('users')->get();
        $collection = collect($usuarios);
        $page = $request['page'];
        $perPage = 10;
        $paginat = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path' => url('auth/edicion')]);
        return view('auth/edicion', [ 'paginado' => $paginat]);
    }



    public function delete(Request $request)
    {

        $user = User::find($request->get('idd'));
        $user->delete();
        $usuarios = DB::table('users')->get();
        $collection = collect($usuarios);
        $page = $request['page'];
        $perPage = 10;
        $paginat = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path' => url('auth/edicion')]);
        return view('auth/edicion', [ 'paginado' => $paginat]);
    }

    public function goupdate(Request $request)
    {
        $user = User::find($request->get('id'));
       // $user = DB::table('users')->where('id', $request->get('id'))->get();
        return view("auth/update")->with('usuario',$user);
    }


    public function update(Request $request)
    {


        DB::table('users')
                ->where('id',$request->get('id'))
                ->update([  'name' => $request->get('name'),
                            'email' => $request->get('email') ,
                            'password' => Hash::make($request->get('password'))
                        ]);
        $usuarios = DB::table('users')->get();
        $collection = collect($usuarios);
        $page = $request['page'];
        $perPage = 10;
        $paginat = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path' => url('auth/edicion')]);
        return view('auth/edicion', [ 'paginado' => $paginat]);
    }






}
