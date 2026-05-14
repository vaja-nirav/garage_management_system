<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $jobCard->job_card_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
        }
        .garage-info h1 {
            margin: 0;
            color: #4f46e5;
            font-size: 24px;
        }
        .garage-info p {
            margin: 5px 0;
            font-size: 12px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h2 {
            margin: 0;
            font-size: 20px;
            color: #666;
        }
        .invoice-title p {
            margin: 5px 0;
            font-size: 14px;
            font-weight: bold;
        }
        .details-grid {
            width: 100%;
            margin-bottom: 30px;
        }
        .details-grid td {
            vertical-align: top;
            width: 50%;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .info-box {
            font-size: 13px;
        }
        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items-table th {
            background-color: #f3f4f6;
            text-align: left;
            padding: 10px;
            font-size: 13px;
            border-bottom: 1px solid #e5e7eb;
        }
        table.items-table td {
            padding: 10px;
            font-size: 13px;
            border-bottom: 1px solid #e5e7eb;
        }
        .total-section {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }
        .total-box {
            width: 250px;
            float: right;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-size: 14px;
        }
        .total-row.grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #4f46e5;
            border-top: 2px solid #e5e7eb;
            margin-top: 10px;
            padding-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="garage-info">
            <h1>{{ $jobCard->garage->garage_name }}</h1>
            <p>{{ $jobCard->garage->address ?? 'Main Street, City' }}</p>
            <p>Phone: {{ $jobCard->garage->phone }} | Email: {{ $jobCard->garage->email }}</p>
        </div>
        <div class="invoice-title" style="float: right; position: absolute; right: 20px; top: 20px;">
            <h2>INVOICE</h2>
            <p>#{{ $jobCard->job_card_number }}</p>
            <p style="font-size: 12px; color: #666;">Date: {{ $jobCard->updated_at->format('d M, Y') }}</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <table class="details-grid">
        <tr>
            <td>
                <div class="section-title">Customer Details</div>
                <div class="info-box">
                    <strong>{{ $jobCard->customer->first_name }} {{ $jobCard->customer->last_name }}</strong><br>
                    Phone: {{ $jobCard->customer->phone }}<br>
                    Email: {{ $jobCard->customer->email }}<br>
                    {{ $jobCard->customer->address }}
                </div>
            </td>
            <td style="text-align: right;">
                <div class="section-title">Vehicle Details</div>
                <div class="info-box">
                    <strong>{{ $jobCard->vehicle->make }} {{ $jobCard->vehicle->model }}</strong><br>
                    Reg No: {{ $jobCard->vehicle->registration_number }}<br>
                    Vehicle Code: {{ $jobCard->vehicle->vehicle_code }}<br>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Parts & Services Used</div>
    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Unit Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $subTotal = 0; @endphp
            @foreach($jobCard->sales as $sale)
                @foreach($sale->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">&#8377;{{ number_format($item->unit_price, 2) }}</td>
                        <td style="text-align: right;">&#8377;{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @php $subTotal += $item->total; @endphp
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <div style="width: 100%;">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: left; padding: 5px 0;">Subtotal:</td>
                    <td style="text-align: right; padding: 5px 0;">&#8377;{{ number_format($subTotal, 2) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; padding: 5px 0;">Tax:</td>
                    <td style="text-align: right; padding: 5px 0;">&#8377;0.00</td>
                </tr>
                <tr class="grand-total">
                    <td style="text-align: left; padding: 10px 0; font-size: 18px; border-top: 1px solid #eee;">Grand Total:</td>
                    <td style="text-align: right; padding: 10px 0; font-size: 18px; border-top: 1px solid #eee; color: #4f46e5;">&#8377;{{ number_format($subTotal, 2) }}</td>
                </tr>
            </table>
        </div>
        <div style="margin-top: 20px; text-align: right;">
            <span class="badge badge-paid">Payment Status: PAID</span>
        </div>
    </div>
    <div style="clear: both;"></div>

    <div class="info-box" style="margin-top: 40px;">
        <div class="section-title">Work Description</div>
        <p style="font-style: italic;">{{ $jobCard->work_done ?? 'N/A' }}</p>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer-generated invoice and does not require a physical signature.</p>
    </div>
</body>
</html>
