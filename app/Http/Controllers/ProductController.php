<?php

namespace App\Http\Controllers;

use App\Services\DummyJsonService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(DummyJsonService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $search = $request->query('q');

        $products = filled($search)
            ? $this->service->searchProducts($search)
            : $this->service->getProducts();

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'category' => 'nullable',
        ]);

        $this->service->createProduct($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan (simulasi DummyJSON).');
    }

    public function show($id)
    {
        $product = $this->service->getProduct($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = $this->service->getProduct($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'category' => 'nullable',
        ]);

        $this->service->updateProduct($id, $data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate (simulasi DummyJSON).');
    }

    public function destroy($id)
    {
        $this->service->deleteProduct($id);
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus (simulasi DummyJSON).');
    }
}