@extends('layouts.dashboard')

@section('content')

<section class="multiple-validation">
    <div class="row"> 
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Atendiendo la orden #{{ $orden->id}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form id="contact-form" method="POST" action="{{ route('record_order.update-admin', $orden->id)}}"
                            role="form">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Nombre del Usuario</label>
                                            <input type="text" class="form-control" readonly
                                                value="{{ $orden->getOrdenUser->username}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Email</label>
                                            <input type="email" class="form-control" readonly
                                                value="{{ $orden->getOrdenUser->email}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Whatsapp</label>
                                            <input type="text" class="form-control" readonly
                                                value="{{ $orden->getOrdenUser->whatsapp}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Whatsapp</label>
                                            <input type="text" class="form-control" readonly
                                                value="{{ $orden->link}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Categoria</label>
                                            <input type="text" class="form-control" readonly
                                                value="{{ $orden->getOrdenCategorie->name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Servicio</label>
                                            <input type="text" class="form-control" readonly
                                                value="{{ $orden->getOrdenService->package_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Cantidad de Servicio</label>
                                            <input type="text" class="form-control" readonly 
                                            value="{{ $orden->cantidad}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Monto de la Orden</label>
                                            <input type="text" class="form-control" readonly 
                                            value="{{ $orden->total}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Fecha de Creacion</label>
                                            <input type="text" class="form-control" readonly
                                                value="{{ $orden->created_at}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Seguidores Actuales</label>
                                            <input type="number" class="form-control" name="count_start" id="count_start"
                                                value="{{ $orden->count_start}}"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label>Seguidores del Servicio</label>
                                            <input type="number" class="form-control" name="count_end" id="count_end"
                                                value="{{ $orden->count_end}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="status">Estado de la Orden <span
                                                    class="text-danger">OBLIGATORIO</span></label>
                                            <select name="status" id="status"
                                                class="custom-select status @error('status') is-invalid @enderror"
                                                required data-toggle="select">
                                                <option value="0" @if($orden->status == '0') selected  @endif>Pendiente</option>
                                                <option value="1" @if($orden->status == '1') selected  @endif>En progreso</option>
                                                <option value="2" @if($orden->status == '2') selected  @endif>Completada</option>
                                                <option value="3" @if($orden->status == '3') selected  @endif>Cancelada</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection