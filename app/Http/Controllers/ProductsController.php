<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Products::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div><a href="/product/' . $row->id . '" class="btn btn-primary btn-sm mr-2">
                    <i class="fas fa-pencil-alt icon-md"></i> Details</a>
                    <a href="/remove-product/' . $row->id . '" class="btn btn-danger btn-sm mr-2" onclick="return confirm("Are you sure?")">
                    <i class="fas fa-pencil-alt icon-md"></i> Remove</a> </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('layouts.Product.index');
    }

    public function create()
    {
        $data = [
            "products" => null,
        ];
        return view('layouts.Product.form')->with($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            // 'image' => 'required',
            'price' => 'required',
        ]);
        Products::create($validated);
        return redirect(route('product.index'))->with('msg', 'New Product Created successful.');
    }

    public function show(Products $product)
    {
        return view('layouts.Product.form')->with(['products' => $product]);
    }

    public function edit(Products $product)
    {
        return view('layouts.Product.form')->with(['products' => $product]);
    }

    public function update(Request $request, Products $product)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            // 'image' => 'required',
            'price' => 'required',
        ]);

        $product->update($validated);

        return redirect(route('product.index'))->with('msg', 'Product Updated successful.');
    }

    public function destroy(Products $product)
    {
        $product->delete();
        return redirect(route('product.index'))->with('msg', 'Product Deleted successful!');
    }
}
