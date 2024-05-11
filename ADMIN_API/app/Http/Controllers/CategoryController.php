<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //CRUD Crear Read Update Delete
    public function indice()
    {//Vista
        $categorias = DB::table('categories')->where('status', 'ACTIVO')->get();
        //dd($categorias);
        foreach ($categorias as $cat) {
            $photos = DB::table('pictures')->where('category_id', $cat->id)->get();
            $cat->photos = $photos;
        }
        // dd($categorias);
        return view('/admin/categorias/list')->with('categorias', $categorias);
    }

    public function crear()
    {//Vista

        return view('/admin/categorias/create');
    }

    public function guardar(Request $request)
    {//Proceso
        //dd($request);
        $id = DB::table('categories')->insertGetId([
            'name' => $request->name,
            'description' => $request->description,
            'picture' => $request->picture,
            'status' => 'ACTIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        //actualizar la columna imagen de la misma tabla
        if ($request->hasFile('picture')) {
            $ruta = 'imagenes/productos';
            $extension = $request->picture->extension();
            $nombre = 'producto_' . $id . '.' . $extension;
            $path = $request->picture->storeAs($ruta, $nombre, 'public');
            DB::table('categories')->where('id', $id)
                ->update([
                    'picture' => '/storage/' . $path,
                    'updated_at' => now(),
                ]);
        }

        if ($request->hasFile('photos')) {
            $ruta = 'imagenes/categorias';
            $num = 0;
            foreach ($request->photos as $img) {
                $extension = $img->extension();
                $num++;
                $nombre = 'categoria_' . $id . '_' . $num . '.' . $extension;
                $path = $request->picture->storeAs($ruta, $nombre, 'public');
                DB::table('pictures')->insert([
                    'name' => $path,
                    'description' => 'informacion de prueba',
                    'category_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

        }


        $categorias = DB::table('categories')->where('status', 'ACTIVO')->get();
        return view('/admin/categorias/list')
            ->with('categorias', $categorias)
            ->with('mensaje', 'registro realizado');
    }

    public function editar($id)
    {//Vista
        $categoria = DB::table('categories')->where('id', $id)->first();
        return view('/admin/categorias/edit')->with('categoria', $categoria);
    }

    public function actualizar(Request $request, $id)
    {//Proceso
        dd($request);
        DB::table('categories')->where('id', $id)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
                'picture' => $request->picture,
                'updated_at' => now(),
            ]);
        if ($request->hasFile('picture')) {
            $ruta = 'imagenes/categorias';
            $extension = $request->picture->extension();
            $nombre = 'categoria_' . $id . '.' . $extension;
            $path = $request->picture->storeAs($ruta, $nombre, 'public');
            DB::table('categories')->where('id', $id)
                ->update([
                    'picture' => '/storage/' . $path,
                    'updated_at' => now(),
                ]);
        }
        $categorias = DB::table('categories')->where('status', 'ACTIVO')->get();
        return view('/admin/categorias/list')
            ->with('categorias', $categorias)
            ->with('mensaje', 'registro actualizado');
    }

    public function mostrar($id)
    {//Vista
        $categoria = DB::table('categories')->where('id', $id)->first();
        return view('/admin/categorias/show')->with('categoria', $categoria);
    }

    public function borrar($id)
    {//Proceso
        // $deleted = DB::table('categories')->where('id', $id)->delete();
        DB::table('categories')->where('id', $id)
            ->update([
                'status' => "INACTIVO",
            ]);
        $categorias = DB::table('categories')->where('status', 'ACTIVO')->get();
        return view('/admin/categorias/list')
            ->with('categorias', $categorias)
            ->with('mensaje', 'registro borrado');
    }
}
