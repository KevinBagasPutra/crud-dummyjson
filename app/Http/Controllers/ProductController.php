<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\DummyJsonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected DummyJsonService $service;

    public function __construct(DummyJsonService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request, ?string $slug = null)
    {
        $search = $request->query('q');
        $category = $slug ?? $request->query('category');

        if (filled($search)) {
            $products = $this->service->searchProducts($search);
            if (filled($category)) {
                $products = array_values(array_filter(
                    $products,
                    fn ($p) => ($p['category'] ?? '') === $category
                ));
            }
        } elseif (filled($category)) {
            $products = $this->service->getProductsByCategory($category);
        } else {
            $products = $this->service->getProducts();
        }

        if ($request->is('api/*') || $request->wantsJson()) {
            return ProductResource::collection(collect($products))->additional([
                'status' => 'success',
                'meta'   => [
                    'total'    => count($products),
                    'search'   => $search,
                    'category' => $category,
                ],
            ]);
        }

        $categories = $this->service->getCategories();

        return view('products.index', compact('products', 'categories', 'search', 'category'));
    }

    public function categories(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => $this->service->getCategories(),
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'nullable|string|max:100',
        ]);

        $product = $this->service->createProduct($data);

        if ($request->is('api/*') || $request->wantsJson()) {
            return (new ProductResource($product))
                ->additional([
                    'status'  => 'success',
                    'message' => 'Produk berhasil ditambahkan (simulasi DummyJSON).',
                ])
                ->response()
                ->setStatusCode(201);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan (simulasi DummyJSON).');
    }

    public function show(Request $request, $id)
    {
        $product = $this->service->getProduct($id);

        if ($request->is('api/*') || $request->wantsJson()) {
            if (empty($product) || isset($product['message'])) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $product['message'] ?? 'Produk tidak ditemukan.',
                ], 404);
            }

            return (new ProductResource($product))->additional([
                'status' => 'success',
            ]);
        }

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
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required|numeric|min:0',
            'category'    => 'nullable|string|max:100',
        ]);

        $product = $this->service->updateProduct($id, $data);

        if ($request->is('api/*') || $request->wantsJson()) {
            if (empty($product) || isset($product['message'])) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $product['message'] ?? 'Produk tidak ditemukan.',
                ], 404);
            }

            return (new ProductResource($product))->additional([
                'status'  => 'success',
                'message' => 'Produk berhasil diupdate (simulasi DummyJSON).',
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate (simulasi DummyJSON).');
    }

    public function destroy(Request $request, $id)
    {
        $product = $this->service->deleteProduct($id);

        if ($request->is('api/*') || $request->wantsJson()) {
            if (empty($product) || isset($product['message'])) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $product['message'] ?? 'Produk tidak ditemukan.',
                ], 404);
            }

            return (new ProductResource($product))->additional([
                'status'  => 'success',
                'message' => 'Produk berhasil dihapus (simulasi DummyJSON).',
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus (simulasi DummyJSON).');
    }
}