@extends('/admin/plantilla/layout')

@section('titulo',' LISTADO DE CATEGORIAS')
    
@section('contenido')
<div class="col-12">
    <a class="btn btn-primary" href="/categorias/crear">Crear categoria</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Imagen</th>
            <th scope="col">Editar</th>
            <th scope="col">Borrar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $categoria)
        <tr>
            <th scope="row">{{ $categoria->id }}</th>
            <td>{{ $categoria->name }}</td>
            <td>{{ $categoria->description }}</td>
            <td>
                {{-- <img src="{{ $categoria->picture }}" alt="{{ $categoria->picture }}" width="100"> --}}
                @foreach ($categoria->photos as $photo)
                <img src="/storage/{{ $photo->name }}" alt="/storage/{{ $photo->name }}" width="100">
                @endforeach
            </td>
            <td><a href="/categorias/editar/{{ $categoria->id }}">editar</a></td>
            <td><a href="/categorias/mostrar/{{ $categoria->id }}">borrar</a></td>
        </tr>
        @endforeach
    </tbody>
</table>  
@endsection

