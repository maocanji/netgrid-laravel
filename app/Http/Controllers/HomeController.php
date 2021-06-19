<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Cache;
use DB;
use App\Http\Requests\update_users;

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

        $minutes = 60;

        $forecast = Cache::remember('forecast', $minutes, function () {
            $url = "api.openweathermap.org/data/2.5/forecast?id=524901&appid=4fd4134fe232955f5e02434aacbce5e4";
            $client = new \GuzzleHttp\Client();
            $res = $client->get($url);
            if ($res->getStatusCode() == 200) {
                $j = $res->getBody();
                $forecast = json_decode($j);
            }
            return $forecast;
        });

        return view('home')->with([
        "forecast" => $forecast
         ]);
    }

    public function admin_user(request $request)
    {
        $alluser = User::all();
        $alluser = $alluser->map(function ($item, $key) {
            $item->roles;
            return $item;
        });

       $var = Auth::user()->hasRole('admin');
       if($var == 'admin')
       {
           return view('admin_usuarios')
               ->with([
                   'alluser' => $alluser
               ]);
       }else
       {
           toastr()->warning('Debes ser administrador para poder acceder');
           return redirect('home');
       }
    }

    public function todos_user(request $request)
    {
        $alluser = User::all();
        $alluser = $alluser->map(function ($item, $key) {
            $item->roles;
            return $item;
        });
           return view('usuarios')
               ->with([
                   'alluser' => $alluser
               ]);

    }
    public function comentarios(request $request)
    {
        $alluser = User::all();
        $alluser = $alluser->map(function ($item, $key) {
            $item->roles;
            return $item;
        });
           return view('comentarios')
               ->with([
                   'alluser' => $alluser
               ]);

    }
    public function modal_detalle_servicios()
    {
        return view('modal_detalle_servicio');
    }
    public function traer_servicios(Request $request){
        $usuario = User::find($request->codificacion);

        return response()->json([
            'usuario' =>$usuario]);
    }

    public function update_usuario(update_users $request){

        DB::table('users')
            ->where('id', $request->identificador)
            ->update([
                'name'=> $request->name,
                'email'=> $request->email
            ]);

        toastr()->success('Datos Actualizados');
        return redirect('admin_user');

    }
    public function eliminar_usuario(request $Request)
    {

        $user = User::find($Request->id_eliminar);
        $user->delete();
        toastr()->success('Archivo eliminado');
        return Redirect::to('admin_user');
    }

}
