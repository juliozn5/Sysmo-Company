@extends('layouts.dashboard')

{{-- permite llamar las librerias montadas --}}
@push('page_js')
<script src="{{asset('assets/js/librerias/vue.js')}}"></script>
<script src="{{asset('assets/js/librerias/axios.min.js')}}"></script>
@endpush

{{-- permite agregar js personalizados --}}
@push('custom_js')
<script src="{{asset('assets/js/addsaldo.js')}}"></script>
@endpush
{{-- permite agregar css personalizado --}}
@push('custom_css')
    <style>
        .btn-p{
            padding: 28px 20px !important;
        }
        .btn-payu-alt{
            background: #a5c312 !important;
        }
        .btn-stripe-alt{
            background: #03a9f4 !important;
        }
        .btn-coinbase-alt{
            background: #0667d0 !important;
        }
        .btn-skrill-alt{
            background: #862165 !important;
        }

        .saldo input, .saldo .form-control::placeholder{
            font-size: 1.3rem !important;
        }
        .saldo .input-group-append{
            margin-left: -5px !important;
            z-index: 2;
        }
        .saldo .input-group-append span{
            padding: 0.7rem 1.3rem !important;
            background-color: #683ccf !important;
            color: #ffffff !important;
            font-size: 1.3rem !important;
            border-radius: 15% !important;
            border: 0 !important

        }
    </style>
@endpush

@section('content')
<div id="addsaldo">
    {{-- cuerpo --}}
    <div class="container">
        <div class="row justify-content-center">
            {{-- Seccion de Orden --}}
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Añadir Fondos</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="javascript:;">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="text-muted">Elige el método de pago</h6>
                                    </div>
                                    <div class="col-6 col-md-3 text-center">
                                        <button class="btn btn-primary btn-p btn-stripe-alt" v-on:click="selectMethods('Stripe')">
                                            <img src="{{asset('assets/img/sistema/stripe.png')}}" alt="" height="35">
                                        </button>
                                    </div>
                                    <div class="col-6 col-md-3 text-center">
                                        <button class="btn btn-primary btn-p btn-payu-alt" v-on:click="selectMethods('Payulatam')">
                                            <img src="{{asset('assets/img/sistema/PAYU_LOGO_LIME.png')}}" alt="" height="35">
                                        </button>
                                    </div>
                                    <div class="col-6 col-md-3 text-center">
                                        <button class="btn btn-primary btn-p btn-coinbase-alt" v-on:click="selectMethods('Coinbase')">
                                            <img src="{{asset('assets/img/sistema/coinbase.png')}}" alt="" height="35">
                                        </button>
                                    </div>
                                    <div class="col-6 col-md-3 text-center">
                                        <button class="btn btn-primary btn-p btn-skrill-alt" v-on:click="selectMethods('Skrill')">
                                            <img src="{{asset('assets/img/sistema/skrill.png')}}" alt="" height="35">
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12" v-if="Metodo != 'Skrill'">
                                    <fieldset>
                                        <div class="col-12 mt-1">
                                            <p class="text-center text-muted">
                                                Tu puedes añadir fondos con @{{Metodo}}&reg;, se te añadirá automáticamente a tu cuenta!
                                            </p>
                                        </div>

                                        <h4 class="text-center"> Metodo de Pago Selecionado: @{{Metodo}}</h4>
    
                                        <label for="">Dinero (USD)</label>
                                        <div class="input-group saldo">
                                            <input type="text" class="form-control" placeholder="000.00" aria-describedby="basic-addon2" v-model.number="Saldo">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">$</span>
                                            </div>
                                        </div>
                                        <small>Transaction fee: @{{Fee}}%</small>
                                        <br>
                                        <label for="">Total a pagar</label>
                                        <div class="input-group saldo">
                                            <input type="text" class="form-control" placeholder="000.00" aria-describedby="basic-addon2" :value="totalPagar" disabled>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">$</span>
                                            </div>
                                        </div>
                                    </fieldset>
    
                                    <div class="form-group mt-2">
                                        <div class="col-12 d-flex justify-content-center mb-2">
                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                <input type="checkbox" checked="" v-model="CheckTerminos">
                                                <span class="vs-checkbox">
                                                    <span class="vs-checkbox--check">
                                                        <i class="vs-icon feather icon-check"></i>
                                                    </span>
                                                </span>
                                                <span class="">Si, yo acepto los</span>
                                            </div>
                                            <a href="{{route('terminos_condiciones')}}" target="_blank" style="margin: 0.25rem 0;">Terminos y condiciones de compra</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn text-white bg-purple-alt2 btn-block padding-button-short" v-on:click="StripeKey = '{{ env('STRIPE_KEY') }}', pagar()">PAGAR</button>
                                    </div>
                                </div>
                                <div class="col-12" v-else>
                                    <p class="mt-2 text-left">
                                        Para realizar un pago por <strong>@{{Metodo}}</strong> comunicate directamente con el servicio al cliente
                                        <ul>
                                            <li>Recuerda, el valor minimo de recarga es 20 USD</li>
                                            <li>Todo pago mediante <strong>@{{Metodo}}</strong> tiene una <strong>comisión del 10%</strong></li>
                                            <li><strong>No se realizan reembolso</strong> en caso de enviar un valor minimo al establecido para recargar</li>
                                        </ul>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Fin Seccion de Orden --}}
        </div>
    </div>
    {{-- procesar pago stripe --}}
    @include('addsaldo.formPasarelas.stripe')
    {{-- fin procesar pago stripe --}}
    {{-- procesar pago payu --}}
    @include('addsaldo.formPasarelas.payu')
    {{-- fin procesar pago payu --}}
    {{-- procesar pago coinbase --}}
    @include('addsaldo.formPasarelas.coinbase')
    {{-- fin procesar pago coinbase --}}
    {{-- modal de detalles de pago --}}
    @if (Session::has('resumen'))
    @include('addsaldo.formPasarelas.modalResumen')
    @endif
    {{-- fin modal de detalles de pago --}}
    {{-- modal de aviso --}}
    @include('servicios.componentes.modalAviso')
</div>
@endsection
