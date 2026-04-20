<div>
    @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-background/80 backdrop-blur-sm">
        <div class="relative w-full max-w-lg p-6 bg-card rounded-xl border border-border shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-foreground">Tambah Tenant Baru</h3>
                <button wire:click="$set('isOpen', false)" class="text-muted-foreground hover:text-foreground">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                <!-- Company Info -->
                <div class="space-y-2 p-4 bg-muted/20 rounded-lg border border-border">
                    <p class="text-xs font-bold uppercase text-muted-foreground mb-2">Informasi Perusahaan</p>
                    <div>
                        <x-input-label for="name" value="Nama Perusahaan" />
                        <x-text-input wire:model="name" id="name" type="text" class="mt-1 block w-full" placeholder="Contoh: Klinik Medika" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="business_type" value="Tipe Bisnis" />
                        <select wire:model="business_type" id="business_type" class="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                            <option value="retail">Retail (Toko)</option>
                            <option value="health">Health (Klinik)</option>
                            <option value="library">Library (Perpustakaan)</option>
                        </select>
                        <x-input-error :messages="$errors->get('business_type')" class="mt-2" />
                    </div>
                </div>

                <!-- Admin Info -->
                <div class="space-y-2 p-4 bg-primary/5 rounded-lg border border-primary/10">
                    <p class="text-xs font-bold uppercase text-primary mb-2">Akun Admin Perusahaan</p>
                    <div>
                        <x-input-label for="admin_name" value="Nama Admin" />
                        <x-text-input wire:model="admin_name" id="admin_name" type="text" class="mt-1 block w-full" placeholder="Nama lengkap admin" />
                        <x-input-error :messages="$errors->get('admin_name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="admin_email" value="Email Admin" />
                        <x-text-input wire:model="admin_email" id="admin_email" type="email" class="mt-1 block w-full" placeholder="email@admin.com" />
                        <x-input-error :messages="$errors->get('admin_email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="admin_password" value="Password Awal" />
                        <x-text-input wire:model="admin_password" id="admin_password" type="password" class="mt-1 block w-full" placeholder="Min 8 karakter" />
                        <x-input-error :messages="$errors->get('admin_password')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <x-secondary-button wire:click="$set('isOpen', false)" type="button">Batal</x-secondary-button>
                    <x-primary-button type="submit">Daftarkan Tenant</x-primary-button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
