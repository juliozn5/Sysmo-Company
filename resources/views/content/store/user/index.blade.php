@extends('layouts/contentLayoutMaster')

@section('title', 'Store')

@section('content')

<section id="columns">
    <div class="row">

        @foreach ( $store as $item )
        @if ($item->status == 1)
        
        <div class="col-4">
            <form action="{{ route('shop.save') }}" method="POST">
                {{ csrf_field() }}
                <input type="text" value="{{ $item->id }}" class=" d-none" name="id">
                <div class="card">
                    <div class="card-content">
                        <div class="d-flex justify-content-center mt-2">
                        <img class="" src="{{asset('store/'.$item->photoDB)}}" height="180" width="230" alt="Card">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title float-right">{{ $item->public_value }} $</h4>
                            <input type="text" value="{{ $item->public_value }}" class=" d-none" name="public_value">
                            <h4 class="card-title">⭐⭐⭐⭐⭐</h4>
                            <br>
                            <h6 class="card-title small font-weight-medium">{{ $item->store }}</h6>
                            <input type="text" value="{{ $item->store }}" class=" d-none" name="store">
                            <p class="card-text">{{ $item->description }}</p>
                        </div>
                        @if (Auth::user()->balance >= $item->amount)
                        <button type="submit" class="col-12 btn btn-lg btn-success waves-effect waves-light"><i class="feather icon-shopping-cart mr-1"></i> Comprar</button>    
                        @else
                        <button type="submit" class="col-12 btn btn-lg btn-danger waves-effect waves-light"><i class="feather icon-alert-circle mr-1"></i> Saldo Insuficiente</button> 
                        @endif
                        
                    </div>
                </div>
            </form>
        </div>
        @endif
        @endforeach

    </div>
</section>

@endsection
