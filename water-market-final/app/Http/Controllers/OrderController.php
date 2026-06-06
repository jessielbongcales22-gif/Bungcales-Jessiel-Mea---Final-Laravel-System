<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin' || $user->role === 'staff') {
            // Admin and Staff see all orders with customer info
            $orders = Order::with('user', 'items.inventory')->latest()->get();
        } else {
            // Customers only see their own orders
            $orders = Order::with('items.inventory')->where('user_id', $user->id)->latest()->get();
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $inventory = \App\Models\Inventory::where('quantity', '>', 0)->get();
        return view('orders.create', compact('inventory'));
    }

    /**
     * Store a newly created order in storage (Laravel 12).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string',
            'payment_method' => 'required|in:Cash,GCash',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:inventories,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                $total = 0;
                $itemsToCreate = [];

                foreach ($validated['items'] as $itemData) {
                    if ($itemData['quantity'] <= 0) continue;

                    $inventory = Inventory::lockForUpdate()->find($itemData['id']);
                    
                    if (!$inventory || $inventory->quantity < $itemData['quantity']) {
                        throw new \Exception("Sorry, {$inventory->name} is currently out of stock or insufficient.");
                    }

                    $inventory->decrement('quantity', $itemData['quantity']);
                    $subtotal = $inventory->price * $itemData['quantity'];
                    $total += $subtotal;

                    $itemsToCreate[] = [
                        'inventory_id' => $inventory->id,
                        'quantity' => $itemData['quantity'],
                        'price_at_purchase' => $inventory->price
                    ];
                }

                if (empty($itemsToCreate)) {
                    throw new \Exception("Please select at least one item.");
                }

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'status' => 'pending',
                    'address' => $validated['address'],
                    'total' => $total,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'pending'
                ]);

                foreach ($itemsToCreate as $item) {
                    $order->items()->create($item);
                }

                return redirect()->route('orders.index')->with('success', 'Refill order placed! We are processing it now.');
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Show form for walk-in sale.
     */
    public function walkInCreate()
    {
        $inventory = Inventory::where('quantity', '>', 0)->get();
        return view('admin.walkin.create', compact('inventory'));
    }

    /**
     * Store a direct walk-in sale.
     */
    public function walkInStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'payment_method' => 'required|in:Cash,GCash',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:inventories,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                $total = 0;
                $itemsToCreate = [];

                foreach ($validated['items'] as $itemData) {
                    $inventory = Inventory::lockForUpdate()->find($itemData['id']);
                    if (!$inventory || $inventory->quantity < $itemData['quantity']) {
                        throw new \Exception("Stock error for {$inventory->name}");
                    }

                    $inventory->decrement('quantity', $itemData['quantity']);
                    $total += $inventory->price * $itemData['quantity'];

                    $itemsToCreate[] = [
                        'inventory_id' => $inventory->id,
                        'quantity' => $itemData['quantity'],
                        'price_at_purchase' => $inventory->price
                    ];
                }

                $customerName = $validated['customer_name'] ?? 'Walk-in Customer';
                $paymentMethod = $validated['payment_method'];

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'customer_name' => $customerName,
                    'status' => 'delivered',
                    'address' => "Station Walk-in Sale",
                    'total' => $total,
                    'payment_method' => $paymentMethod,
                    'payment_status' => 'paid'
                ]);

                foreach ($itemsToCreate as $item) {
                    $order->items()->create($item);
                }

                return redirect()->route('admin.dashboard')->with('success', "Sale completed for {$customerName}!");
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update order status (Admin/Staff only).
     */
    public function updateStatus(Order $order, Request $request)
    {
        $order->update(['status' => $request->status]);
        
        // Auto-mark as paid if delivered (business policy)
        if ($request->status === 'delivered') {
            $order->update(['payment_status' => 'paid']);
        }

        return back()->with('success', "Order #{$order->id} status updated to " . ucfirst($request->status));
    }

    /**
     * Record payment (Admin/Staff only).
     */
    public function recordPayment(Order $order)
    {
        $order->update(['payment_status' => 'paid']);
        return back()->with('success', "Payment recorded for Order #{$order->id}");
    }

    /**
     * Show form for editing the order.
     */
    public function edit(Order $order)
    {
        if ($order->status !== 'pending' || $order->user_id !== Auth::id()) {
            return back()->with('error', 'Only pending orders can be edited.');
        }

        $inventory = Inventory::all();
        // pre-fill the quantities
        $currentItems = $order->items->pluck('quantity', 'inventory_id')->toArray();

        return view('orders.edit', compact('order', 'inventory', 'currentItems'));
    }

    /**
     * Update the order.
     */
    public function update(Request $request, Order $order)
    {
        if ($order->status !== 'pending' || $order->user_id !== Auth::id()) {
            return back()->with('error', 'Only pending orders can be updated.');
        }

        $validated = $request->validate([
            'address' => 'required|string',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:inventories,id',
            'items.*.quantity' => 'required|integer|min:0'
        ]);

        try {
            return DB::transaction(function () use ($validated, $order) {
                // 1. Restock current items back to inventory
                foreach ($order->items as $item) {
                    $inventory = Inventory::lockForUpdate()->find($item->inventory_id);
                    $inventory->increment('quantity', $item->quantity);
                }

                // 2. Remove old order items
                $order->items()->delete();

                // 3. Process new items
                $total = 0;
                $itemsToCreate = [];

                foreach ($validated['items'] as $itemData) {
                    if ($itemData['quantity'] <= 0) continue;

                    $inventory = Inventory::lockForUpdate()->find($itemData['id']);
                    
                    if (!$inventory || $inventory->quantity < $itemData['quantity']) {
                        throw new \Exception("Sorry, {$inventory->name} is now insufficient.");
                    }

                    $inventory->decrement('quantity', $itemData['quantity']);
                    $subtotal = $inventory->price * $itemData['quantity'];
                    $total += $subtotal;

                    $itemsToCreate[] = [
                        'inventory_id' => $inventory->id,
                        'quantity' => $itemData['quantity'],
                        'price_at_purchase' => $inventory->price
                    ];
                }

                if (empty($itemsToCreate)) {
                    throw new \Exception("Please select at least one item.");
                }

                // 4. Update main Order
                $order->update([
                    'address' => $validated['address'],
                    'total' => $total,
                ]);

                // 5. Create new items
                foreach ($itemsToCreate as $item) {
                    $order->items()->create($item);
                }

                return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Cancel the order.
     */
    public function cancel(Order $order)
    {
        if ($order->status !== 'pending' || $order->user_id !== Auth::id()) {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        try {
            DB::transaction(function () use ($order) {
                // Restock items
                foreach ($order->items as $item) {
                    $inventory = Inventory::lockForUpdate()->find($item->inventory_id);
                    $inventory->increment('quantity', $item->quantity);
                }
                
                $order->update(['status' => 'cancelled']);
            });

            return back()->with('success', 'Order cancelled and stock returned.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel order.');
        }
    }

    /**
     * Delete order.
     */
    public function destroy(Order $order)
    {
        // Admin can delete any, Customer can only delete their own cancelled/delivered orders
        if (Auth::user()->role === 'customer' && !in_array($order->status, ['delivered', 'cancelled'])) {
            return back()->with('error', 'Active orders cannot be deleted.');
        }

        if (Auth::user()->role === 'customer' && $order->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $order->delete();
        return back()->with('success', 'Order record removed.');
    }
}
