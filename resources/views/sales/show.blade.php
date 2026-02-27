<x-app-layout :title="__('messages.sale_details')">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-foreground leading-tight">
                {{ __('messages.sale_details') }} #{{ $sale->invoice_number ?: $sale->id }}
            </h2>
            <div class="flex items-center gap-2">
                <x-secondary-button href="{{ route('sales.index') }}">
                    &larr; {{ __('messages.back_to_list') }}
                </x-secondary-button>
                <x-primary-button href="{{ route('sales.print', $sale) }}" target="_blank">
                    <x-heroicon-o-printer class="w-4 h-4 mr-2" />
                    {{ __('messages.print_invoice') }}
                </x-primary-button>
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
                            <h3 class="text-lg font-medium text-gray-900 dark:text-foreground">{{ __('messages.sale_information') }}</h3>
                            <p class="text-sm text-gray-500 dark:text-muted-foreground">{{ __('messages.sale_transaction_details') }}</p>
                        </div>
                        <div class="px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-muted text-slate-700 dark:text-muted-foreground text-xs font-medium border border-slate-200 dark:border-border">
                            ID: #{{ $sale->id }}
                        </div>
                    </div>

                    <!-- Content Grid -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Customer -->
                        <x-detail-item :label="__('messages.customer')" :value="$sale->customer->name ?? 'Guest'">
                            <x-heroicon-o-user class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Invoice -->
                        <x-detail-item :label="__('messages.invoice')" :value="$sale->invoice_number ?? '-'">
                            <x-heroicon-o-document-text class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Sale Date -->
                        <x-detail-item :label="__('messages.sale_date')" :value="$sale->sale_date->format('d M Y')">
                            <x-heroicon-o-calendar class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Payment Method -->
                        <x-detail-item :label="__('messages.payment_method')" :value="$sale->payment_method->label()">
                            <x-heroicon-o-credit-card class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>

                        <!-- Status -->
                        <div>
                            <label class="text-sm font-medium leading-none text-gray-500 dark:text-muted-foreground">{{ __('messages.status') }}</label>
                            <div class="mt-1">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $sale->status->color() }}">
                                    {{ $sale->status->label() }}
                                </span>
                            </div>
                        </div>



                        <!-- Created By -->
                        <x-detail-item :label="__('messages.created_by')" :value="$sale->creator->name ?? 'Unknown'">
                            <x-heroicon-o-user class="w-4 h-4 text-gray-400 dark:text-muted-foreground" />
                        </x-detail-item>
                    </div>

                    <!-- Notes -->
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-border">
                        <div class="space-y-1">
                            <label class="text-sm font-medium leading-none text-gray-500 dark:text-muted-foreground">
                                {{ __('messages.notes') }}
                            </label>
                            <div class="bg-gray-50 dark:bg-muted p-3 rounded-md border border-gray-100 dark:border-border">
                                <p class="text-sm text-slate-700 dark:text-foreground italic leading-relaxed">{{ $sale->notes ?: __('messages.no_notes') }}</p>
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
                                    <th class="px-6 py-3 text-right">{{ __('messages.price') }}</th>
                                    <th class="px-6 py-3 text-right">{{ __('messages.discount') }}</th>
                                    <th class="px-6 py-3 text-right">{{ __('messages.total') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-border">
                                @foreach($sale->items as $item)
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
                                        <td class="px-6 py-4 text-right text-red-500 dark:text-red-400">
                                            {{ $item->discount > 0 ? '- Rp ' . number_format($item->discount, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-right font-medium dark:text-foreground">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-muted font-bold">
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-right dark:text-muted-foreground">{{ __('messages.subtotal') }}</td>
                                    <td class="px-6 py-4 text-right text-gray-700 dark:text-foreground">
                                        Rp {{ number_format($sale->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @if($sale->total_discount > 0)
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-right text-red-600 dark:text-red-400">{{ __('messages.total_discount') }}</td>
                                        <td class="px-6 py-4 text-right text-red-600 dark:text-red-400">
                                            - Rp {{ number_format($sale->total_discount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-right dark:text-muted-foreground">{{ __('messages.total') }}</td>
                                    <td class="px-6 py-4 text-right text-indigo-600 dark:text-indigo-400 text-lg">
                                        Rp {{ number_format($sale->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-right text-gray-600 dark:text-muted-foreground">{{ __('messages.cash_received') }}</td>
                                    <td class="px-6 py-4 text-right text-gray-800 dark:text-foreground">
                                        Rp {{ number_format($sale->cash_received, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-right text-gray-600 dark:text-muted-foreground">{{ __('messages.change') }}</td>
                                    <td class="px-6 py-4 text-right text-green-600 dark:text-green-400">
                                        Rp {{ number_format($sale->change, 0, ',', '.') }}
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

                @if($sale->status === \App\Enums\SaleStatus::PENDING)
                    {{-- Complete / Pay Action --}}
                    <x-primary-button
                        class="!bg-green-600 hover:!bg-green-700 focus:!ring-green-500"
                        @click="confirmAction('{{ route('sales.complete', $sale) }}', 'PATCH', '{{ __('messages.complete_sale') }}', '{{ __('messages.mark_as_completed_q') }}', '{{ __('messages.complete_sale') }}', '!bg-green-600 hover:!bg-green-700 focus:!ring-green-500')"
                    >
                        {{ __('messages.complete_sale') }}
                    </x-primary-button>

                    {{-- Cancel Pending Action (Modal) --}}
                    <div x-data="{ cancelOpen: false }">
                        <x-danger-button @click="cancelOpen = true">
                            {{ __('messages.cancel_sale') }}
                        </x-danger-button>

                        <!-- Cancel Modal -->
                        <div x-show="cancelOpen"
                             style="display: none;"
                             x-transition.opacity
                             class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-75 flex items-center justify-center p-4">

                            <div @click.outside="cancelOpen = false"
                                 x-transition.scale
                                 class="relative bg-white dark:bg-card rounded-lg max-w-md w-full p-6 shadow-xl text-left border dark:border-border">

                                <h3 class="text-lg font-medium text-gray-900 dark:text-foreground mb-2">
                                    {{ __('messages.cancel_pending_sale') }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-muted-foreground mb-4">
                                    {{ __('messages.cancel_sale_confirmation') }}
                                </p>

                                <form action="{{ route('sales.destroy', $sale) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="mb-4">
                                        <x-input-label for="reason" :value="__('messages.reason')" />
                                        <textarea
                                            name="reason"
                                            id="reason"
                                            rows="3"
                                            class="block w-full mt-1 border-gray-300 dark:border-input bg-white dark:bg-background text-foreground rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="..."
                                            required
                                        ></textarea>
                                    </div>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <x-secondary-button type="button" @click="cancelOpen = false">
                                            {{ __('messages.back') }}
                                        </x-secondary-button>
                                        <x-danger-button type="submit">
                                            {{ __('messages.cancel_sale') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                @if($sale->status === \App\Enums\SaleStatus::COMPLETED)
                    {{-- Cancel Action --}}
                    <x-secondary-button
                        class="text-red-600 hover:bg-red-50 dark:hover:bg-red-950/20 border-red-200 dark:border-red-900/50"
                        @click="confirmAction('{{ route('sales.destroy', $sale) }}', 'DELETE', '{{ __('messages.cancel_sale') }}', '{{ __('messages.void_sale_confirmation') }}', '{{ __('messages.yes_cancel_sale') }}', '!bg-red-600 hover:!bg-red-700 focus:!ring-red-500')"
                    >
                        {{ __('messages.cancel_sale') }}
                    </x-secondary-button>
                @endif

                @if($sale->status === \App\Enums\SaleStatus::CANCELLED)
                    {{-- Restore Action --}}
                    <x-secondary-button
                        class="bg-gray-800 dark:bg-slate-700 text-white hover:bg-gray-700 dark:hover:bg-slate-600 focus:ring-gray-500"
                        @click="confirmAction('{{ route('sales.restore', $sale) }}', 'PATCH', '{{ __('messages.restore_sale') }}', '{{ __('messages.restore_sale_confirmation') }}', '{{ __('messages.restore_to_pending') }}', '!bg-gray-800 dark:!bg-slate-700 hover:!bg-gray-700 text-white')"
                    >
                        {{ __('messages.restore_to_pending') }}
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
