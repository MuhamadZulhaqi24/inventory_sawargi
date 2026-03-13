<x-guest-layout title="Login">
    <div class="min-h-screen bg-[#F3F4F6] flex items-center justify-center p-6 relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full -mr-64 -mt-64 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-primary/5 rounded-full -ml-64 -mb-64 blur-3xl"></div>

        <div class="w-full max-w-[420px] bg-white rounded-[16px] shadow-[0_20px_40px_rgba(0,0,0,0.08)] p-10 relative z-10 border border-white">
            <div class="mb-10 text-center">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <x-application-logo class="w-10 h-10 fill-current text-primary" />
                    <span class="text-xs font-black uppercase tracking-[0.3em] text-muted-foreground">{{ config('app.name') }}</span>
                </div>
                <h1 class="text-3xl font-black text-foreground uppercase tracking-tight">Login</h1>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Username -->
                <div class="space-y-2">
                    <x-input-label for="username" :value="__('Username')" class="font-bold uppercase tracking-widest text-[10px]" />
                    <x-text-input
                        id="username"
                        name="username"
                        type="text"
                        class="block w-full rounded-[8px] border-[#E5E7EB] h-12 focus:border-primary focus:ring-primary/20 transition-all shadow-sm"
                        :value="old('username')"
                        placeholder="Masukkan username Anda"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('username')" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <x-input-label for="password" :value="__('Password')" class="font-bold uppercase tracking-widest text-[10px]" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full rounded-[8px] border-[#E5E7EB] h-12 focus:border-primary focus:ring-primary/20 transition-all shadow-sm"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary focus:ring-offset-0" name="remember">
                    <span class="ms-2 text-sm font-medium text-muted-foreground">{{ __('Ingat saya') }}</span>
                </div>

                <div class="pt-2 flex flex-col gap-3">
                    <x-primary-button class="w-full py-4 rounded-[8px] font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        {{ __('Masuk') }}
                    </x-primary-button>

                    <a href="{{ route('home') }}" class="w-full py-3 rounded-[8px] font-bold text-xs uppercase tracking-[0.2em] text-center text-muted-foreground bg-muted/50 hover:bg-muted hover:text-foreground transition-all">
                        &larr; {{ __('messages.back_to_dashboard') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
