<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Support\Carbon;
use Lava;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders_by_month = Order::all()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->toDateString();
        });

        $ordersTable = Lava::DataTable();

        $ordersTable->addDateColumn('Year')
            ->addNumberColumn('Number of orders')
            ->addRow(['2018-08-26', 0]);

        foreach ($orders_by_month as $month => $orders) {
            $ordersTable->addRow([$month, $orders->count()]);
        }

        Lava::AreaChart('Orders', $ordersTable, [
            'title' => 'Orders',
            'legend' => [
                'position' => 'in',
            ],
        ]);

        return view('admin.home');
    }
}
