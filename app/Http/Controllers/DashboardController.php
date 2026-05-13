<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ServiceJobCard;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => Customer::count(),
            'active_job_cards' => ServiceJobCard::where('status', '!=', 'delivered')->count(),
            'total_revenue' => Sale::sum('net_amount'),
            'low_stock_products' => Product::whereRaw('track_stock = 1 AND min_stock_alert >= 0')->count(), // Simplified
        ];

        return view('dashboard', compact('stats'));
    }
}
