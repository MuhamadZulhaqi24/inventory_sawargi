<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.invoice') }} #{{ $sale->invoice_number }}</title>
    <style>
        @media print {
            @page {
                size: A5 landscape;
                margin: 0;
            }
            body {
                margin: 0;
                padding: 10mm;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        body {
            font-family: 'Courier New', Courier, monospace; /* Classic receipt font */
            font-size: 10pt;
            line-height: 1.2;
            color: #000;
            margin: 0;
            padding: 10mm;
            background: #fff;
        }

        .receipt-wrapper {
            border: 1px solid #333;
            padding: 15px;
            min-height: 120mm;
            display: flex;
            flex-direction: column;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px double #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .shop-details {
            width: 60%;
        }

        .shop-name {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .shop-info {
            font-size: 9pt;
            line-height: 1.4;
        }

        .invoice-meta {
            width: 35%;
            text-align: right;
        }

        .invoice-title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        /* CUSTOMER SECTION */
        .customer-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 9pt;
        }

        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 150px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9pt;
        }

        td {
            padding: 6px 5px;
            font-size: 9pt;
            vertical-align: top;
        }

        .border-bottom {
            border-bottom: 1px solid #eee;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* TOTALS */
        .totals-section {
            margin-left: auto;
            width: 40%;
            border-top: 2px solid #000;
            padding-top: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .total-label { font-weight: bold; }
        .grand-total {
            font-size: 12pt;
            border-top: 1px solid #000;
            margin-top: 5px;
            padding-top: 5px;
        }

        /* FOOTER */
        .footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
        }

        .signature-box {
            text-align: center;
            width: 150px;
        }

        .signature-space {
            height: 50px;
        }

        .disclaimer {
            width: 50%;
            text-align: center;
            font-style: italic;
            font-size: 8pt;
            border: 1px dashed #ccc;
            padding: 10px;
            align-self: center;
        }
    </style>
</head>
<body>
    @php
        $company = $sale->company;
        $settings = $company->settings ?? [];
        $companyName = $company->name ?? config('app.name');
    @endphp

    <div class="receipt-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="shop-details">
                <div class="shop-name">{{ $companyName }}</div>
                <div class="shop-info">
                    {{ $settings['address'] ?? '' }}<br>
                    @if(!empty($settings['phone'])) Telp/WA: {{ $settings['phone'] }} @endif
                </div>
            </div>
            <div class="invoice-meta">
                <div class="invoice-title">{{ t_label('sale') }}</div>
                <div>No: <strong>{{ $sale->invoice_number }}</strong></div>
                <div>{{ $sale->sale_date->locale(app()->getLocale())->isoFormat('DD/MM/YYYY') }}</div>
            </div>
        </div>

        <!-- Customer -->
        <div class="customer-section">
            <div>
                {{ __('messages.to_yth') }} <span class="dotted-line">{{ $sale->customer->name ?? __('messages.guest') }}</span>
            </div>
            <div>
                {{ __('messages.created_by') }}: {{ $sale->creator->name ?? '-' }}
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 50%">{{ t_label('product') }}</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">{{ __('messages.price') }}</th>
                    <th class="text-right">{{ __('messages.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $item)
                <tr class="border-bottom">
                    <td>
                        {{ $item->product->name }}
                        @if($item->discount > 0)
                            <div style="font-size: 8pt; color: #666">Disc: -{{ number_format($item->discount, 0, ',', '.') }}</div>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary & Totals -->
        <div class="totals-section">
            <div class="total-row">
                <span>Subtotal</span>
                <span>{{ number_format($sale->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($sale->total_discount > 0)
            <div class="total-row">
                <span>{{ __('messages.total_discount') }}</span>
                <span>-{{ number_format($sale->total_discount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="total-row grand-total">
                <span class="total-label">TOTAL</span>
                <span class="total-label">Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
            </div>
            <div class="total-row" style="font-weight: normal; font-size: 9pt; margin-top: 5px;">
                <span>{{ __('messages.cash_received') }}</span>
                <span>{{ number_format($sale->cash_received, 0, ',', '.') }}</span>
            </div>
            <div class="total-row" style="font-weight: normal; font-size: 9pt;">
                <span>{{ __('messages.change') }}</span>
                <span>{{ number_format($sale->change, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="signature-box">
                <div>{{ __('messages.received_by') }}</div>
                <div class="signature-space"></div>
                <div>( ............ )</div>
            </div>

            <div class="disclaimer">
                {{ __('messages.invoice_disclaimer') }}
            </div>

            <div class="signature-box">
                <div>Hormat Kami,</div>
                <div class="signature-space"></div>
                <div> {{ $companyName }} </div>
            </div>
        </div>
    </div>
</body>
</html>
