<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
            <!-- Profile Photo File Input -->
            <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                  photoName = $refs.photo.files[0].name;
                                  const reader = new FileReader();
                                  reader.onload = (e) => {
                                      photoPreview = e.target.result;
                                  };
                                  reader.readAsDataURL($refs.photo.files[0]);
                          " />

            {{-- <x-jet-label for="photo" value="{{ __('Photo') }}" /> --}}

            <!-- Current Profile Photo -->
            @if (Auth::user()->profile_photo_path != NULL)
            <div class="mt-2" x-show="! photoPreview">
                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                    class="rounded-full h-20 w-20 object-cover">
            </div>
            @else
            <div class="mt-2" x-show="! photoPreview">
                <img src="https://ui-avatars.com/api/?background=random&name={{ Auth::user()->username }}"
                    alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
            </div>
            @endif

            <!-- New Profile Photo Preview -->
            <div class="mt-2" x-show="photoPreview">
                <span class="block rounded-full w-20 h-20"
                    x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                </span>
            </div>
            <p class="mt-1">JPG, JPEG o PNG permitidos. Tamaño máximo de 1mb</p>

            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('Selecionar Nueva foto') }}
            </x-jet-secondary-button>

            @if ($this->user->profile_photo_path)
            <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                {{ __('Revomer foto actual') }}
            </x-jet-secondary-button>
            @endif

            <x-jet-input-error for="photo" class="mt-2" />
        </div>
        @endif
        <div class="row">
            <!-- Name -->
            <div class="col-6 mb-2 ">
                <x-jet-label for="username" value="{{ __('username') }}" />
                <x-jet-input id="username" type="text" class="mt-1 block w-full" wire:model.defer="state.username"
                    autocomplete="username" />
                <x-jet-input-error for="username" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-6 mb-2 ">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                <x-jet-input-error for="email" class="mt-2" />
            </div>

            <!-- whatsapp -->
            <div class="col-3 mb-2 ">
                <x-jet-label for="whatsapp" value="{{ __('whatsapp') }}" />
                <x-jet-input id="whatsapp" type="text" class="mt-1 block w-full" wire:model.defer="state.whatsapp" />
                <x-jet-input-error for="whatsapp" class="mt-2" />
            </div>

             <!-- balance -->
             <div class="col-3 mb-2 ">
                <x-jet-label for="balance" value="{{ __('balance') }}" />
                <x-jet-input id="balance" type="number" class="mt-1 block w-full" wire:model.defer="state.balance" />
                <x-jet-input-error for="balance" class="mt-2" />
            </div>

            <!-- role -->
            <div class="col-3 mb-2 ">
                <x-jet-label for="role" value="{{ __('role') }}" />
                <select id="role" type="number" class="mt-1 block w-full" wire:model.defer="state.role" >
                    <option value="0" @if(Auth::user()->role == '0') selected  @endif>Normal</option>
                    <option value="1" @if(Auth::user()->role == '1') selected  @endif>Administrador</option>
            </select>
                <x-jet-input-error for="role" class="mt-2" />
            </div>

              <!-- status -->
              <div class="col-3 mb-2 ">
                <x-jet-label for="status" value="{{ __('status') }}" />
                <select id="status" type="number" class="mt-1 block w-full" wire:model.defer="state.status" >
                    <option value="0" @if(Auth::user()->status == '0') selected  @endif>Inactivo</option>
                    <option value="1" @if(Auth::user()->status == '1') selected  @endif>Activo</option>
            </select>
                <x-jet-input-error for="status" class="mt-2" />
            </div>

        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Cambios Guardados Exitosamente.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Guardar') }}
        </x-jet-button>
    </x-slot>


</x-jet-form-section>
