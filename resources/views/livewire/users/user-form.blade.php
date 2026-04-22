<x-modal name="user-form-modal" :title="''" maxWidth="2xl">
    <div class="p-6">
        <!-- Custom Header -->
        <div class="mb-6 space-y-1.5 text-center sm:text-left border-b border-gray-200 pb-4">
            <h3 class="text-lg font-semibold leading-none tracking-tight text-foreground">
                {{ $isEditing ? __('messages.edit_user') : __('messages.create_new_user') }}
            </h3>
            <p class="text-sm text-muted-foreground">
                {{ $isEditing ? __('messages.edit_user_subtitle') : __('messages.add_user_record') }}
            </p>
        </div>

        <form wire:submit="save" class="space-y-4">
            <!-- Name -->
            <x-form-input
                name="name"
                :label="__('messages.name')"
                type="text"
                wire:model="name"
                required
                :placeholder="__('messages.full_name')"
            />

            <!-- Username -->
            <div class="grid grid-cols-1 {{ auth()->user()->is_super_admin ? 'md:grid-cols-2' : '' }} gap-4">
                <x-form-input
                    name="username"
                    :label="__('messages.username')"
                    type="text"
                    wire:model="username"
                    required
                    :placeholder="__('messages.unique_username')"
                />

                @if(auth()->user()->is_super_admin)
                <div class="space-y-2">
                    <x-input-label for="company_id" value="Company" />
                    <select wire:model="company_id" id="company_id" class="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                        <option value="">Select Company</option>
                        @foreach(\App\Models\Company::all() as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('company_id')" />
                </div>
                @endif
            </div>

            <!-- Email -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-input
                    name="email"
                    :label="__('messages.email')"
                    type="email"
                    wire:model="email"
                    required
                    placeholder="email@example.com"
                />

                <div class="space-y-2">
                    <x-input-label for="role_id" value="Role" />
                    <select wire:model="role_id" id="role_id" class="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                        <option value="">Pilih Role</option>
                        @foreach($this->availableRoles as $availableRole)
                            <option value="{{ $availableRole->id }}">{{ $availableRole->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role_id')" />
                </div>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <x-input-label for="password" :value="__('messages.password')" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        wire:model="password"
                        :required="!$isEditing"
                        autocomplete="new-password"
                        placeholder="{{ $isEditing ? __('messages.leave_blank_to_keep') : __('messages.min_8_chars') }}"
                    />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <div class="space-y-2">
                    <x-input-label for="password_confirmation" :value="__('messages.confirm_password')" />
                    <x-text-input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        wire:model="password_confirmation"
                        :required="!$isEditing"
                        autocomplete="new-password"
                    />
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-end gap-3 border-t border-gray-200 pt-4">
                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', { name: 'user-form-modal' })">
                    {{ __('messages.cancel') }}
                </x-secondary-button>

                <x-primary-button type="submit" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <x-heroicon-o-check wire:loading.remove wire:target="save" class="w-4 h-4 mr-2" />
                    {{ $isEditing ? __('messages.save_changes') : __('messages.add_user') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
