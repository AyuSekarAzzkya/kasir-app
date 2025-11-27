<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::all();
        return view('admin.product.index', compact('products'));
    }

    public function data()
    {
        $products = Products::with('category')->select('products.*');

        return DataTables::eloquent($products)
            ->addColumn('barcode_html', function ($row) {
                $dns = new DNS1D();
                $dns->setStorPath(public_path('cache/'));
                return $dns->getBarcodeHTML($row->barcode, 'C128', 1.5, 40);
            })
            ->addColumn('action', function ($row) {
                return '
                <div class="d-flex gap-2">
                    <a href="' . route('admin.products.edit', $row->id) . '" 
                        class="btn btn-sm btn-info">Edit</a>

                    <form action="' . route('admin.products.destroy', $row->id) . '" 
                        method="POST">
                        ' . csrf_field() . method_field("DELETE") . '
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </div>
            ';
            })
            ->rawColumns(['barcode_html', 'action'])
            ->make(true);
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Products::where('name', 'LIKE', '%' . $query . '%')->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'categories_id' => 'required|integer',
            'price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $lastProduct = Products::orderBy('id', 'desc')->first();
        $nextNumber = $lastProduct ? $lastProduct->id + 1 : 1;

        $barcode = 'PRD-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        Products::create([
            'name' => $request->name,
            'categories_id' => $request->categories_id,
            'price' => $request->price,
            'purchase_price' => $request->purchase_price,
            'stock' => $request->stock,
            'barcode' => $barcode,
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Categories::all();

        return view('admin.product.edit', compact('product', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'categories_id' => 'required|integer',
            'price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);
        $product = Products::findOrFail($id);
        $product->update($request->only('name', 'categories_id', 'price', 'purchase_price', 'stock'));
        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function getByCode($code)
    {
        $product = Products::where('barcode', $code)->first();

        return response()->json($product);
    }
}
