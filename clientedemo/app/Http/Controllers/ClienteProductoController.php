<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteProductoController extends Controller
{
    public function catalogo(){
        $products=DB::table('products')->where('estatus','ACTIVO')->get();
        //return view('/productos/catalogo')->with('products',$products);
        return view('/products')->with('products',$products);
    }

    public function detalle($id){
        $product=DB::table('products')->where('id',$id)->where('estatus','ACTIVO')->first();
        //dd($product);
        return view('/productos/detalle')->with('product',$product);
    }
}
