@extends('layouts/contentLayoutMaster')

@section('title', 'Account Settings')

@section('vendor-style')
<!-- vendor css files -->
<link rel='stylesheet' href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
<link rel='stylesheet' href="{{ asset('vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@endsection
@section('page-style')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-pickadate.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
@endsection

<script src="{{ mix('js/app.js') }}" defer></script>
 @livewireScripts

@section('content')
<!-- account setting page -->
<section id="page-account-settings">
    <div class="row">
        <!-- left menu section -->
        <div class="col-md-3 mb-2 mb-md-0">
            <ul class="nav nav-pills flex-column nav-left">
                <!-- general -->
                <li class="nav-item">
                    <a class="nav-link active" id="account-pill-general" data-toggle="pill"
                        href="#account-vertical-general" aria-expanded="true">
                        <i data-feather="user" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">Informacion General</span>
                    </a>
                </li>
            </ul>
        </div>
        <!--/ left menu section -->

        <!-- right content section -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <!-- general tab -->
                        <div role="tabpanel" class="tab-pane active" id="account-vertical-general"
                            aria-labelledby="account-pill-general" aria-expanded="true">
                            <section submit="updateProfileInformation">



                                <form action="{{ route('user.update',$user->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                 
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <h2 class="font-weight-bold">Datos Personales de <span class="text-primary">{{$user->username}}</span></h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="required" for="">Nombre</label>
                                                    <input type="text"
                                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                                        id="username" name="username" placeholder="Nombre"
                                                        value="{{ $user->username }}">
                                                </div>
                                            </div>
                                        </div>
                                
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="required" for="email">Email</label>
                                                    <input type="email"
                                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                                        id="email" name="email" placeholder="Email"
                                                        value="{{ $user->email }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="required" for="whatsapp">Whatsapp</label>
                                                    <input type="text"
                                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                                        name="whatsapp" value="{{ $user->whatsapp }}"
                                                        placeholder="whatsapp">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="required" for="whatsapp">Role</label>
                                                    <select id="role" type="text" class="mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" wire:model.defer="state.role" >
                                                        <option value="0" @if($user->role == '0') selected  @endif>Normal</option>
                                                        <option value="1" @if($user->role == '1') selected  @endif>Administrador</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label class="required" for="whatsapp">Estado</label>
                                                    <select id="status" type="text" class="mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" wire:model.defer="state.status" >
                                                        <option value="0" @if($user->status == '0') selected  @endif>Inactivo</option>
                                                        <option value="1" @if($user->status == '1') selected  @endif>Activo</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                  
                                  

                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                            <button type="submit"
                                                class="btn btn-primary mr-sm-1 mb-1 mb-sm-0 waves-effect waves-light">GUARDAR</button>
                                        </div>
                                    </div>
                                </form>

                            </section>
                            
                        </div>
                        <!--/ general tab -->

                    </div>
                </div>
            </div>
        </div>
        <!--/ right content section -->
    </div>
</section>
<!-- / account setting page -->
@endsection