<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(auth()->user()->is_super_admin)
            <!-- SUPER ADMIN VIEW: Platform Control Center -->
            <div class="flex flex-col gap-6">
                <div class="bg-primary/5 p-6 rounded-xl border border-primary/10 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-primary">{{ __('messages.platform_control') }}</h2>
                        <p class="text-sm text-muted-foreground">{{ __('messages.platform_control_subtitle') ?? 'Monitoring kesehatan sistem dan statistik global SaaS Anda.' }}</p>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="clearCache" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors border border-input bg-background hover:bg-accent h-9 px-4">
                            <x-heroicon-o-trash class="w-4 h-4 mr-2" />
                            {{ __('messages.clear_cache') }}
                        </button>
                    </div>
                </div>

                <!-- Global Stats -->
                <div class="grid gap-4 md:grid-cols-4">
                    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <p class="text-sm font-medium text-muted-foreground uppercase">{{ __('messages.tenants') }}</p>
                            <x-heroicon-o-building-office-2 class="h-4 w-4 text-primary" />
                        </div>
                        <div class="text-2xl font-bold">{{ $total_companies }}</div>
                    </div>
                    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <p class="text-sm font-medium text-muted-foreground uppercase">{{ __('messages.users') }}</p>
                            <x-heroicon-o-users class="h-4 w-4 text-primary" />
                        </div>
                        <div class="text-2xl font-bold">{{ $total_users }}</div>
                    </div>
                    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <p class="text-sm font-medium text-muted-foreground uppercase">{{ __('messages.total_gmv') ?? 'GMV' }}</p>
                            <x-heroicon-o-banknotes class="h-4 w-4 text-emerald-500" />
                        </div>
                        <div class="text-2xl font-bold text-emerald-600">Rp {{ number_format($total_revenue, 0, ',', '.') }}</div>
                    </div>
                    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
                        <div class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <p class="text-sm font-medium text-muted-foreground uppercase">{{ __('messages.system_health') }}</p>
                            <x-heroicon-o-check-badge class="h-4 w-4 text-emerald-500" />
                        </div>
                        <div class="text-2xl font-bold text-emerald-600">Healthy</div>
                    </div>
                </div>

                <!-- System Info Card -->
                <div class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">
                    <div class="p-4 bg-muted/30 border-b border-border">
                        <h3 class="font-bold">{{ __('messages.system_info') ?? 'Informasi Sistem' }}</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <div class="flex justify-between border-b border-border pb-2">
                                    <span class="text-muted-foreground">Framework</span>
                                    <span class="font-medium">Laravel {{ app()->version() }}</span>
                                </div>
                                <div class="flex justify-between border-b border-border pb-2">
                                    <span class="text-muted-foreground">PHP Version</span>
                                    <span class="font-medium">{{ phpversion() }}</span>
                                </div>
                                <div class="flex justify-between border-b border-border pb-2">
                                    <span class="text-muted-foreground">Database</span>
                                    <span class="font-medium">{{ config('database.default') }}</span>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <p class="text-sm font-semibold text-muted-foreground">{{ __('messages.security_tips') ?? 'Saran Keamanan' }}:</p>
                                <ul class="text-xs space-y-2 text-muted-foreground list-disc pl-4">
                                    <li>{{ __('messages.tip_backup') ?? 'Pastikan backup database dilakukan setiap 24 jam.' }}</li>
                                    <li>{{ __('messages.tip_suspend') ?? 'Selalu nonaktifkan akun tenant yang sudah melewati masa berlaku.' }}</li>
                                    <li>{{ __('messages.tip_password') ?? 'Jangan pernah membagikan password Super Admin kepada siapapun.' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- TENANT ADMIN VIEW: Company Settings -->
            <div class="flex flex-col gap-6">
                <!-- Header Section -->
                <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
                    <h2 class="text-2xl font-bold text-foreground">{{ __('messages.manage_settings') }}</h2>
                    <p class="text-sm text-muted-foreground">{{ __('messages.settings_subtitle') ?? 'Kelola identitas bisnis dan hak akses tim Anda di satu tempat.' }}</p>
                </div>

                <!-- Tabs Navigation -->
                <div class="flex border-b border-border space-x-8">
                    <button wire:click="$set('activeTab', 'profile')" class="py-4 px-1 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'profile' ? 'border-primary text-primary' : 'border-transparent text-muted-foreground hover:text-foreground' }}">
                        {{ __('messages.business_profile') }}
                    </button>
                    <button wire:click="$set('activeTab', 'roles')" class="py-4 px-1 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'roles' ? 'border-primary text-primary' : 'border-transparent text-muted-foreground hover:text-foreground' }}">
                        {{ __('messages.roles_permissions') }}
                    </button>
                    <button wire:click="$set('activeTab', 'logs')" class="py-4 px-1 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'logs' ? 'border-primary text-primary' : 'border-transparent text-muted-foreground hover:text-foreground' }}">
                        {{ __('messages.activity_logs') ?? 'Log Aktivitas' }}
                    </button>
                </div>

                <!-- Tab Content: Profile -->
                @if($activeTab === 'profile')
                <div class="bg-card rounded-xl border border-border shadow-sm p-6">
                    <form wire:submit.prevent="updateProfile" class="space-y-6 max-w-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-input-label for="name" :value="__('messages.company_name') ?? 'Nama Perusahaan'" />
                                <x-text-input wire:model="name" id="name" type="text" class="w-full" />
                                <x-input-error :messages="$errors->get('name')" />
                            </div>
                            <div class="space-y-2">
                                <x-input-label for="phone" :value="__('messages.phone') ?? 'Nomor Telepon'" />
                                <x-text-input wire:model="phone" id="phone" type="text" class="w-full" placeholder="0812..." />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="address" :value="__('messages.address') ?? 'Alamat Lengkap'" />
                            <textarea wire:model="address" id="address" rows="3" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"></textarea>
                        </div>

                        <div class="pt-4">
                            <x-primary-button type="submit">{{ __('messages.save_changes') }}</x-primary-button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Tab Content: Roles -->
                @if($activeTab === 'roles')
                <div class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">{{ __('messages.roles_permissions') }}</h3>
                        <x-primary-button wire:click="openRoleModal()">
                            <x-heroicon-o-plus class="w-4 h-4 mr-2" />
                            {{ __('messages.add_role') }}
                        </x-primary-button>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        @foreach($roles as $role)
                        <div class="bg-card rounded-xl border border-border shadow-sm p-5 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-lg">{{ $role->name }}</h4>
                                    @if($role->is_immutable)
                                    <span class="bg-primary/10 text-primary text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">{{ __('messages.system') ?? 'System' }}</span>
                                    @endif
                                </div>
                                <p class="text-xs text-muted-foreground mb-4">
                                    @php
                                        $perms = (array)($role->permissions ?? []);
                                        $count = 0;
                                        foreach(array_keys($availablePermissions) as $p) {
                                            if ($role->hasPermission($p)) $count++;
                                        }
                                    @endphp
                                    {{ $count }} {{ __('messages.active_permissions_count') ?? 'Izin Akses aktif' }}
                                </p>
                            </div>
                            <div class="flex gap-2 border-t border-border pt-4 mt-2">
                                <button wire:click="openRoleModal({{ $role->id }})" class="text-sm text-primary hover:underline font-medium">{{ __('messages.edit_permissions') }}</button>
                                @if(!$role->is_immutable)
                                <span class="text-border">|</span>
                                <button wire:click="deleteRole({{ $role->id }})" class="text-sm text-destructive hover:underline font-medium">{{ __('messages.delete') }}</button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tab Content: Logs -->
                @if($activeTab === 'logs')
                <div class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">
                    <div class="relative w-full overflow-auto">
                        <table class="w-full caption-bottom text-sm">
                            <thead class="bg-muted/30 border-b border-border">
                                <tr>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">{{ __('messages.date') }}</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">{{ __('messages.user') ?? 'User' }}</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">{{ __('messages.action') }}</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">{{ __('messages.description') ?? 'Keterangan' }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border">
                                @forelse($logs as $log)
                                <tr class="hover:bg-muted/50 transition-colors">
                                    <td class="p-4 align-middle whitespace-nowrap text-muted-foreground text-xs">
                                        {{ $log->created_at->diffForHumans() }}
                                        <div class="text-[10px]">{{ $log->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <div class="font-medium text-foreground">{{ $log->user->name ?? 'System' }}</div>
                                        <div class="text-[10px] text-muted-foreground uppercase tracking-wider">{{ $log->user->roleRel->name ?? $log->user->role }}</div>
                                    </td>
                                    <td class="p-4 align-middle">
                                        @php
                                            $actionColors = [
                                                'create' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
                                                'update' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                'delete' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                            ];
                                            $color = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $color }} uppercase">
                                            {{ $log->action }}
                                        </span>
                                    </td>
                                    <td class="p-4 align-middle text-muted-foreground">
                                        {{ $log->description }}
                                        <div class="text-[10px] mt-1 italic">via {{ $log->ip_address }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-muted-foreground italic">
                                        Belum ada aktivitas yang tercatat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($logs && $logs instanceof \Illuminate\Pagination\LengthAwarePaginator && $logs->hasPages())
                    <div class="p-4 border-t border-border bg-muted/20">
                        {{ $logs->links() }}
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Role Discord-style Modal -->
            @if($isRoleModalOpen)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-background/80 backdrop-blur-sm p-4">
                <div class="bg-card w-full max-w-2xl rounded-xl border border-border shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                    <div class="p-6 border-b border-border flex justify-between items-center bg-muted/30">
                        <div>
                            <h3 class="text-xl font-bold">{{ __('messages.edit_permissions') }}: {{ $role_name ?: 'Baru' }}</h3>
                            <p class="text-sm text-muted-foreground">{{ __('messages.permissions_list') }}</p>
                        </div>
                        <button wire:click="$set('isRoleModalOpen', false)" class="text-muted-foreground hover:text-foreground">
                            <x-heroicon-o-x-mark class="w-6 h-6" />
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto space-y-6">
                        <div class="space-y-2">
                            <x-input-label for="role_name" :value="__('messages.role_name')" />
                            <x-text-input wire:model="role_name" id="role_name" type="text" class="w-full" :placeholder="__('messages.example_role_name') ?? 'Misal: Supervisor Gudang'" />
                            <x-input-error :messages="$errors->get('role_name')" />
                        </div>

                        <div class="space-y-4">
                            <p class="text-sm font-bold uppercase text-muted-foreground tracking-widest">{{ __('messages.permissions_list') }}</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($availablePermissions as $key => $label)
                                <label wire:key="perm-item-{{ $key }}" for="perm_{{ $key }}" class="flex items-center p-3 rounded-lg border border-border bg-muted/20 cursor-pointer hover:bg-muted/40 transition-colors">
                                    <input type="checkbox" id="perm_{{ $key }}" wire:model.live="selected_permissions" value="{{ $key }}" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary h-5 w-5">
                                    <span class="ml-3 text-sm font-medium text-foreground">{{ __('messages.' . $key) ?? $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-border flex justify-end gap-3 bg-muted/10">
                        <x-secondary-button wire:click="$set('isRoleModalOpen', false)">{{ __('messages.cancel') }}</x-secondary-button>
                        <x-primary-button wire:click="saveRole">{{ __('messages.save_role') ?? __('messages.save') }}</x-primary-button>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
