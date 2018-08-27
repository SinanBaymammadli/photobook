<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->with('status')->orderBy('id', 'desc')->get();

        return view("admin.order.index", ["orders" => $orders]);
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $order_statuses = OrderStatus::all();

        return view("admin.order.edit", ["order" => $order, "order_statuses" => $order_statuses]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status_id = $request->status_id;

        $order->save();

        return redirect()->route('order.index');
    }
}
