<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    private $url_products = 'http://127.0.0.1:8000/api/productos/';
    public function index()
    {//Vista
        $response = Http::withToken(Session::get('token'))
            ->get($this->url_products);
        $json = json_decode($response->body());
        // dd($json);

        return view('/admin/productos/list')->with('productos', $json->productos);
    }

    public function create()
    {//Vista

        return view('/admin/productos/create');
    }

    public function store(Request $request)
    {//Proceso
        //dd($request);
        $http = Http::withToken(Session::get('token'));
        if ($request->hasFile('imagenes')) {
            foreach ($request->imagenes as $imagen) {
                $http = $http::attach(
                    'imagenes[]', //nombre del campo enviado a la API
                    $imagen->getContent(), //Contenido de la imagen
                    $imagen->getClientOriginalName()//Nombre del archivo
                );
            }
        }
        /* ->attach(
             'picture', //nombre del campo enviado a la API
             $request->file('picture')->getContent(), //Contenido de la imagen
             $request->file('picture')->getClientOriginalName()//Nombre del archivo*/
        $response = $http->post($this->url_products, [
            'nombre' => $request->name,
            'supplier_id' => $request->supplier_id,
            'categorie_id' => $request->categorie_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'picture' => 'default.jpg',
        ]);
        $json = json_decode($response->body());

        // dd($json);
        return redirect()->route('productos.index');
        //     view('/admin/productos/list')
        //         ->with('mensaje', $json->message);
    }

    public function edit($id)
    {//Vista
        $response = Http::withToken(Session::get('token'))
            ->get($this->url_products . $id);
        $json = json_decode($response->body());
        //dd($json);

        return view('/admin/productos/edit')->with('producto', $json->producto);
    }

    public function update(Request $request, $id)
    {//Proceso
        //dd($request);
        $response = Http::withToken(Session::get('token'))
            ->attach(
                'picture', //nombre del campo enviado a la API
                $request->file('picture')->getContent(), //Contenido de la imagen
                $request->file('picture')->getClientOriginalName()//Nombre del archivo
            )->post($this->url_products . $id, [
                    'nombre' => $request->name,
                    'supplier_id' => $request->supplier_id,
                    'categorie_id' => $request->categorie_id,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'picture' => 'default.jpg',
                    '_method' => 'PUT',
                ]);
        $json = json_decode($response->body());

        //dd($json);


        return redirect()->route('productos.index');
        //     view('/admin/productos/list')
        //         ->with('mensaje', $json->message);
    }


    public function show($id)
    {//Vista
        $response = Http::withToken(Session::get('token'))
            ->get($this->url_products . $id);
        $json = json_decode($response->body());
        // dd($json);

        return view('/admin/productos/show')->with('producto', $json->producto);
    }

    public function destroy(Request $request, $id)
    {//Proceso
        //dd($request);
        $response = Http::withToken(Session::get('token'))
            ->post($this->url_products . $id, [
                '_method' => 'DELETE',
            ]);
        $json = json_decode($response->body());

        //dd($json);



        return redirect()->route('productos.index');
        //     view('/admin/productos/list')
        //         ->with('mensaje', $json->message);
    }

}
