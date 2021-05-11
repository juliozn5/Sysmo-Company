<div class="modal fade" id="resumenOrden" tabindex="-1" role="dialog" aria-labelledby="resumenOrdenTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resumenOrdenTitle">Detalles del compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Session::get('resumen') !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Accept</button>
            </div>
        </div>
    </div>
</div>

@push('custom_js')
<script>
    $(document).ready(function (){  
        $('#resumenOrden').modal('show')
    })
</script>
@endpush