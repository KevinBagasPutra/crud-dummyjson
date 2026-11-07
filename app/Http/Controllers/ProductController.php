<?php

namespace App\Http\Controllers;

use App\Services\DummyJsonService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected DummyJsonService $api) {}

    public function index(Request $request)
    {
        $limit = 10;
        $page  = max((int) $request->query('page', 1), 1);
        $data  = $this->api->all($limit, ($page - 1) * $limit);

        return view('products.index', [
            'products' => $data['products'],
            'page'     => $page,
            'lastPage' => (int) ceil($data['total'] / $limit),
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $result = $this->api->create($validated);

        return redirect()->route('products.index')
            ->with('success', "Produk \"{$result['title']}\" berhasil dibuat (ID: {$result['id']}).");
    }

    public function show(int $id)
    {
        return view('products.show', ['product' => $this->api->find($id)]);
    }

    public function edit(int $id)
    {
        return view('products.edit', ['product' => $this->api->find($id)]);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate($this->rules());
        $this->api->update($id, $validated);

        return redirect()->route('products.show', $id)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->api->delete($id);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    protected function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category'    => 'nullable|string|max:100',
        ];
    }
}