<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private $url_auth='http://127.0.0.1:8000/api/auth/';
    public function login(){
        return view('/admin/sign-in/index');
    }

    public function autenticate(Request $request){
        $response = Http::post($this->url_auth.'login',[
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $json=json_decode($response->body());
        //dd($json);
        if($json!=null && isset($json->token)){
            Session::put('token',$json->token);
            return redirect('/productos');
        }else{
            return view('/admin/sign-in/index')->with('success','Datos erroneos');
        }
    }

    public function logout(Request $request){
        $response = Http::withToken(Session::get('token'))
        ->post($this->url_auth.'logout');
        $json=json_decode($response->body());
        //dd($json);
        return view('/admin/sign-in/index');
    }
}
