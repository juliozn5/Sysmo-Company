@if (strtolower($type) == 'tree')
@if ($cant < 2 && $ladouser == $side)
<li>
    <img src="{{ asset('images/logo/logoarbol.png') }}"
        alt="" width="64px">
</li>
@endif
@endif