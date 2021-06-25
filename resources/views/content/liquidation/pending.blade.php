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
                                    <th>Total </th>
                                    <th>Fecha</th>
                                    <th>Billetera</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($liquidations as $liqui)
                                <tr class="text-center">
                                    <td>{{$liqui->id}}</td> 
                                    <td>{1}</td>
                                    <!-- <td>{{$liqui->correo}}</td> -->
                                    <td>{{date('Y-m-d', strtotime($liqui->created_at))}}</td>
                                    <td>{{$liqui->wallet_used}}</td>
                                    <td>{{$liqui->total}}</td>
                                    <td>{{$liqui->status}}</td>
                                    <td>
                                        <button class="btn btn-info" onclick="vm_liquidation.getDetailComisionLiquidation({{$liqui->id}})">
                                            Ver
                                        </button>
                                        <button class="btn btn-success" onclick="vm_liquidation.getDetailComisionLiquidationStatus({{$liqui->id}}, 'aproved')">
                                            Aprovar
                                        </button>
                                        <button class="btn btn-danger" onclick="vm_liquidation.getDetailComisionLiquidationStatus({{$liqui->id}}, 'reverse')">
                                            <i class="fa fa-reply"></i>
                                        </button> 
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
    @include('content.liquidation.componentes.modalDetalles', ['all' => true])
    @include('content.liquidation.componentes.modalAction')
</div>
@endsection
