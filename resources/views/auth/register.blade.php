<x-guest-layout title="Register">
    <div class="min-h-screen bg-[#F3F4F6] flex items-center justify-center p-6 relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full -mr-64 -mt-64 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-primary/5 rounded-full -ml-64 -mb-64 blur-3xl"></div>

        <div class="w-full max-w-[500px] bg-white rounded-[16px] shadow-[0_20px_40px_rgba(0,0,0,0.08)] p-8 sm:p-10 my-8 relative z-10 border border-white">
            <div class="mb-8 text-center">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <x-application-logo class="w-10 h-10 fill-current text-primary" />
                    <span class="text-xs font-black uppercase tracking-[0.3em] text-muted-foreground">{{ config('app.name') }}</span>
                </div>
                <h1 class="text-3xl font-black text-foreground uppercase tracking-tight">Register</h1>
                <p class="text-muted-foreground mt-2 font-medium">Join us as a customer to start building today.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div class="space-y-1.5">
                    <x-input-label for="name" :value="__('Full Name')" class="font-bold uppercase tracking-widest text-[10px]" />
                    <x-text-input id="name" name="name" type="text" class="block w-full rounded-[8px] border-[#E5E7EB] h-11 focus:border-primary focus:ring-primary/20 transition-all shadow-sm" :value="old('name')" placeholder="John Doe" required autofocus />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Username -->
                    <div class="space-y-1.5">
                        <x-input-label for="username" :value="__('Username')" class="font-bold uppercase tracking-widest text-[10px]" />
                        <x-text-input id="username" name="username" type="text" class="block w-full rounded-[8px] border-[#E5E7EB] h-11 focus:border-primary focus:ring-primary/20 transition-all shadow-sm" :value="old('username')" placeholder="johndoe" required />
                        <x-input-error :messages="$errors->get('username')" />
                    </div>

                    <!-- Phone -->
                    <div class="space-y-1.5">
                        <x-input-label for="phone" :value="__('Phone Number')" class="font-bold uppercase tracking-widest text-[10px]" />
                        <x-text-input id="phone" name="phone" type="text" class="block w-full rounded-[8px] border-[#E5E7EB] h-11 focus:border-primary focus:ring-primary/20 transition-all shadow-sm" :value="old('phone')" placeholder="08123456789" required />
                        <x-input-error :messages="$errors->get('phone')" />
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <x-input-label for="email" :value="__('Email Address')" class="font-bold uppercase tracking-widest text-[10px]" />
                    <x-text-input id="email" name="email" type="email" class="block w-full rounded-[8px] border-[#E5E7EB] h-11 focus:border-primary focus:ring-primary/20 transition-all shadow-sm" :value="old('email')" placeholder="john@example.com" required />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Address -->
                <div class="space-y-1.5">
                    <x-input-label for="address" :value="__('Complete Address')" class="font-bold uppercase tracking-widest text-[10px]" />
                    <textarea id="address" name="address" rows="2" class="block w-full rounded-[8px] border-[#E5E7EB] focus:border-primary focus:ring-primary/20 transition-all text-sm shadow-sm" placeholder="Your delivery address...">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div class="space-y-1.5">
                        <x-input-label for="password" :value="__('Password')" class="font-bold uppercase tracking-widest text-[10px]" />
                        <x-text-input id="password" name="password" type="password" class="block w-full rounded-[8px] border-[#E5E7EB] h-11 focus:border-primary focus:ring-primary/20 transition-all shadow-sm" placeholder="••••••••" required />
                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <x-input-label for="password_confirmation" :value="__('Confirm')" class="font-bold uppercase tracking-widest text-[10px]" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-[8px] border-[#E5E7EB] h-11 focus:border-primary focus:ring-primary/20 transition-all shadow-sm" placeholder="••••••••" required />
                    </div>
                </div>

                <div class="pt-2 flex flex-col gap-3">
                    <x-primary-button class="w-full py-4 rounded-[8px] font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        {{ __('Create Account') }}
                    </x-primary-button>

                    <a href="{{ route('home') }}" class="w-full py-3 rounded-[8px] font-bold text-xs uppercase tracking-[0.2em] text-center text-muted-foreground bg-muted/50 hover:bg-muted hover:text-foreground transition-all">
                        &larr; {{ __('messages.back_to_dashboard') }}
                    </a>
                </div>

                <div class="text-center pt-4 border-t border-gray-100 mt-2">
                    <p class="text-sm font-medium text-muted-foreground">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-black text-primary hover:text-orange-600 transition-colors uppercase tracking-tight ml-1">
                            Log in
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
