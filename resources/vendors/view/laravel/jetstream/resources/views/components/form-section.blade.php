@props(['submit'])
        <form wire:submit.prevent="{{ $submit }}">
            <div {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div>
                    {{ $form ?? '' }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
