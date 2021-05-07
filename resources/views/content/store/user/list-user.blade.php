@extends('layouts/contentLayoutMaster')

@section('title', 'list-tickets-user')

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
                                    @if ($item->getProduct->photoDB != NULL)
                                    <td><img src="{{asset('storage/products/'.$item->getProduct->photoDB)}}" alt="photo" class="rounded" width="50px" height="70px"></td>
                                    @else
                                    <td>No Tiene Imagen</td>
                                    @endif
                                    <td>{{ $item->getProduct->name}}</td>
                                    <td>{{ $item->getProduct->amount}}</td>

                                    @if ($item->status == '0')
                                    <td> <a class=" badge badge-info text-white">En Espera</a></td>
                                    @else
                                    <td> <a class=" badge badge-success text-white">Atendido</a></td>
                                    @endif

                                    <td>{{ $item->getProduct->created_at}}</td>

                                    <td>
                                        <a href="{{ route('store.show',$item->id) }}" class="btn
                                        btn-secondary text-bold-600">Ver</a> 
                                    </td>
                                </tr>

                           
                                
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
