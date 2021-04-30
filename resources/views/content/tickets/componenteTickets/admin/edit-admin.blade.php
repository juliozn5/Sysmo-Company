@extends('layouts.dashboard')

@section('content')

<section id="basic-vertical-layouts">
    <div class="row match-height d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Atendiendo el Ticket #{{ $ticket->id}}</h4>
                    <h4 class="card-title mt-2">Usuario: <span class="text-primary">{{ $ticket->getUser->fullname}}</span></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{route('ticket.update-admin', $ticket->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
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
                                            <textarea type="text" rows="5" readonly id="description"
                                                class="form-control"
                                                name="description">{{ $ticket->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Nota del Administrador</label>
                                            <span class="text-danger text-bold-600">(Dejar nota Obligatoria para el
                                                usuario)</span>
                                            <textarea type="text" rows="5" id="note_admin"
                                                placeholder="En este campo estara la nota que deja el administrador que atendio su orden"
                                                class="form-control"
                                                name="note_admin">{{$ticket->note_admin}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="status">Estado del ticket</label>
                                                <span class="text-danger text-bold-600">OBLIGATORIO</span>
                                                <select name="status" id="status"
                                                    class="custom-select status @error('status') is-invalid @enderror"
                                                    required data-toggle="select">
                                                    <option value="0" @if($ticket->status == '0') selected  @endif>En Espera</option>
                                                    <option value="1" @if($ticket->status == '1') selected  @endif>Solucionado</option>
                                                    <option value="2" @if($ticket->status == '2') selected  @endif>Procesando</option>
                                                    <option value="3" @if($ticket->status == '3') selected  @endif>Cancelada</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit"
                                            class="btn btn-primary mr-1 mb-1 waves-effect waves-light">Actualizar
                                            Ticket</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
