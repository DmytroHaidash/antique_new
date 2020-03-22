<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class OrdersController extends Controller
{
    public function index(): View
    {
        return \view('admin.orders.index', [
            'orders' => Order::ordered()->with(['product', 'user'])->paginate(20),
        ]);
    }

    public function edit(Order $order)
    {
        return \view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->only('status', 'message', 'comment'));
        return \back();
    }
}
