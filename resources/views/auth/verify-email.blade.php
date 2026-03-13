<x-guest-layout title="Verify Email">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#F3F4F6]">
        <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white shadow-2xl rounded-2xl overflow-hidden">
            <div class="space-y-6">
                <div class="space-y-2 text-center">
                    <h1 class="text-2xl font-bold tracking-tight">Verify Email</h1>
                    <div class="text-sm text-muted-foreground leading-relaxed">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-100">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between flex-col space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                        @csrf

                        <div>
                            <x-primary-button class="w-full py-3">
                                {{ __('Resend Verification Email') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="w-full text-center border-t border-gray-100 pt-4">
                        @csrf

                        <button type="submit" class="font-semibold text-sm text-muted-foreground hover:text-primary transition-colors rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ring">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
