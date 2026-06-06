<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the sales reports.
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 'week');
        $now = Carbon::now();

        // Calculate start date based on period
        $startDate = match($period) {
            'month' => $now->copy()->startOfMonth(),
            'year' => $now->copy()->startOfYear(),
            default => $now->copy()->startOfWeek(),
        };

        // Header Stats
        $totalRevenue = Order::where('created_at', '>=', $startDate)
            ->where('payment_status', 'paid')
            ->sum('total');

        $totalOrders = Order::where('created_at', '>=', $startDate)->count();
        
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Transaction History (Latest 10)
        $transactions = Order::with('user')->latest()->limit(10)->get();

        // Top Products by Revenue
        $topProducts = OrderItem::with('inventory')
            ->select('inventory_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price_at_purchase) as revenue'))
            ->groupBy('inventory_id')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        // Payment Method Breakdown
        $cashRevenue = Order::where('created_at', '>=', $startDate)->where('payment_method', 'Cash')->where('payment_status', 'paid')->sum('total');
        $gcashRevenue = Order::where('created_at', '>=', $startDate)->where('payment_method', 'GCash')->where('payment_status', 'paid')->sum('total');

        return view('admin.reports.index', compact(
            'period', 
            'totalRevenue', 
            'totalOrders', 
            'avgOrderValue', 
            'transactions',
            'topProducts',
            'cashRevenue',
            'gcashRevenue'
        ));
    }
}
