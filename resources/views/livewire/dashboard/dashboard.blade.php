<div class="space-y-6">
    <!-- Filter Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-card p-4 rounded-lg border border-border shadow-sm">
        <div>
            <h2 class="text-lg font-semibold text-foreground">{{ __('messages.overview') }}</h2>
            <p class="text-sm text-muted-foreground">{{ __('messages.overview_subtitle') }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <!-- Period Selector -->
            <select wire:model.live="dateFilter" class="h-9 w-[180px] rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                @foreach(\App\Enums\DatePeriod::cases() as $period)
                    <option value="{{ $period->value }}">{{ $period->label() }}</option>
                @endforeach
            </select>

            <!-- Custom Date Range -->
            <!-- Custom Date Range (Flatpickr) -->
            <div x-show="$wire.dateFilter === 'custom'" x-transition class="flex items-center gap-2"
                 x-data="{
                     init() {
                         flatpickr(this.$refs.picker, {
                             mode: 'range',
                             dateFormat: 'Y-m-d',
                             defaultDate: [this.$wire.customStartDate, this.$wire.customEndDate],
                             onChange: (selectedDates, dateStr, instance) => {
                                 if (selectedDates.length === 2) {
                                     this.$wire.updateCustomRange(
                                         instance.formatDate(selectedDates[0], 'Y-m-d'),
                                         instance.formatDate(selectedDates[1], 'Y-m-d')
                                     );
                                 }
                             }
                         });
                     }
                 }"
            >
                <input x-ref="picker" type="text" class="h-9 w-[240px] rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring" placeholder="{{ __('messages.select_date_range') }}">
            </div>

             <!-- Refresh Button -->
             <button wire:click="$refresh" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 w-9">
                <x-heroicon-o-arrow-path wire:loading.class="animate-spin" class="h-4 w-4" />
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <!-- Total Sales -->
        <div class="rounded-xl border border-input bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">Total {{ t_label('sale') }}</h3>
                <x-heroicon-o-banknotes class="h-4 w-4 text-muted-foreground" />
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">
                    {{ 'Rp ' . number_format($stats['total_sales'] ?? 0, 0, ',', '.') }}
                </div>
                <p class="text-xs text-muted-foreground">
                    {{ $stats['sales_count'] ?? 0 }} {{ __('messages.transactions') }}
                </p>
            </div>
        </div>

        <!-- Gross Profit -->
        <div class="rounded-xl border border-input bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">{{ __('messages.gross_profit') }}</h3>
                <x-heroicon-o-arrow-trending-up class="h-4 w-4 text-muted-foreground" />
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">
                    {{ 'Rp ' . number_format($stats['gross_profit'] ?? 0, 0, ',', '.') }}
                </div>
                <p class="text-xs text-muted-foreground">
                    {{ __('messages.estimated_cogs') }}
                </p>
            </div>
        </div>

        <!-- Net Cash Flow -->
        <div class="rounded-xl border border-input bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">{{ __('messages.net_cash_flow') }}</h3>
                 <x-heroicon-o-currency-dollar class="h-4 w-4 text-muted-foreground" />
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold {{ ($stats['net_cash_flow'] ?? 0) >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ 'Rp ' . number_format($stats['net_cash_flow'] ?? 0, 0, ',', '.') }}
                </div>
                <div class="flex justify-between text-xs text-muted-foreground mt-1">
                    <span class="text-emerald-600 flex items-center gap-1">
                        <x-heroicon-s-arrow-up class="w-3 h-3" /> {{ number_format($stats['income'] ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="text-red-600 flex items-center gap-1">
                        <x-heroicon-s-arrow-down class="w-3 h-3" /> {{ number_format($stats['expense'] ?? 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

         <!-- Low Stock Alert -->
         <div class="rounded-xl border border-input bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-row items-center justify-between space-y-0 pb-2">
                <h3 class="tracking-tight text-sm font-medium">{{ __('messages.low_stock_alert') }}</h3>
                <x-heroicon-o-exclamation-triangle class="h-4 w-4 text-orange-500" />
            </div>
            <div class="p-6 pt-0">
                <div class="text-2xl font-bold">
                    {{ count($lowStockProducts) }}
                </div>
                <p class="text-xs text-muted-foreground">
                    {{ __('messages.below_min_stock') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid gap-4 grid-cols-1 lg:grid-cols-3">
        <!-- Sales Trend -->
        <div class="lg:col-span-2 rounded-xl border border-input bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-col space-y-1.5 pb-2">
                <h3 class="font-semibold leading-none tracking-tight">Tren {{ t_label('sale') }}</h3>
                <p class="text-sm text-muted-foreground">{{ __('messages.sales_trend_subtitle') }}</p>
            </div>
            <div class="p-6 pt-0" wire:ignore>
                <div id="salesChart" class="w-full h-[300px]"></div>
            </div>
        </div>

        <!-- Cash Flow -->
        <div class="rounded-xl border border-input bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-col space-y-1.5 pb-2">
                <h3 class="font-semibold leading-none tracking-tight">{{ __('messages.income_vs_expense') }}</h3>
                <p class="text-sm text-muted-foreground">{{ __('messages.financial_overview') }}</p>
            </div>
            <div class="p-6 pt-0" wire:ignore>
                <div id="cashFlowChart" class="w-full h-[300px]"></div>
            </div>
        </div>
    </div>

    <div class="grid gap-4 grid-cols-1 lg:grid-cols-7">
        <!-- Recent Sales -->
        <div class="lg:col-span-4 rounded-xl border border-input bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-col space-y-1.5">
                <h3 class="font-semibold leading-none tracking-tight">{{ __('messages.recent_sales') }}</h3>
                <p class="text-sm text-muted-foreground">{{ __('messages.latest_transactions') }}</p>
            </div>
            <div class="p-6 pt-0">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">{{ __('messages.invoice') }}</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">{{ t_label('customer') }}</th>
                                <th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">{{ __('messages.amount') }}</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            @forelse($recentSales as $sale)
                                <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                    <td class="p-4 align-middle font-medium">{{ $sale['invoice_number'] }}</td>
                                    <td class="p-4 align-middle">{{ $sale['customer']['name'] ?? 'Guest' }}</td>
                                    <td class="p-4 align-middle text-right">{{ 'Rp ' . number_format($sale['total'], 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-muted-foreground">{{ __('messages.no_recent_sales') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="lg:col-span-3 rounded-xl border border-input bg-card text-card-foreground shadow-sm">
            <div class="p-6 flex flex-col space-y-1.5">
                <h3 class="font-semibold leading-none tracking-tight">{{ t_label('product') }} Terlaris</h3>
                <p class="text-sm text-muted-foreground">{{ __('messages.best_selling_items') }}</p>
            </div>
             <div class="p-6 pt-0">
                <div class="space-y-4">
                    @forelse($topProducts as $product)
                        <div class="flex items-center">
                            <div class="ml-4 space-y-1 flex-1">
                                <p class="text-sm font-medium leading-none">{{ $product['product_name'] }}</p>
                                <p class="text-xs text-muted-foreground">{{ $product['sku'] }}</p>
                            </div>
                            <div class="font-medium">
                                {{ $product['total_sold'] }} {{ __('messages.sold') }}
                            </div>
                        </div>
                    @empty
                         <p class="text-sm text-muted-foreground text-center">{{ __('messages.no_sales_data') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        let salesChart = null;
        let cashFlowChart = null;

        const initCharts = (data) => {
            // Sales Chart
            const salesOptions = {
                series: [{
                    name: "{{ __('messages.sales') }}",
                    data: data.sales.data
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: { show: false },
                    fontFamily: 'inherit'
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2 },
                xaxis: {
                    categories: data.sales.labels,
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        formatter: (val) => {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(val);
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#0ea5e9'], // Sky 500
                tooltip: {
                    y: {
                        formatter: function (val) {
                             return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(val);
                        }
                    }
                }
            };

            // Cash Flow Chart
            const cashFlowOptions = {
                series: [{
                    name: "{{ __('messages.income') }} (In)",
                    data: data.cashFlow.income
                }, {
                    name: "{{ __('messages.expense') }} (Out)",
                    data: data.cashFlow.expense
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: { show: false },
                    fontFamily: 'inherit'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                xaxis: {
                    categories: data.cashFlow.labels,
                },
                yaxis: {
                    labels: {
                         formatter: (val) => {
                             // Shorten detailed numbers for y-axis
                             if (val >= 1000000) return (val / 1000000).toFixed(1) + 'M';
                             if (val >= 1000) return (val / 1000).toFixed(0) + 'k';
                             return val;
                        }
                    }
                },
                colors: ['#10b981', '#ef4444'], // Emerald 500, Red 500
                fill: { opacity: 1 },
                tooltip: {
                    y: {
                        formatter: function (val) {
                             return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(val);
                        }
                    }
                }
            };

            if (salesChart) salesChart.destroy();
            if (cashFlowChart) cashFlowChart.destroy();

            salesChart = new ApexCharts(document.querySelector("#salesChart"), salesOptions);
            salesChart.render();

            cashFlowChart = new ApexCharts(document.querySelector("#cashFlowChart"), cashFlowOptions);
            cashFlowChart.render();
        };

        // Initial Load
        initCharts({
            sales: @json($salesChart),
            cashFlow: @json($cashFlowChart)
        });



        // Listen for server-side updates
        Livewire.on('stats-updated', (data) => {
             initCharts(data[0]); // data is array of args
        });
    });
</script>
