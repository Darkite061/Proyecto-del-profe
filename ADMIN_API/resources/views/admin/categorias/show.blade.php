@extends('/admin/plantilla/layout')

@section('titulo',' CREAR CATEGORIA')
    
@section('contenido')
    
<h1>MOSTRAR</h1>
<form class="row g-3 needs-validation" method="POST" action="/categorias/{{ $categoria->id }}" novalidate>
    @csrf
    @method('DELETE')
    <div class="col-md-12">
        <label for="validationCustom01" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="validationCustom01" 
        value="{{ $categoria->name }}"    readonly>    
    </div>
    <div class="col-md-12">
        <label for="validationCustom02" class="form-label">Descripcion</label>
        <input type="text" class="form-control" id="validationCustom02"  
        value="{{ $categoria->description }}"  readonly>
    </div>
    {{-- <div class="col-md-4">
        <label for="validationCustomUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
            <span class="input-group-text" id="inputGroupPrepend">@</span>
            <input type="text" class="form-control" id="validationCustomUsername"
                aria-describedby="inputGroupPrepend" required>
            <div class="invalid-feedback">
                Please choose a username.
            </div>
        </div>
    </div> --}}
    <div class="col-md-12">
        <label for="validationCustom03" class="form-label">Imagen</label>
        <img src="{{ $categoria->picture }}" alt="{{ $categoria->picture }}" width="150">
    </div>

    <div class="col-12">
        <button class="btn btn-primary" type="submit">Borrar</button>
    </div>
</form>

<script>
    (() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
@endsection