<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-sm btn-primary mb-75 mr-75']) }}>
    {{ $slot }}
</button>
