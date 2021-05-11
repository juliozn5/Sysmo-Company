@extends('layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/librerias/emojionearea.min.css')}}">
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
@endpush

{{-- permite llamar las librerias montadas --}}
@push('page_js')
<script src="{{asset('assets/js/librerias/vue.js')}}"></script>
<script src="{{asset('assets/js/librerias/axios.min.js')}}"></script>
<script src="{{asset('assets/js/librerias/emojionearea.min.js')}}"></script>
@endpush

@push('custom_js')
<script src="{{asset('assets/js/ordenRecord.js')}}"></script>
@endpush

@section('content')

<div id="adminrecord">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <h1>Historial de Ordenes</h1>
                        <p>Para ver mas información dar click -> <img src="{{asset('assets/img/sistema/btn-plus.png')}}" alt=""></p>
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">

                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Datos</th>
                                    <th>Estatus</th>
                                    <th>Fecha de Creacion</th>
                                    <th>Acción</th>
                                </tr>

                            </thead> 
                            <tbody>

                             @foreach ($orden as $item)
                                <tr class="text-center">
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->email}}</td>

                                    <td>
                                    <p class="text-left"><b>Servicio:</b> {{ $item->getOrdenCategorie->name}} <b class="text-danger">||</b> {{ $item->getOrdenService->package_name}}</p>
                                    <p class="text-left"><b>Usuario:</b> {{ $item->link}}</p>
                                    <p class="text-left"><b>Cantidad:</b> {{ $item->cantidad}}</p>
                                    <p class="text-left"><b>Monto:</b> ${{ $item->total}}</p>
                                    <p class="text-left"><b>Empieza el contador desde:</b> {{ $item->count_start}}</p>
                                    <p class="text-left"><b>Objetivo:</b> {{ $item->count_start + $item->count_end }}</p>
                                    <p class="text-left"><b>Email:</b> {{ $item->getOrdenUser->email}}</p>
                                    </td>

                                    @if ($item->status == '0')
                                    <td> <a class=" btn btn-info text-white text-bold-600">Pendiente</a></td>
                                    @elseif($item->status == '1')
                                    <td> <a class=" btn btn-warning text-white text-bold-600">En progreso</a></td>
                                    @elseif($item->status == '2')
                                    <td> <a class=" btn btn-success text-white text-bold-600">Completada</a></td>
                                    @elseif($item->status == '3')
                                    <td> <a class=" btn btn-danger text-white text-bold-600">Cancelada</a></td>
                                    @endif
                                    
                                    <td>{{ $item->created_at}}</td>
                                    <td><a href="{{ route('record_order.edit-admin',$item->id) }}" class="btn btn-secondary text-bold-600">Revisar</a>
                                        <button class="btn btn-danger" onclick="vm_ordenRecord.deleteData('{{$item->id}}')">
                                            <form action="{{route('record_order.destroy-admin', $item->id)}}" method="post" id="delete{{$item->id}}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <i class="fa fa-trash"></i>
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
</div>

@endsection

{{-- permite llamar a las opciones de las tablas --}}
@include('layouts.componenteDashboard.optionDatatable')


