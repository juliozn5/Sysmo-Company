@extends('layouts.dashboard')

@section('content')
<div id="record">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <h1>Historial de Tickets</h1>
                        <p>Para ver mas información dar click -> <img src="{{asset('assets/img/sistema/btn-plus.png')}}" alt=""></p>
                        <a href="{{ route('ticket.create')}}" class="btn btn-primary mb-2 waves-effect waves-light"><i class="feather icon-plus"></i>&nbsp; Crear Ticket</a>
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">

                                <tr class="text-center text-white bg-purple-alt2">
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
                                    <td> <a class=" btn btn-info text-white text-bold-600">En Espera</a></td>
                                    @elseif($item->status == '1')
                                    <td> <a class=" btn btn-success text-white text-bold-600">Solucionado</a></td>
                                    @elseif($item->status == '2')
                                    <td> <a class=" btn btn-warning text-white text-bold-600">Procesando</a></td>
                                    @elseif($item->status == '3')
                                    <td> <a class=" btn btn-danger text-white text-bold-600">Cancelada</a></td>
                                    @endif

                                    <td>{{ $item->created_at}}</td>

                                    @if ($item->status == '0')
                                    <td><a href="{{ route('ticket.edit-user',$item->id) }}" class="btn btn-secondary text-bold-600">Editar</a></td>
                                    @else
                                    <td><a href="{{ route('ticket.show-user',$item->id) }}" class="btn btn-secondary text-bold-600">Revisar</a></td>
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
@include('layouts.componenteDashboard.optionDatatable')


