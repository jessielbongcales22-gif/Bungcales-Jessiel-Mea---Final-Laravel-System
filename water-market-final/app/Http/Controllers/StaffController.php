<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Inventory;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        
        // Stats tailored for Staff
        $todayRevenue = Order::whereDate('created_at', Carbon::today())->where('payment_status', 'paid')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $outForDelivery = Order::where('status', 'out-for-delivery')->count();
        $walkInSalesCount = Order::where('address', 'like', 'Walk-in Sale%')->whereDate('created_at', Carbon::today())->count();

        // Recent Activity for Staff
        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        // Inventory Alerts for Staff
        $lowStockItems = Inventory::where('quantity', '<', 50)->get();
        $totalProductsCount = Inventory::count();

        return view('staff.dashboard', compact(
            'todayRevenue', 'pendingOrders', 'processingOrders', 'outForDelivery', 'walkInSalesCount',
            'recentOrders', 'lowStockItems', 'totalProductsCount'
        ));
    }
}
