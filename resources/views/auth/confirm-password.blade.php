<x-guest-layout title="Confirm Password">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#F3F4F6]">
        <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white shadow-2xl rounded-2xl overflow-hidden">
            <div class="mb-4 text-sm text-muted-foreground">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="space-y-2">
                    <x-input-label for="password" :value="__('Password')" :required="true" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-6">
                    <x-primary-button class="w-full">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
