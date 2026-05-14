<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use Illuminate\Http\Request;

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

        return view('reports.index', compact('data'));
    }
}
