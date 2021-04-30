<x-jet-form-section submit="updatePassword">
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4 mt-1">
            <x-jet-label class="block font-medium text-sm text-gray-700" for="current_password">
                Contraseña Actual
            </x-jet-label>
            <div class="input-group input-group-merge">
                <input id="current_password" type="password"
                    class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md "
                    wire:model.defer="state.current_password" autocomplete="current-password" />
                <div class="input-group-append">
                    <div class="input-group-text cursor-pointer">
                        <i data-feather="eye"></i>
                    </div>
                </div>
            </div>
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4 mt-1">
            <x-jet-label class="block font-medium text-sm text-gray-700" for="password">
                Contraseña Nueva
            </x-jet-label>
            <div class="input-group input-group-merge">
                <input id="password" type="password"
                    class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md "
                    wire:model.defer="state.password" autocomplete="new-password" />
                <div class="input-group-append">
                    <div class="input-group-text cursor-pointer">
                        <i data-feather="eye"></i>
                    </div>
                </div>
            </div>
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4 mt-1">
            <x-jet-label class="block font-medium text-sm text-gray-700" for="password_confirmation">
                Repetir Contraseña Nueva
            </x-jet-label>
            <div class="input-group input-group-merge">
                <input id="password_confirmation" type="password"
                    class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md "
                    wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                <div class="input-group-append">
                    <div class="input-group-text cursor-pointer">
                        <i data-feather="eye"></i>
                    </div>
                </div>
            </div>
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Cambiada Exitosamente.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Guardar') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
