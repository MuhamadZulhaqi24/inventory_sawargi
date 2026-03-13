<div class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
            <div>
                <h2 class="text-3xl font-extrabold text-foreground sm:text-4xl">
                    {{ __('messages.our_story') }}
                </h2>
                <p class="mt-6 text-lg text-muted-foreground leading-relaxed">
                    {{ \App\Models\Setting::get('store_name') }} {{ __('telah menjadi mitra terpercaya bagi para pembangun dan pemilik rumah selama lebih dari satu dekade. Kami memulai perjalanan kami dari sebuah toko kecil di Ciamis dengan visi sederhana: menyediakan bahan bangunan berkualitas tinggi dengan harga yang jujur.') }}
                </p>
                <p class="mt-4 text-lg text-muted-foreground leading-relaxed">
                    {{ __('Hari ini, kami telah berkembang menjadi salah satu penyedia material konstruksi terlengkap di wilayah ini, melayani ribuan proyek mulai dari renovasi rumah tinggal hingga pembangunan gedung komersial besar.') }}
                </p>

                <div class="mt-10 grid grid-cols-2 gap-8">
                    <div>
                        <div class="text-4xl font-black text-primary">10+</div>
                        <div class="mt-1 text-sm font-semibold text-muted-foreground uppercase tracking-wider">{{ __('Tahun Pengalaman') }}</div>
                    </div>
                    <div>
                        <div class="text-4xl font-black text-primary">20k+</div>
                        <div class="mt-1 text-sm font-semibold text-muted-foreground uppercase tracking-wider">{{ __('Pelanggan Puas') }}</div>
                    </div>
                </div>
            </div>
            <div class="mt-12 lg:mt-0">
                <div class="aspect-video rounded-3xl overflow-hidden bg-muted flex items-center justify-center relative shadow-2xl">
                    <img src="{{ asset('images/buildinglogin.png') }}" alt="Building" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-background/40 to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</div>
