@extends('layouts/contentLayoutMaster')

@section('title', 'Lista de Productos')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/additional/data-tables/dataTables.min.css')}}">
@endsection

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <h1 class="content-header-title float-left mr-2">Sysmo Company</h1>
                        <li class="breadcrumb-item"><a href="#">Tienda</a></li>
                        <li class="breadcrumb-item"><a href="#">Lista de Productos</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="record">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <!-- <a href="{{ route('store.create')}}" class="btn btn-primary float-right mb-0 waves-effect waves-light"><i
                        data-feather="plus-circle"></i>&nbsp; Crear Producto</a> -->
                    <div class="table-responsive">
                        <table id="mytable" class="table nowrap scroll-horizontal-vertical myTable table-striped"
                            data-order='[[ 1, "asc" ]]' data-page-length='10'>
                            <thead class="bg-purple-alt2">
                                <tr class="text-center text-dark">
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Fecha de Creacion</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($store as $item)
                                <tr class="text-center">
                                    <td>{{ $item->id}}</td>
                                    @if ($item->photoDB != NULL)
                                    <td><img src="{{asset('storage/products/'.$item->photoDB)}}" alt="photo" class="rounded" width="50px" height="70px"></td>
                                    @else
                                    <td>No Tiene Imagen</td>
                                    @endif
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->price}}</td>

                                    @if ($item->status == '0')
                                    <td> <a class=" badge badge-info text-white">Inactivo</a></td>
                                    @else
                                    <td> <a class=" badge badge-success text-white">Activo</a></td>
                                    @endif

                                    <td>{{ date('d-m-Y', strtotime($item->created_at))}}</td>

                                    <td>
                                        <a href="{{ route('store.edit',$item->id) }}" class="btn
                                        btn-secondary text-bold-600">Editar</a> 

                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#Modal">Eliminar</button>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="Modal" tabindex="-1" role="dialog"
                                    aria-labelledby="ModalTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form class="float-right ml-1"
                                                    action="{{ route('store.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <h1 class="text-center card-title">Seguro que quieres Eliminar este Producto?</h1>
                                            </div>
                                            <div class="modal-footer justify-conten-center">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
{{-- permite llamar a las opciones de las tablas --}}
@section('page-script')


<script>
    $('#Modal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })

</script>

<script src="{{ asset('js/additional/data-tables/dataTables.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#mytable').DataTable({
            dom: 'flBrtip',
            responsive: true,
            searching: false,
            ordering: true,
            paging: true,
            select: true,
        });
    });

</script>
@endsection
