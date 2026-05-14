<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $data = [
            'total_sales' => Sale::sum('net_amount'),
            'total_purchases' => Purchase::sum('total_amount'),
            'total_expenses' => Expense::sum('amount'),
        ];

        $data['net_profit'] = $data['total_sales'] - ($data['total_purchases'] + $data['total_expenses']);

        // Monthly Data for Charts (Last 6 Months)
        $months = [];
        $salesData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $monthName = $monthDate->format('M');
            $months[] = $monthName;

            $salesData[] = Sale::whereYear('sale_date', $monthDate->year)
                ->whereMonth('sale_date', $monthDate->month)
                ->sum('net_amount');

            $expenseSum = Expense::whereYear('expense_date', $monthDate->year)
                ->whereMonth('expense_date', $monthDate->month)
                ->sum('amount');
                
            $purchaseSum = Purchase::whereYear('purchase_date', $monthDate->year)
                ->whereMonth('purchase_date', $monthDate->month)
                ->sum('total_amount');

            $expenseData[] = $expenseSum + $purchaseSum;
        }

        $chartData = [
            'labels' => $months,
            'sales' => $salesData,
            'expenses' => $expenseData
        ];

        return view('reports.index', compact('data', 'chartData'));
    }

    public function downloadPdf()
    {
        $garage = auth()->user()->garage;
        $data = [
            'total_sales' => Sale::sum('net_amount'),
            'total_purchases' => Purchase::sum('total_amount'),
            'total_expenses' => Expense::sum('amount'),
        ];
        $data['net_profit'] = $data['total_sales'] - ($data['total_purchases'] + $data['total_expenses']);

        $months = [];
        $salesData = [];
        $expenseData = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $months[] = $monthDate->format('M');
            $salesData[] = Sale::whereYear('sale_date', $monthDate->year)->whereMonth('sale_date', $monthDate->month)->sum('net_amount');
            $expenseData[] = Expense::whereYear('expense_date', $monthDate->year)->whereMonth('expense_date', $monthDate->month)->sum('amount') + Purchase::whereYear('purchase_date', $monthDate->year)->whereMonth('purchase_date', $monthDate->month)->sum('total_amount');
        }

        $chartData = ['labels' => $months, 'sales' => $salesData, 'expenses' => $expenseData];
        
        $pdf = Pdf::loadView('reports.pdf', compact('data', 'chartData', 'garage'));
        return $pdf->stream('Business-Summary-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ReportExport, 'Detailed-Business-Report.xlsx');
    }
}
