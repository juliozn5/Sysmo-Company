@extends('layouts.dashboard')

@section('content')

<section id="basic-vertical-layouts">
    <div class="row match-height d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Revisando el Ticket #{{ $ticket->id}}</h4>
                    <h4 class="card-title mt-1">Usuario: <span
                            class="text-primary">{{ $ticket->getUser->fullname}}</span></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Email de contacto</label>
                                        <input type="email" readonly id="email" class="form-control"
                                            value="{{ $ticket->email }}" name="email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Whatsapp de contacto</label>
                                        <input type="text" readonly id="whatsapp" class="form-control"
                                            value="{{ $ticket->whatsapp }}" name="whatsapp">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Asunto del Ticket</label>
                                        <input type="text" id="issue" readonly class="form-control"
                                            value="{{ $ticket->issue }}" name="issue">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Especificación del Ticket</label>
                                        <textarea type="text" rows="5" readonly id="description" class="form-control"
                                            name="description">{{ $ticket->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nota del Administrador</label>
                                        <textarea type="text" rows="5" readonly id="note_admin"
                                            placeholder="En este campo estara la nota que deja el administrador que atendio su orden"
                                            class="form-control" name="note_admin">{{$ticket->note_admin}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group d-flex justify-content-center">
                                        <div class="controls">
                                            @if ( $ticket->status == 0 )
                                            <a class=" btn btn-info text-white text-bold-600">En Espera</a>
                                            @elseif($ticket->status == 1)
                                            <a class=" btn btn-success text-white text-bold-600">Solucionado</a>
                                            @elseif($ticket->status == 2)
                                            <a class=" btn btn-warning text-white text-bold-600">Procesando</a>
                                            @elseif($ticket->status == 3)
                                            <a class=" btn btn-danger text-white text-bold-600">Cancelada</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
