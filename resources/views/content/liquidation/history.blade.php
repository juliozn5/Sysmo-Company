@extends('layouts/contentLayoutMaster')

@section('title', 'Comissions')

@section('page-script')

<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
<script src="{{asset('assets/js/librerias/vue.js')}}"></script>
<script src="{{asset('assets/js/librerias/axios.min.js')}}"></script>
<script src="{{asset('assets/js/liquidation.js')}}"></script>

<script src="{{ asset('js/additional/data-tables/dataTables.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#mytable').DataTable({
            // dom: 'flBrtip',
            responsive: true,
            searching: false,
            ordering: true,
            paging: true,
            select: true,
        });
    });

</script>
@endsection

@section('content')
<div id="settlement">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">
                                <tr class="text-center text-black bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Correo</th>
                                    <th>Fecha </th>
                                    <th>Monto</th>
                                    <th>Billetera</th>  
                                    <th>Acción</th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($liquidations as $liqui)
                                <tr class="text-center">
                                    <td>{{$liqui->id}}</td>
                                    <td>{{$liqui->email}}</td>
                                    <td>{{date('Y-m-d', strtotime($liqui->created_at))}}</td>
                                    <td>{{$liqui->total}}</td>
                                    <td>{{$liqui->wallet_used}}</td>
                                    <td>
                                        @if ($liqui->status == 1)
                                        <button class="btn btn-info" onclick="vm_liquidation.getDetailComisionLiquidation({{$liqui->id}})">
                                            Ver
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('content.liquidation.componentes.modalDetalles', ['all' => false])
</div>


@endsection