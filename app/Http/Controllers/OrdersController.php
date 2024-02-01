<?php

namespace App\Http\Controllers;

use App\Models\OrderHasProducts;
use App\Models\Orders;
use App\Models\OreHasProducts;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Orders::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div><a href="/order/' . $row->id . '" class="btn btn-primary btn-sm mr-2">
                <i class="fas fa-pencil-alt icon-md"></i> Details</a>
                </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('layouts.Order.index');
    }

    public function create()
    {
        $data = [
            "userList" => User::all(),
            "productList" => Products::all(),
            "orders" => null,
        ];
        return view('layouts.Order.form')->with($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'date' => 'required',
            'product_id' => 'required',
            'total' => 'required',
        ]);
        
        $order = Orders::create($validated);
        $orderProduct = [];
        foreach ($request->product as $product) {
            array_push($orderProduct, [
                'order_id' => $order->id,
                'product_id' => $product,
                'qnt' => $request->qnt[$product],
            ]);
        }
        OrderHasProducts::insert($orderProduct);

        return redirect(route('order.index'))->with('msg', 'New Order Created successful.');
    }

    public function show(Orders $order)
    {
        $data = [
            'order' => $order,
        ];
        return view('layouts.order.show')->with($data);
    }

    public function edit(Orders $orders)
    {
        return view('layouts.order.show')->with(
            ['products' => $orders]
        );
    }

    public function update(Request $request, Orders $orders)
    {
    }

    public function destroy(Orders $orders)
    {
    }
}
