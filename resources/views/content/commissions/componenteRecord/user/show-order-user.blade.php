@extends('layouts.dashboard')

@section('content')

<section class="multiple-validation">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Revisando la orden #{{ $orden->id}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Nombre del Usuario</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $orden->getOrdenUser->username}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Email</label>
                                        <input type="email" class="form-control" readonly
                                            value="{{ $orden->getOrdenUser->email}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Whatsapp</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $orden->getOrdenUser->whatsapp}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Link</label>
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="controls">
                                        <label>Servicio</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $orden->getOrdenService->package_name}}">
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
                            <div class="col-12">
                                <div class="form-group d-flex justify-content-center">
                                    <div class="controls">
                                            @if ( $orden->status == 0 )
                                            <a class=" btn btn-info text-white text-bold-600">Pendiente</a>
                                            @elseif($orden->status == 1)
                                            <a class=" btn btn-warning text-white text-bold-600">En progreso</a>
                                            @elseif($orden->status == 2)
                                            <a class=" btn btn-success text-white text-bold-600">Completada</a>
                                            @elseif($orden->status == 3)
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
</section>

@endsection