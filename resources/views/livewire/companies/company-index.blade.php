<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-card p-4 rounded-lg border border-border shadow-sm">
                <div>
                    <h2 class="text-lg font-semibold text-foreground">Manajemen Tenant</h2>
                    <p class="text-sm text-muted-foreground">Kelola semua perusahaan yang terdaftar di platform Anda.</p>
                </div>
                <button x-data x-on:click="$dispatch('open-modal', { name: 'company-form' })" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-4 py-2">
                    <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                    Tambah Tenant
                </button>
            </div>

            <!-- Stats Overview (Optional but Nice for Consistency) -->
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-xl border bg-card text-card-foreground shadow-sm p-6">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <h3 class="tracking-tight text-sm font-medium">Total Tenant</h3>
                        <x-heroicon-o-building-office-2 class="h-4 w-4 text-muted-foreground" />
                    </div>
                    <div class="text-2xl font-bold">{{ \App\Models\Company::count() }}</div>
                </div>
                <div class="rounded-xl border bg-card text-card-foreground shadow-sm p-6">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <h3 class="tracking-tight text-sm font-medium">Tenant Aktif</h3>
                        <x-heroicon-o-check-circle class="h-4 w-4 text-emerald-500" />
                    </div>
                    <div class="text-2xl font-bold text-emerald-600">{{ \App\Models\Company::where('status', 'active')->count() }}</div>
                </div>
                <div class="rounded-xl border bg-card text-card-foreground shadow-sm p-6">
                    <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <h3 class="tracking-tight text-sm font-medium">Menunggu Perpanjangan</h3>
                        <x-heroicon-o-clock class="h-4 w-4 text-orange-500" />
                    </div>
                    <div class="text-2xl font-bold text-orange-600">{{ \App\Models\Company::where('expired_at', '<', now()->addDays(7))->count() }}</div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="rounded-xl border bg-card text-card-foreground shadow-sm overflow-hidden">
                <div class="p-4 border-b border-border bg-muted/50">
                    <div class="relative w-full md:w-1/3">
                        <x-heroicon-o-magnifying-glass class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                        <input wire:model.live="search" type="text" placeholder="Cari perusahaan..." class="flex h-9 w-full rounded-md border border-input bg-background px-9 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                </div>
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b bg-muted/30">
                            <tr class="border-b transition-colors hover:bg-muted/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Perusahaan</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Tipe Bisnis</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Expired At</th>
                                <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($companies as $company)
                            <tr class="border-b transition-colors hover:bg-muted/50">
                                <td class="p-4 align-middle">
                                    <div class="font-medium text-foreground">{{ $company->name }}</div>
                                    <div class="text-xs text-muted-foreground">{{ $company->slug }}</div>
                                </td>
                                <td class="p-4 align-middle">
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 uppercase">
                                        {{ $company->business_type }}
                                    </span>
                                </td>
                                <td class="p-4 align-middle">
                                    <button wire:click="toggleStatus({{ $company->id }})" class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold transition-all {{ $company->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $company->status === 'active' ? 'bg-emerald-600' : 'bg-red-600' }}"></span>
                                        {{ strtoupper($company->status) }}
                                    </button>
                                </td>
                                <td class="p-4 align-middle">
                                    @php
                                        $isExpired = $company->expired_at && $company->expired_at->isPast();
                                        $isNear = $company->expired_at && !$isExpired && $company->expired_at->diffInDays(now()) <= 7;
                                    @endphp
                                    <div class="flex flex-col">
                                        <span class="text-sm {{ $isExpired ? 'text-red-600 font-bold' : ($isNear ? 'text-orange-500 font-semibold' : 'text-muted-foreground') }}">
                                            {{ $company->expired_at ? $company->expired_at->format('d M Y') : '-' }}
                                        </span>
                                        @if($company->expired_at)
                                            <span class="text-[10px] uppercase">
                                                @if($isExpired)
                                                    (Expired {{ $company->expired_at->diffForHumans() }})
                                                @else
                                                    ({{ (int) now()->diffInDays($company->expired_at) }} hari lagi)
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="extendSubscription({{ $company->id }}, 30)" class="inline-flex items-center justify-center rounded-md text-xs font-bold transition-colors bg-blue-100 text-blue-700 hover:bg-blue-200 h-8 px-3" title="Tambah 30 Hari">
                                            <x-heroicon-o-calendar-days class="w-4 h-4 mr-1" />
                                            Extend
                                        </button>
                                        <button class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-muted h-8 w-8">
                                            <x-heroicon-o-pencil-square class="h-4 w-4 text-muted-foreground" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-muted-foreground">Belum ada tenant yang terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($companies->hasPages())
                <div class="p-4 border-t border-border bg-muted/20">
                    {{ $companies->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
    <livewire:companies.company-form />
</div>
