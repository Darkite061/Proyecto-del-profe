<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //dd(Session::get('api_key'));
        $url="http://localhost:8080/laravel-8-image-crud-master-api-passport/public/api/posts";
        $response=Http::withHeaders([ 'Authorization' => 'Bearer '.Session::get('api_key') ])->
        get($url);
        //dd($response);
        $body=json_decode($response->body());
        //dd($body);
        //dd($body->datos);
        return view('posts.index', ['posts'=>$body->datos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(file_get_contents($request->file('image')));
        $url="http://localhost:8080/laravel-8-image-crud-master-api-passport/public/api/posts";
        $response=Http::withToken(Session::get('api_key'))->
        attach(
            'image', file_get_contents($request->file('image')),$request->file('image')->getClientOriginalName())
        ->post($url,
            ['title'=>$request->title,
            'description'=>$request->description,
            //'image'=>$request->$FILE->image
            ]);
        //dd($response->json());
        $body = json_decode($response->body());
        //dd($body);
        return redirect()->route('posts.index')
                        ->with('success',$body->mensaje);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url="http://localhost:8080/laravel-8-image-crud-master-api-passport/public/api/posts/".$id;
        $response=Http::withToken(Session::get('api_key'))->get($url);
        //dd($response);
        $body=json_decode($response->body());
        //dd($body);
        return view('posts.show',['post'=>$body->post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url="http://localhost:8080/laravel-8-image-crud-master-api-passport/public/api/posts/".$id;
        $response=Http::withToken(Session::get('api_key'))->get($url);
        //dd($response);
        $body=json_decode($response->body());
        //dd($body);
        return view('posts.edit',['post'=>$body->post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $url="http://localhost:8080/laravel-8-image-crud-master-api-passport/public/api/posts/".$id;
        $response=Http::withToken($request->session()->get('api_key'))->
        attach(
            'image', file_get_contents($request->file('image')),$request->file('image')->getClientOriginalName())
        ->post($url,
        ['title'=>$request->title,
         'description'=>$request->description,
         '_method'=>'PUT',
        ]);
        //dd($response);
        $body = json_decode($response->getBody());
        //dd($body);
        return redirect()->route('posts.index')
                        ->with('success',$body->message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url="http://localhost:8080/laravel-8-image-crud-master-api-passport/public/api/posts/".$id;
        $response=Http::withToken(Session::get('api_key'))->
        post($url,['_method'=>'DELETE']);
        //dd($response);
        $body = json_decode($response->getBody());
        //dd($body);
        return redirect()->route('posts.index')
                        ->with('success',$body->message);
    }
}
