<div class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-extrabold text-foreground sm:text-4xl">
                {{ __('messages.get_in_touch') }}
            </h2>
            <p class="mt-4 text-lg text-muted-foreground">
                {{ __('Hubungi kami untuk pertanyaan produk atau penawaran harga khusus proyek.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Contact Form -->
            <div class="bg-card p-8 rounded-2xl border border-border shadow-sm">
                <form wire:submit="sendMessage" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <x-input-label for="name" :value="__('messages.name')" />
                            <x-text-input wire:model="name" id="name" class="w-full" placeholder="John Doe" />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                        <div class="space-y-2">
                            <x-input-label for="email" :value="__('messages.email')" />
                            <x-text-input wire:model="email" id="email" type="email" class="w-full" placeholder="john@example.com" />
                            <x-input-error :messages="$errors->get('email')" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="subject" :value="__('messages.subject')" />
                        <x-text-input wire:model="subject" id="subject" class="w-full" placeholder="Project Quote" />
                        <x-input-error :messages="$errors->get('subject')" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="message" :value="__('messages.message')" />
                        <textarea wire:model="message" id="message" rows="5" class="w-full rounded-md border-input bg-background text-foreground shadow-sm focus:border-primary focus:ring-primary" placeholder="Detail your request..."></textarea>
                        <x-input-error :messages="$errors->get('message')" />
                    </div>

                    <x-primary-button type="submit" class="w-full justify-center py-3">
                        {{ __('messages.send_message') }}
                    </x-primary-button>
                </form>
            </div>

            <!-- Contact Info & Map -->
            <div class="space-y-8">
                <div class="grid grid-cols-1 gap-8">
                    <div class="flex items-start gap-4">
                        <div class="h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <x-heroicon-o-map-pin class="h-6 w-6 text-primary" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-foreground">{{ __('messages.address') }}</h3>
                            <p class="mt-1 text-muted-foreground">{{ \App\Models\Setting::get('store_address') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="h-12 w-12 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                            <x-heroicon-o-phone class="h-6 w-6 text-primary" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-foreground">{{ __('messages.phone') }}</h3>
                            <p class="mt-1 text-muted-foreground">{{ \App\Models\Setting::get('store_phone') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Simple Map Placeholder -->
                <div 
                    class="h-64 rounded-2xl bg-muted border border-border overflow-hidden relative flex items-center justify-center group"
                >
                    <img src="{{ asset('images/map-sawargi.png') }}" alt="Map Sawargi" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 flex items-center justify-center bg-background/20 transition-all duration-300 backdrop-blur-[2px] group-hover:backdrop-blur-0">
                        <p class="text-sm font-semibold text-foreground bg-background px-4 py-2 rounded-full shadow-lg border border-border group-hover:opacity-0 transition-opacity duration-300">
                            {{ __('Kertasari, Kec. Ciamis') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
