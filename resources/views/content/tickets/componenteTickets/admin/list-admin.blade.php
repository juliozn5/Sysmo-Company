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
                        <table class="table nowrap scroll-horizontal-vertical myTable table-striped">
                            <thead class="">

                                <tr class="text-center text-white bg-purple-alt2">
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Asunto</th>
                                    <th>Estado</th>
                                    <th>Fecha de Creacion</th>
                                    <th>Accion</th>
                                </tr>

                            </thead>

                            <tbody>

                                 @foreach ($ticket as $item)
                                <tr class="text-center">
                                    <td>{{ $item->id}}</td>
                                    <td>{{ $item->getUser->fullname}}</td>
                                    <td>{{ $item->email}}</td>
                                    <td>{{ $item->issue}}</td>

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
                                    <td><a href="{{ route('ticket.edit-admin',$item->id) }}" class="btn btn-secondary text-bold-600">Revisar</a>
                                        <button type="submit" class="btn btn-danger">
                                            <form action="{{route('ticket.destroy', $item->id)}}" method="post">
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


