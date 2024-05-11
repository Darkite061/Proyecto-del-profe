<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=DB::table("products")->where('estatus','ACTIVO')->get();//select * from products
        foreach ($products as $product) {
            $product->imagen=asset($product->imagen);
        }
        return response()->json(['productos'=>$products,'status'=>200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id=DB::table('products')->insertGetId([
            'nombre'=> $request->nombre,
            'supplier_id'=> $request->supplier_id,
            'categorie_id'=> $request->categorie_id,
            'price'=> $request->price,
            'quantity'=> $request->quantity,
            'estatus'=>'ACTIVO',
            'imagen'=>'storage/imagenes/productos/default.jpg',
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);

        if ($request->hasFile('picture')) {
            $ruta = 'imagenes/productos';
            $extension = $request->picture->extension();
            $nombre = 'productos_' . $id . '.' . $extension;
            $path = $request->picture->storeAs($ruta, $nombre, 'public');
            DB::table('products')->where('id', $id)
                ->update([
                    'imagen' => '/storage/' . $path,
                    'updated_at' => now(),
                ]);
        }

        return response()->json([
            'success'=>'true',
            'message'=>'El producto fue registrado con exito',
            'datos'=>$id,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //equivalencia select * from products where id=$id
        $product=DB::table("products")->where('id',$id)->where('estatus','ACTIVO')->first();
        $product->imagen=asset($product->imagen);
        return response()->json(['producto'=>$product,'status'=>200]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $affected=DB::table('products')->where('id', $id)->update([
            'nombre'=> $request->nombre,
            'supplier_id'=> $request->supplier_id,
            'categorie_id'=> $request->categorie_id,
            'price'=> $request->price,
            'quantity'=> $request->quantity,
            'estatus'=>'ACTIVO',
            'imagen'=>'storage/imagenes/productos/default.jpg',
            'updated_at'=>now(),
        ]);

        if ($request->hasFile('picture')) {
            $ruta = 'imagenes/productos';
            $extension = $request->picture->extension();
            $nombre = 'productos_' . $id . '.' . $extension;
            $path = $request->picture->storeAs($ruta, $nombre, 'public');
            DB::table('products')->where('id', $id)
                ->update([
                    'imagen' => '/storage/' . $path,
                    'updated_at' => now(),
                ]);
        }

        //return response()->json(['rows'=>$affected,'status'=>200]);
        return response()->json([
            'success'=>'true',
            'message'=>'El producto fue actualizado con exito',
            'datos'=>$affected,
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $affected=DB::table('products')->where('id', $id)->update([
            'estatus'=>'INACTIVO',
            'updated_at'=>now(),
        ]);

        //return response()->json(['rows'=>$affected,'status'=>200]);
        return response()->json([
            'success'=>'true',
            'message'=>'El producto fue borrado con exito',
            'datos'=>$affected,
        ],202);
    }
}
