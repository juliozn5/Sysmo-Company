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
                        <li class="breadcrumb-item"><a href="#">Tickets</a></li>
                        <li class="breadcrumb-item"><a href="#">Lista de Ticket</a></li>
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
                    <a href="{{ route('ticket.create')}}" class="btn btn-primary float-right mb-0 waves-effect waves-light"><i
                        data-feather="plus-circle"></i>&nbsp; Crear Ticket</a>
                    <div class="table-responsive">
                        
                        <table id="mytable" class="table nowrap scroll-horizontal-vertical myTable table-striped" data-order='[[ 1, "asc" ]]' data-page-length='10'>
                            <thead class="">

                                <tr class="text-center text-dark">
                                    <th>ID</th>
                                    <th>Whatsapp</th>
                                    <th>Email</th>
                                    <th>Asunto</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Fecha de Creacion</th>
                                    <th>Accion</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($ticket as $item)
                                <tr class="text-center">
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->whatsapp}}</td>
                                    <td>{{ $item->email}}</td>
                                    <td>{{ $item->issue}}</td>
                                    <td>{{ $item->description}}</td>

                                    @if ($item->status == '0')
                                    <td> <a class=" badge badge-info text-white">En Espera</a></td>
                                    @elseif($item->status == '1')
                                    <td> <a class=" badge badge-success text-white">Solucionado</a></td>
                                    @elseif($item->status == '2')
                                    <td> <a class=" badge badge-warning text-white">Procesando</a></td>
                                    @elseif($item->status == '3')
                                    <td> <a class=" badge badge-danger text-white">Cancelada</a></td>
                                    @endif

                                    <td>{{ $item->created_at}}</td>

                                    @if ($item->status == '0')
                                    <td><a href="{{ route('ticket.edit-user',$item->id) }}"
                                            class="btn btn-secondary text-bold-600">Editar</a></td>
                                    @else
                                    <td><a href="{{ route('ticket.show-user',$item->id) }}"
                                            class="btn btn-secondary text-bold-600">Revisar</a></td>
                                    @endif
                                </tr>
                                @endforeach

                            </tbody>
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

<script src="{{ asset('js/additional/data-tables/dataTables.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#mytable').DataTable({
            //dom: 'flBrtip',
            responsive: true,
            searching: false,
            ordering: true,
            paging: true,
            select: true,
        });
    });

</script>
@endsection
