<div class="coinbase d-none">
    <form action="{{route('addsaldo.coinbase')}}" method="POST" id="coinbaseform">
        {{ csrf_field() }}
        <input type="hidden" name="saldo" :value="Saldo">
        <input type="hidden" name="total" :value="Total">
    </form>
</div>