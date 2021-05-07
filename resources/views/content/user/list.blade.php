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
                    <div class="table-responsive">
                        <table id="mytable" class="table nowrap scroll-horizontal-vertical myTable table-striped"
                            data-order='[[ 1, "asc" ]]' data-page-length='10'>
                            <thead class="bg-purple-alt2">

                                <tr class="text-center text-dark">
                                    <th>ID</th>
                                    <th>Nombre de Usuario</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Fecha de Creacion</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($user as $item)
                                <tr class="text-center">
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->username}}</td>
                                    <td>{{ $item->email}}</td>
                                    {{-- <td>{{ $item->balance}}</td> --}}

                                    @if ($item->role == '1')
                                    <td>Administrador</td>
                                    @else
                                    <td>Normal</td>
                                    @endif

                                    @if ($item->status == '0')
                                    <td> <a class=" badge badge-danger text-white">Inactivo</a></td>
                                    @else
                                    <td> <a class=" badge badge-success text-white">Activo</a></td>
                                    @endif

                                    <td>{{ $item->created_at}}</td>

                                    <td>
                                        @if(Auth::user()->id == $item->id)
                                        <a href="{{ route('profile.show') }}"
                                            class="btn btn-info text-bold-600">Ver Mi Perfil</a>
                                        @else
                                         <a href="{{ route('user.edit',$item->id) }}"
                                            class="btn btn-info text-bold-600">Editar</a>
                                             
                                        {{-- <form class="float-right ml-1" action="{{ route('user.destroy', $item->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form> --}}

                                        <form class="float-right ml-1" action="{{route('impersonate.start', $item)}}"
                                            method="POST" id="formImpersonate">
                                            @csrf
                                            <button class="btn btn-primary">Ver</button>
                                        </form>
                                        @endif
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
