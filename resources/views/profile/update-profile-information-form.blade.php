<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
    </x-slot>

    <x-slot name="description">
    </x-slot>

    <x-slot name="form">

      <div class="media">
        <a href="javascript:void(0);" class="mr-25">
    
            @if (Auth::user()->profile_photo_path != NULL)
            <img src="{{ $this->user->profile_photo_url }}" id="account-upload-img" class="rounded mr-50"
                alt="profile image" height="80" width="80" />
            @else
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}" id="account-upload-img"
                class="rounded mr-50" alt="profile image" height="80" width="90" />
            @endif
        </a>
        <!-- upload and reset button -->
        <div class="media-body mt-75 ml-1">
            <label for="account-upload" class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
            <input type="file" id="account-upload" hidden accept="image/*" />
            <button class="btn btn-sm btn-outline-secondary mb-75">Reset</button>
            <p>Allowed JPG, GIF or PNG. Max size of 800kB</p>
        </div>
        <!--/ upload and reset button -->
    </div>
    <!--/ header media -->
    
    <!-- form -->
    <form class="validate-form mt-2">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="account-username">Username</label>
                    <input type="text" class="form-control" id="account-username" name="username" placeholder="Username"
                        value="johndoe" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                  <x-jet-label for="username" value="{{ __('username') }}" />
                  <x-jet-input id="username" type="text" class="mt-1 block w-full" wire:model.defer="state.username"
                      autocomplete="username" />
                  <x-jet-input-error for="username" class="mt-2" />
              </div>
            </div>
    
            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-2 mr-1">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary mt-2">Cancel</button>
            </div>
        </div>
    </form>

    
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

            <x-jet-label for="photo" value="{{ __('Photo') }}" />

            <!-- Current Profile Photo -->
            @if (Auth::user()->profile_photo_path != NULL)
            <div class="mt-2" x-show="! photoPreview">
                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                    class="rounded-full h-20 w-20 object-cover">
            </div>
            @else
            <div class="mt-2" x-show="! photoPreview">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username }}" alt="{{ $this->user->name }}"
                    class="rounded-full h-20 w-20 object-cover">
            </div>
            @endif


            <!-- New Profile Photo Preview -->
            <div class="mt-2" x-show="photoPreview">
                <span class="block rounded-full w-20 h-20"
                    x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                </span>
            </div>

            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('Select A New Photo') }}
            </x-jet-secondary-button>

            @if ($this->user->profile_photo_path)
            <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </x-jet-secondary-button>
            @endif

            <x-jet-input-error for="photo" class="mt-2" />
        </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="username" value="{{ __('username') }}" />
            <x-jet-input id="username" type="text" class="mt-1 block w-full" wire:model.defer="state.username"
                autocomplete="username" />
            <x-jet-input-error for="username" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>

    
</x-jet-form-section>




