<x-app-layout :title="__('messages.purchase_details')">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('messages.purchase_details') }} #{{ $purchase->invoice_number ?: $purchase->id }}
            </h2>
            <div class="flex items-center gap-2">
                <x-secondary-button href="{{ route('purchases.index') }}">
                    &larr; {{ __('messages.back_to_list') }}
                </x-secondary-button>
                @if(in_array($purchase->status, [\App\Enums\PurchaseStatus::DRAFT, \App\Enums\PurchaseStatus::ORDERED]))
                    <x-secondary-button href="{{ route('purchases.edit', $purchase) }}">
                        {{ __('messages.edit_purchase') }}
                    </x-secondary-button>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Main Info Card -->
            <div class="bg-white dark:bg-card shadow-sm sm:rounded-lg overflow-hidden border border-gray-200 dark:border-border">
                <div class="p-6">
                    <!-- Header Info -->
                    <div class="flex items-start justify-between border-b border-gray-100 dark:border-border pb-4 mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-foreground">{{ __('messages.purchase_information') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-muted-foreground">{{ __('messages.purchase_transaction_details') }}</p>
                        </div>
                        <div class="px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-muted text-slate-700 dark:text-muted-foreground text-xs font-medium border border-slate-200 dark:border-border">
                            ID: #{{ $purchase->id }}
                        </div>
                    </div>

                    <!-- Content Grid -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Supplier -->
                        <x-detail-item :label="__('messages.supplier')" :value="$purchase->supplier->name">
                            <x-heroicon-o-building-storefront class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Invoice -->
                        <x-detail-item :label="__('messages.invoice')" :value="$purchase->invoice_number ?? '-'">
                            <x-heroicon-o-document-text class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Purchase Date -->
                        <x-detail-item :label="__('messages.purchase_date')" :value="$purchase->purchase_date->format('d M Y')">
                            <x-heroicon-o-calendar class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Due Date -->
                        <x-detail-item :label="__('messages.due_date')" :value="$purchase->due_date ? $purchase->due_date->format('d M Y') : '-'">
                            <x-heroicon-o-calendar class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Status -->
                        <div>
                            <label class="text-sm font-medium leading-none text-gray-500 dark:text-muted-foreground">{{ __('messages.status') }}</label>
                            <div class="mt-1">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $purchase->status->color() }}">
                                    {{ $purchase->status->label() }}
                                </span>
                            </div>
                        </div>

                        <!-- Total Amount -->
                        <x-detail-item :label="__('messages.amount')" :value="'Rp ' . number_format($purchase->total, 0, ',', '.')">
                            <x-heroicon-o-banknotes class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Created By -->
                        <x-detail-item :label="__('messages.created_by')" :value="$purchase->creator->name ?? 'Unknown'">
                            <x-heroicon-o-user class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Proof Image -->
                        @if($purchase->proof_image)
                            <div>
                                <label class="text-sm font-medium leading-none text-gray-500 dark:text-muted-foreground">{{ __('messages.proof_of_receipt') }}</label>
                                <div class="mt-1">
                                    <a href="{{ Storage::url($purchase->proof_image) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm flex items-center gap-1">
                                        <x-heroicon-o-paper-clip class="w-4 h-4" />
                                        {{ __('messages.view_details') }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <x-detail-item :label="__('messages.proof_of_receipt')" value="-" />
                        @endif
                    </div>

                    <!-- Notes -->
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-border">
                        <div class="space-y-1">
                            <label class="text-sm font-medium leading-none text-gray-500 dark:text-muted-foreground">
                                {{ __('messages.notes') }}
                            </label>
                            <div class="bg-gray-50 dark:bg-muted p-3 rounded-md border border-gray-100 dark:border-border">
                                <p class="text-sm text-slate-700 dark:text-foreground italic leading-relaxed">{{ $purchase->notes ?: __('messages.no_notes') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table Section -->
                    <div class="mt-6 border-t dark:border-border overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 dark:text-muted-foreground uppercase bg-gray-50 dark:bg-muted">
                                <tr>
                                    <th class="px-6 py-3">{{ __('messages.code') }}</th>
                                    <th class="px-6 py-3">{{ __('messages.product') }}</th>
                                    <th class="px-6 py-3">{{ __('messages.unit') }}</th>
                                    <th class="px-6 py-3 text-center">{{ __('messages.qty') }}</th>
                                    <th class="px-6 py-3 text-right">{{ __('messages.buy_price') }}</th>
                                    <th class="px-6 py-3 text-right">{{ __('messages.sell_price') }}</th>
                                    <th class="px-6 py-3 text-right">{{ __('messages.total') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-border">
                                @foreach($purchase->items as $item)
                                    <tr class="bg-white dark:bg-card hover:bg-gray-50 dark:hover:bg-accent transition-colors">
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-muted-foreground">
                                            {{ $item->product->product_code ?? $item->product->sku ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-foreground">
                                            {{ $item->product->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-muted-foreground">
                                            {{ $item->product->unit->symbol ?? $item->product->unit->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center dark:text-foreground">
                                            {{ number_format($item->quantity) }}
                                        </td>
                                        <td class="px-6 py-4 text-right dark:text-foreground">
                                            Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right dark:text-foreground">
                                            Rp {{ number_format($item->selling_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right font-medium dark:text-foreground">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-muted font-bold">
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-right dark:text-muted-foreground">{{ __('messages.total') }}</td>
                                    <td class="px-6 py-4 text-right text-indigo-600 dark:text-indigo-400 text-lg">
                                        Rp {{ number_format($purchase->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Workflow -->
            <div x-data="{
                actionUrl: '',
                actionMethod: '',
                modalTitle: '',
                modalMessage: '',
                confirmButtonText: '',
                confirmButtonClass: '',

                confirmAction(url, method, title, message, btnText, btnClass) {
                    this.actionUrl = url;
                    this.actionMethod = method;
                    this.modalTitle = title;
                    this.modalMessage = message;
                    this.confirmButtonText = btnText;
                    this.confirmButtonClass = btnClass;
                    $dispatch('open-modal', { name: 'confirmation-modal' });
                }
            }" class="flex flex-col sm:flex-row justify-end gap-4">

                @if($purchase->status === \App\Enums\PurchaseStatus::DRAFT)

                    {{-- Delete Action --}}
                    <x-danger-button
                        @click="confirmAction('{{ route('purchases.destroy', $purchase) }}', 'DELETE', '{{ __('messages.delete_draft') }}', '{{ __('messages.delete_draft_confirmation') }}', '{{ __('messages.delete_draft') }}', '!bg-red-600 hover:!bg-red-700 focus:!ring-red-500')"
                    >
                        {{ __('messages.delete_draft') }}
                    </x-danger-button>

                    {{-- Order Action --}}
                    <x-primary-button
                        class="!bg-sky-600 hover:!bg-sky-700 focus:!ring-sky-500"
                        @click="confirmAction('{{ route('purchases.mark-ordered', $purchase) }}', 'PATCH', '{{ __('messages.mark_as_ordered') }}', '{{ __('messages.mark_as_ordered_confirmation') }}', '{{ __('messages.mark_as_ordered') }}', '!bg-sky-600 hover:!bg-sky-700 focus:!ring-sky-500')"
                    >
                        {{ __('messages.mark_as_ordered') }}
                    </x-primary-button>

                @elseif($purchase->status === \App\Enums\PurchaseStatus::ORDERED)

                    {{-- Cancel Action --}}
                    <x-secondary-button
                        class="text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 border-red-200 dark:border-red-900/50"
                        @click="confirmAction('{{ route('purchases.cancel', $purchase) }}', 'PATCH', '{{ __('messages.cancel_order') }}', '{{ __('messages.cancel_order_confirmation') }}', '{{ __('messages.cancel_order') }}', '!bg-red-600 hover:!bg-red-700 focus:!ring-red-500')"
                    >
                        {{ __('messages.cancel_order') }}
                    </x-secondary-button>

                    {{-- Receive Action Trigger (Modal) --}}
                    <div x-data="{ open: @if($errors->has('invoice_number') || $errors->has('proof_image')) true @else false @endif }">
                        <x-primary-button @click="open = true" class="!bg-green-600 hover:!bg-green-700 focus:!ring-green-500">
                            <x-heroicon-o-check-circle class="w-5 h-5 mr-1" />
                            {{ __('messages.receive_items') }}
                        </x-primary-button>

                        <!-- Modal Backdrop -->
                        <div x-show="open"
                             style="display: none;"
                             x-transition.opacity
                             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-75 flex items-center justify-center p-4">

                            <!-- Modal Content -->
                            <div @click.outside="open = false"
                                 x-transition.scale
                                 class="relative bg-white dark:bg-card rounded-lg max-w-md w-full p-6 shadow-xl border dark:border-border">

                                <h3 class="text-lg font-medium text-gray-900 dark:text-foreground mb-4">
                                    {{ __('messages.receive_purchase') }} #{{ $purchase->invoice_number ?? $purchase->id }}
                                </h3>

                                <form action="{{ route('purchases.mark-received', $purchase) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')

                                    <div class="space-y-4">
                                        <!-- Invoice Section -->
                                        @if($purchase->invoice_number)
                                            <div class="bg-gray-50 dark:bg-muted p-3 rounded-md border border-gray-200 dark:border-border">
                                                <span class="block text-xs font-medium text-gray-500 dark:text-muted-foreground uppercase">{{ __('messages.invoice') }}</span>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-foreground">{{ $purchase->invoice_number }}</span>
                                            </div>
                                        @else
                                            <div class="space-y-2">
                                                <x-input-label for="invoice_number" :value="__('messages.final_invoice_number')" required />
                                                <x-text-input
                                                    id="invoice_number"
                                                    name="invoice_number"
                                                    :value="old('invoice_number')"
                                                    required
                                                    placeholder="INV...."
                                                />
                                                <x-input-error :messages="$errors->get('invoice_number')" class="mt-2" />
                                            </div>
                                        @endif

                                        <!-- Proof Section -->
                                        @if($purchase->proof_image)
                                            <div class="bg-gray-50 dark:bg-muted p-3 rounded-md border border-gray-200 dark:border-border">
                                                <span class="block text-xs font-medium text-gray-500 dark:text-muted-foreground uppercase mb-1">{{ __('messages.proof_of_receipt') }}</span>
                                                <a href="{{ Storage::url($purchase->proof_image) }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm flex items-center gap-1">
                                                    <x-heroicon-o-paper-clip class="w-4 h-4" />
                                                    {{ __('messages.view_uploaded_image') }}
                                                </a>
                                            </div>
                                        @else
                                            <div class="space-y-2">
                                                <x-input-label for="proof_image" :value="__('messages.upload_proof')" required />
                                                <input
                                                    id="proof_image"
                                                    type="file"
                                                    name="proof_image"
                                                    accept="image/*"
                                                    required
                                                    class="block w-full text-sm text-gray-500 dark:text-muted-foreground
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded-md file:border-0
                                                        file:text-sm file:font-semibold
                                                        file:bg-indigo-50 dark:file:bg-indigo-950/30 file:text-indigo-700 dark:file:text-indigo-400
                                                        hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50"
                                                />
                                                <p class="text-xs text-gray-500 dark:text-muted-foreground">Image (JPG, PNG) max 2MB.</p>
                                                <x-input-error :messages="$errors->get('proof_image')" class="mt-2" />
                                            </div>
                                        @endif

                                        @if($purchase->invoice_number && $purchase->proof_image)
                                            <p class="text-xs text-green-600 dark:text-green-400 mt-3 font-medium flex items-center">
                                                <x-heroicon-o-check-circle class="w-4 h-4 mr-1" />
                                                {{ __('messages.data_complete_ready') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <x-secondary-button type="button" @click="open = false">
                                            {{ __('messages.back') }}
                                        </x-secondary-button>
                                        <x-primary-button class="!bg-green-600 hover:!bg-green-700 focus:!ring-green-500">
                                            {{ __('messages.confirm_receipt') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @elseif($purchase->status === \App\Enums\PurchaseStatus::RECEIVED)

                    {{-- Pay Action --}}
                    <x-primary-button
                        class="!bg-emerald-600 hover:!bg-emerald-700 focus:!ring-emerald-500"
                        @click="confirmAction('{{ route('purchases.mark-paid', $purchase) }}', 'PATCH', '{{ __('messages.mark_as_paid') }}', '{{ __('messages.mark_as_paid_confirmation') }}', '{{ __('messages.mark_as_paid') }}', '!bg-emerald-600 hover:!bg-emerald-700 focus:!ring-emerald-500')"
                    >
                        <x-heroicon-o-currency-dollar class="w-5 h-5 mr-1" />
                        {{ __('messages.mark_as_paid') }}
                    </x-primary-button>

                @elseif($purchase->status === \App\Enums\PurchaseStatus::CANCELLED)

                    {{-- Restore Action --}}
                    <x-secondary-button
                        @click="confirmAction('{{ route('purchases.restore-draft', $purchase) }}', 'PATCH', '{{ __('messages.restore_to_draft') }}', '{{ __('messages.restore_to_draft_confirmation') }}', '{{ __('messages.restore_to_draft') }}', '!bg-gray-800 dark:!bg-slate-700 hover:!bg-gray-700 text-white')"
                    >
                        {{ __('messages.restore_to_draft') }}
                    </x-secondary-button>

                @endif

                <!-- Shared Confirmation Modal -->
                <x-modal name="confirmation-modal">
                    <div class="p-6" x-data="{ submitting: false }">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-foreground" x-text="modalTitle"></h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-muted-foreground" x-text="modalMessage"></p>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close-modal', { name: 'confirmation-modal' })" x-bind:disabled="submitting">
                                {{ __('messages.back') }}
                            </x-secondary-button>

                            <form :action="actionUrl" method="POST" class="ml-3" @submit="submitting = true">
                                @csrf
                                <input type="hidden" name="_method" :value="actionMethod">

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 text-white shadow-sm bg-primary"
                                    x-bind:class="confirmButtonClass + (submitting ? ' opacity-75 cursor-not-allowed' : '')"
                                    x-bind:disabled="submitting"
                                >
                                    <svg x-show="submitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span x-text="confirmButtonText"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </x-modal>

            </div>
        </div>
    </div>
</x-app-layout>
