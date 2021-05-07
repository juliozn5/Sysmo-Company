@extends('layouts/contentLayoutMaster')

@section('title', 'show-tickets')

@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <h1 class="content-header-title float-left mr-2">Sysmo Company</h1>
                        <li class="breadcrumb-item"><a href="#">Tienda</a></li>
                        <li class="breadcrumb-item"><a href="#">Revisando Producto</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="basic-vertical-layouts">
    <div class="row match-height d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Revisando la Orden #{{ $store->id}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" id="name" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" name="name" value="{{ $store->getProduct->name }}" disabled />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Descripcion</label>
                                        <textarea type="text" id="description" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" name="description" disabled>{{ $store->getProduct->description }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <input type="number" id="amount" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" name="amount" value="{{ $store->getProduct->amount }}" disabled/>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group d-flex justify-content-center">
                                        <div class="controls">
                                            @if ( $store->status == 0 )
                                            <a href="{{ route('store.list-user') }}" class=" btn btn-info text-white text-bold-600">En Espera</a>
                                            @elseif($store->status == 1)
                                            <a href="{{ route('store.list-user') }}" class=" btn btn-success text-white text-bold-600">Atendido</a>
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
