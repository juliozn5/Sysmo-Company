@extends('layouts/contentLayoutMaster')

@section('title', 'Store')

@section('content')

<section id="columns">
    <div class="row">

        @foreach ( $store as $item )
        @if ($item->status == 1)
        
        <div class="col-3">
            <form action="{{ route('store.save') }}" method="POST">
                {{ csrf_field() }}
                <input type="number" value="{{ $item->id }}" class=" d-none" name="id">
                <div class="card">
                    <div class="card-content">
                        <div class="d-flex justify-content-center mt-2">
                        <img class="" src="{{asset('storage/products/'.$item->photoDB)}}" height="180" width="230" alt="Card">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title float-right pb-0">{{ $item->price }} $</h4>
                            <input type="number" value="{{ $item->price }}" class=" d-none" name="price">
                            <h4 class="card-title">⭐⭐⭐⭐⭐</h4>
                            <br>
                            <h6 class="card-title small font-weight-medium">{{ $item->name }}</h6>
                            <input type="text" value="{{ $item->name }}" class=" d-none" name="name">
                            <p class="card-text">{{ $item->description }}</p>
                        </div>
                        @if (Auth::user()->balance >= $item->price)
                        <button type="submit" class="col-12 btn btn-lg btn-success waves-effect waves-light"><i data-feather='shopping-bag' class="mr-1"></i> Comprar</button>    
                        @else
                        <button type="submit" class="col-12 btn btn-lg btn-danger waves-effect waves-light"><i data-feather='alert-circle' class=" mr-1"></i>Saldo Insuficiente</button> 
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
