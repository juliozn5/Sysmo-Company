@props(['submit'])
        <form wire:submit.prevent="{{ $submit }}">
                <div class="mb-2">
                    {{ $form ?? '' }}
                </div>

            @if (isset($actions))
                <div class="flex items-center justify-end text-right">
                {{ $actions }}
                </div>
            @endif
        </form>

