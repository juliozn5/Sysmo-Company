@if (strtolower($type) == 'matriz')
@if ($cant < 2 && $ladouser == $side)
<li>
    <img src="{{ asset('images/logo/logoarbol.png') }}"
        alt="" style="width:64px">
</li>
@endif
@endif