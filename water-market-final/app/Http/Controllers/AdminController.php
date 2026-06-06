<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Inventory;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();

        // Stats
        $todayRevenue = Order::whereDate('created_at', Carbon::today())->where('payment_status', 'paid')->sum('total');
        $monthlyRevenue = Order::whereMonth('created_at', $now->month)->where('payment_status', 'paid')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalUsers = User::count();
        $walkInSalesCount = Order::where('address', 'like', 'Walk-in Sale%')->count();

        // Comparison Data
        $walkInRevenue = Order::where('address', 'like', 'Walk-in Sale%')->where('payment_status', 'paid')->sum('total');
        $deliveryRevenue = Order::where('address', 'not like', 'Walk-in Sale%')->where('payment_status', 'paid')->sum('total');
        $totalRevenueAllTime = Order::where('payment_status', 'paid')->sum('total');

        // Payment Method Breakdown
        $cashRevenue = Order::where('payment_method', 'Cash')->where('payment_status', 'paid')->sum('total');
        $gcashRevenue = Order::where('payment_method', 'GCash')->where('payment_status', 'paid')->sum('total');

        $walkInPercent = $totalRevenueAllTime > 0 ? round(($walkInRevenue / $totalRevenueAllTime) * 100) : 0;
        $deliveryPercent = $totalRevenueAllTime > 0 ? round(($deliveryRevenue / $totalRevenueAllTime) * 100) : 0;

        // Recent Orders
        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        // Top Products
        $topProducts = OrderItem::with('inventory')
            ->select('inventory_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price_at_purchase) as revenue'))
            ->groupBy('inventory_id')
            ->orderByDesc('revenue')
            ->limit(3)
            ->get();

        // All Time Stats for Footer Bar
        $allTimeOrders = Order::count();
        $totalProductsCount = Inventory::count();

        return view('admin.dashboard', compact(
            'todayRevenue', 'monthlyRevenue', 'pendingOrders', 'totalUsers', 'walkInSalesCount',
            'walkInRevenue', 'deliveryRevenue', 'walkInPercent', 'deliveryPercent',
            'recentOrders', 'topProducts', 'totalRevenueAllTime', 'allTimeOrders', 'totalProductsCount',
            'cashRevenue', 'gcashRevenue'
        ));
    }
}
