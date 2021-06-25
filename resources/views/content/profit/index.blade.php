@extends('layouts/contentLayoutMaster')

@section('title', 'Flujo de Ganancia')

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
                        <li class="breadcrumb-item"><a href="#">Flujo de Ganancia</a></li>
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
                        {{-- <h1 href="#" class="btn btn-primary float-right mb-0 waves-effect waves-light">Comisiones sin liquidar: {{$user}}</h1> --}}
                    <div class="table-responsive">
                        <table id="mytable" class="table nowrap scroll-horizontal-vertical myTable table-striped" data-order='[[ 1, "asc" ]]' data-page-length='10'>
                            <thead class="">
                                <tr class="text-center text-dark bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Compras del Sistema</th>
                                    <th>Retiros del Sistema</th>
                                    <th>ID</th>
                                    <th>ID</th>
                                    <th>ID</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
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
