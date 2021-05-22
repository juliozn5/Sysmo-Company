<img title="{{ ucwords($data->username) }}" src="{{ $data->logoarbol }}" style="width:64px"
    onclick="referred('{{base64_encode($data->id)}}', '{{$type}}')">

<div class="inforuser">
    <div class="card mb-0" style="background: #000d2f">
        <div class="card-header mx-auto">
            <div class="avatar avatar-xl">
                <img class="img-fluid" src="{{ $data->logoarbol }}" alt="img placeholder">
            </div>
        </div>
        <div class="card-content">
            <div class="card-body text-center " style="background: #000d2f">
                <div class="d-flex justify-content-center">
                    <div>
                        <h6 class="text-white mb-1">
                            <strong>Usuario:</strong> {{$data->username}} 
                        </h6>
                        <h6 class="text-white mb-1">
                            <strong>Email:</strong> {{$data->email}}
                        </h6>
                        <h6 class="text-white mb-1">
                            <strong>Estado:</strong> @if($data->status == 0) Inactivo @else Activo @endif
                        </h6>
                        <h6 class="text-white mb-1">
                            <strong>Fecha Ingreso:</strong> {{date('d-m-Y', strtotime($data->created_at))}}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>