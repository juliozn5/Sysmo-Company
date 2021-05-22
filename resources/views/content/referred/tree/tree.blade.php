@extends('layouts/contentLayoutMaster')

@section('title', 'tree')

@section('content')



{{-- @if (Auth::user()->id == 1)
<div class="card">
	<div class="card-content">
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-sm-6 col-md-10">
					<label class="control-label " style="text-align: center; margin-top:4px;">id Usuario</label>
					<input class="form-control form-control-solid placeholder-no-fix" type="number" autocomplete="off"
						name="user_id" id="user_id" required style="background-color:f7f7f7;" />
				</div>
				<div class="col-12 text-center col-md-2" style="padding-left: 10px;">
					<button class="btn btn-primary mt-2" type="submit" onclick="buscar('{{$type}}')">Buscar</button>
</div>
</div>
</div>
</div>
</div>
@endif --}}

<div class="col-12 text-center">
    <button class="btn btn-primary float-lg-right"
        data-link="http://localhost:8000/register?referred_id={{Auth::user()->id}}" id="referrals_link"
        onclick="copyReferralsLink();">Copiar link de referido <i class="far fa-copy"></i></button>
    <div class="padre">
        <ul>
            <li class="baseli">
                <a class="base" href="#">
                    @if (Auth::user()->profile_photo_path != NULL)
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{$base->name}}" title="{{$base->name}}"
                        height="96">
                    @else
                    <img src="{{ asset('images/logo/logoarbol.png') }}" alt="{{$base->name}}" title="{{$base->name}}"
                        height="96">
                    @endif
                </a>
                <ul>
                    @foreach ($trees as $child)
                    {{-- lado Derecho --}}
                    @include('content.referred.tree.sideempty', ['side' => 'D', 'cant' =>
                    count($base->children),'ladouser' => $child->ladomatriz])
                    <li>
                        @include('content.referred.tree.infouser', ['data' => $child])
                        {{-- nivel 2 --}}
                        @if (!empty($child->children))
                        <ul>
                            @foreach ($child->children as $child2)
                            {{-- lado Derecho --}}
                            @include('content.referred.tree.sideempty', ['side' => 'D', 'cant' =>
                            count($child->children),'ladouser' => $child2->ladomatriz])
                            <li>

                                @include('content.referred.tree.infouser', ['data' => $child2])
                                {{-- nivel 3 --}}
                                @if (!empty($child2->children))
                                <ul>
                                    @foreach ($child2->children as $child3)
                                    {{-- lado Derecho --}}
                                    @include('content.referred.tree.sideempty', ['side' => 'D', 'cant' =>
                                    count($child2->children),'ladouser' => $child3->ladomatriz])
                                    <li>
                                        @include('content.referred.tree.infouser', ['data' => $child3])
                                        {{-- nivel 4
												@if (!empty($child3->children))
												<ul>
													@foreach ($child3->children as $child4)
													lado Derecho
													@include('content.referred.tree.sideempty', ['side' => 'D', 'cant' => count($child3->children)])
													<li>
														@include('content.referred.tree.infouser', ['data' => $child4])
		
														@if (!empty($child4->children))
														nivel 5
														<ul>
															@foreach ($child4->children as $child5)
															lado Derecho
															@include('content.referred.tree.sideempty', ['side' => 'D', 'cant' => count($child4->children)])
															<li>
																@include('content.referred.tree.infouser', ['data' => $child5])
															</li>
															lado Izquierdo
															@include('content.referred.tree.sideempty', ['side' => 'I', 'cant' => count($child4->children)])
															@endforeach
														</ul>
														fin nivel 5
														@endif
													</li>
													lado Izquierdo
													@include('content.referred.tree.sideempty', ['side' => 'I', 'cant' => count($child3->children)])
													@endforeach
												</ul>
												@endif
												fin nivel 4 --}}
                                    </li>
                                    {{-- lado Izquierdo --}}
                                    @include('content.referred.tree.sideempty', ['side' => 'I', 'cant' =>
                                    count($child2->children), 'ladouser' => $child3->ladomatriz])
                                    @endforeach
                                </ul>
                                @endif
                                {{-- fin nivel 3 --}}
                            </li>
                            {{-- lado Izquierdo --}}
                            @include('content.referred.tree.sideempty', ['side' => 'I', 'cant' =>
                            count($child->children), 'ladouser' => $child2->ladomatriz])
                            @endforeach
                        </ul>
                        @endif
                        {{-- fin nivel 2 --}}
                    </li>
                    {{-- lado Izquierdo --}}
                    @include('content.referred.tree.sideempty', ['side' => 'I', 'cant' => count($base->children),
                    'ladouser' => $child->ladomatriz])
                    @endforeach
                </ul>
                {{-- fin nivel 1 --}}
            </li>
        </ul>
    </div>

    @if (Auth::id() != $base->id)
    <div class="col-12 text-center">
        <a class="btn btn-info" href="{{route('tree_type', strtolower($type))}}">Regresar a mi arbol</a>
    </div>
    @endif
</div>
@endsection


<script> 
    function referred(id, type) {
        let ruta = "{{url('user/referred')}}/" + type + '/' + id
        window.location.href = ruta
    }
    
    function copyReferralsLink() {
        let copyText = $('#referrals_link').attr('data-link');
        const textArea = document.createElement('textarea');
        textArea.textContent = copyText;
        document.body.append(textArea);
        textArea.select();
        document.execCommand("copy");
        textArea.remove();
    }

</script>
