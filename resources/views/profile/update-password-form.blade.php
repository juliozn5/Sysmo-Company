<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
      <form class="validate-form">
        <div class="row">
          <div class="col-12 col-sm-6">
            <div class="form-group">
              <label for="account-old-password">Old Password</label>
              <div class="input-group form-password-toggle input-group-merge">
                <input
                  type="password"
                  class="form-control"
                  id="account-old-password"
                  name="password"
                  placeholder="Old Password"
                />
                <div class="input-group-append">
                  <div class="input-group-text cursor-pointer">
                    <i data-feather="eye"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6">
            <div class="form-group">
              <label for="account-new-password">New Password</label>
              <div class="input-group form-password-toggle input-group-merge">
                <input
                  type="password"
                  id="account-new-password"
                  name="new-password"
                  class="form-control"
                  placeholder="New Password"
                />
                <div class="input-group-append">
                  <div class="input-group-text cursor-pointer">
                    <i data-feather="eye"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="form-group">
              <label for="account-retype-new-password">Retype New Password</label>
              <div class="input-group form-password-toggle input-group-merge">
                <input
                  type="password"
                  class="form-control"
                  id="account-retype-new-password"
                  name="confirm-new-password"
                  placeholder="New Password"
                />
                <div class="input-group-append">
                  <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary mr-1 mt-1">Save changes</button>
            <button type="reset" class="btn btn-outline-secondary mt-1">Cancel</button>
          </div>
        </div>
      </form>
      
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" value="{{ __('Current Password') }}" />
            <x-jet-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('New Password') }}" />
            <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
            <x-jet-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

