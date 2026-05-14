<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Business Summary Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #4f46e5;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }
        .summary-grid {
            width: 100%;
            margin-bottom: 40px;
            border-collapse: collapse;
        }
        .summary-card {
            background-color: #f9fafb;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            text-align: center;
        }
        .summary-card h3 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            color: #6b7280;
        }
        .summary-card p {
            margin: 10px 0 0 0;
            font-size: 24px;
            font-weight: bold;
            color: #111827;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 20px;
            border-left: 4px solid #4f46e5;
            padding-left: 10px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data-table th {
            background-color: #f3f4f6;
            text-align: left;
            padding: 12px;
            font-size: 13px;
            border-bottom: 2px solid #e5e7eb;
        }
        table.data-table td {
            padding: 12px;
            font-size: 13px;
            border-bottom: 1px solid #eee;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .text-emerald { color: #10b981; }
        .text-rose { color: #f43f5e; }
        .text-blue { color: #3b82f6; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $garage->garage_name ?? 'Business Performance Report' }}</h1>
        <p>Business Performance Summary</p>
        <p>Generated on: {{ now()->format('d M, Y h:i A') }}</p>
    </div>

    <table style="width: 100%; margin-bottom: 40px;">
        <tr>
            <td style="width: 25%; padding: 5px;">
                <div class="summary-card">
                    <h3>Total Sales</h3>
                    <p class="text-emerald" style="font-size:15px;">&#8377;{{ number_format($data['total_sales'], 2) }}</p>
                </div>
            </td>
            <td style="width: 25%; padding: 5px;">
                <div class="summary-card">
                    <h3>Purchases</h3>
                    <p class="text-blue" style="font-size:15px;">&#8377;{{ number_format($data['total_purchases'], 2) }}</p>
                </div>
            </td>
            <td style="width: 25%; padding: 5px;">
                <div class="summary-card">
                    <h3>Expenses</h3>
                    <p class="text-rose" style="font-size:15px;">&#8377;{{ number_format($data['total_expenses'], 2) }}</p>
                </div>
            </td>
            <td style="width: 25%; padding: 5px;">
                <div class="summary-card">
                    <h3>Net Profit</h3>
                    <p style="font-size:15px;">&#8377;{{ number_format($data['net_profit'], 2) }}</p>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Monthly Revenue Trend (Last 6 Months)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Month</th>
                <th style="text-align: right;">Sales</th>
                <th style="text-align: right;">Expenses & Purchases</th>
                <th style="text-align: right;">Profit/Loss</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chartData['labels'] as $index => $label)
            @php 
                $profit = $chartData['sales'][$index] - $chartData['expenses'][$index];
            @endphp
            <tr>
                <td>{{ $label }}</td>
                <td style="text-align: right;">&#8377;{{ number_format($chartData['sales'][$index], 2) }}</td>
                <td style="text-align: right;">&#8377;{{ number_format($chartData['expenses'][$index], 2) }}</td>
                <td style="text-align: right; font-weight: bold;" class="{{ $profit >= 0 ? 'text-emerald' : 'text-rose' }}">
                    &#8377;{{ number_format($profit, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This is a system-generated financial summary report.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</body>
</html>
