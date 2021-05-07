<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center btn btn-primary border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
