@extends('/admin/plantilla/layout')

@section('titulo',' LISTADO DE CATEGORIAS')
    
@section('contenido')
<div class="col-12">
    <a class="btn btn-primary" href="/productos/crear">Crear producto</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Supplier</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Imagen</th>
            <th scope="col">Editar</th>
            <th scope="col">Borrar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)
        <tr>
            <th scope="row">{{ $producto->id }}</th>
            <td>{{ $producto->nombre }}</td>
            <td>{{ $producto->supplier_id }}</td>
            <td>{{ $producto->categorie_id }}</td>
            <td>{{ $producto->price }}</td>
            <td>{{ $producto->quantity }}</td>
            <td>
                {{-- <img src="{{ $categoria->picture }}" alt="{{ $categoria->picture }}" width="100"> --}}
                {{-- @foreach ($producto->photos as $photo) --}}
                <img src="{{ $producto->imagen }}" alt="{{ $producto->imagen }}" width="100">
                {{-- @endforeach --}}
            </td>
            <td><a href="/productos/{{ $producto->id }}/edit">editar</a></td>
            <td><a href="/productos/{{ $producto->id }}">borrar</a></td>
        </tr>
        @endforeach
    </tbody>
</table>  
@endsection

