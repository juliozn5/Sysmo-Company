@extends('layouts/contentLayoutMaster')

@section('title', 'edit-product')

@section('page-script')

<script>

    $(document).ready(function() {
          @if($store->photoDB != NULL)
                previewPersistedFile("{{asset('storage/products/'.$store->photoDB)}}", 'photo_preview');
            @endif
        });
   
     function previewFile(input, preview_id) {
         if (input.files && input.files[0]) {
             var reader = new FileReader();
             reader.onload = function (e) {
                 $("#" + preview_id).attr('src', e.target.result);
                 $("#" + preview_id).css('height', '300px');
                 $("#" + preview_id).parent().parent().removeClass('d-none');
             }
             $("label[for='" + $(input).attr('id') + "']").text(input.files[0].name);
             reader.readAsDataURL(input.files[0]);
         }
     }
   
     function previewPersistedFile(url, preview_id) {
         $("#" + preview_id).attr('src', url);
         $("#" + preview_id).css('height', '300px');
         $("#" + preview_id).parent().parent().removeClass('d-none');
   
     }
   
   </script>

@endsection

@section('content')

<section id="basic-vertical-layouts">
    <div class="row match-height d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edicion de Producto</h4>
                </div>
                <div class="card-content"> 
                    <div class="card-body">
                        <form action="{{route('store.update', $store->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input type="text" id="name" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" name="name" value="{{ $store->name }}" required />
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Descripcion</label>
                                            <textarea type="text" id="description" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" name="description" required>{{ $store->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Precio</label>
                                            <input type="number" id="amount" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" name="amount" value="{{ $store->amount }}" required/>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select name="status" id="status"
                                            class="custom-select status @error('status') is-invalid @enderror"
                                            required data-toggle="select">
                                            <option value="0" @if($store->status == '0') selected  @endif>Inactivo</option>
                                            <option value="1" @if($store->status == '1') selected  @endif>Disponible</option>
                                            <option value="2" @if($store->status == '2') selected  @endif>Agotado</option>
                                            <option value="3" @if($store->status == '3') selected  @endif>No Disponible</option>
                                        </select>
                                        </div>
                                    </div>
                              
                                    <div class="col-12">
                                        <div class="form-group">
                                            <fieldset>
                                                <label class="h5" for="due_date">Imagen del Product</label>
                                                <div class="media">
                                                    <div class="custom-file">
                                                        <label class="custom-file-label" for="photoDB"><b>Seleccione una imagen para el Cliente</b></label>
                                                        <input type="file" id="photoDB"
                                                            class="custom-file-input @error('photoDB') is-invalid @enderror"
                                                            name="photoDB" onchange="previewFile(this, 'photo_preview')"
                                                            accept="image/*">
                                                    </div>
                                                </div>
                              
                                                <div class="row mb-4 mt-4 d-none" id="photo_preview_wrapper">
                                                    <div class="col"></div>
                                                    <div class="col-auto">
                                                      <img id="photo_preview" class="img-fluid rounded" />
                                                    </div>
                                                    <div class="col"></div>
                                                </div>

                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Editar Producto</button>

                                            <a href="{{ route('store.list-admin') }}"
                                            class="btn btn-danger mr-1 mb-1 waves-effect waves-light">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
