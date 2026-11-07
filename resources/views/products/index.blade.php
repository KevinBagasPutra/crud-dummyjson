@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>

    <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
        <select name="category" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">-- Semua Kategori --</option>
            @foreach ($categories ?? [] as $cat)
                @php
                    $catSlug = is_array($cat) ? ($cat['slug'] ?? '') : $cat;
                    $catName = is_array($cat) ? ($cat['name'] ?? $catSlug) : ucfirst($cat);
                @endphp
                <option value="{{ $catSlug }}" {{ ($category ?? request('category')) === $catSlug ? 'selected' : '' }}>
                    {{ $catName }}
                </option>
            @endforeach
        </select>

        <input type="text" name="q" class="form-control w-auto" placeholder="Cari produk..."
               value="{{ request('q', $search ?? '') }}">

        <button type="submit" class="btn btn-secondary">Cari</button>

        @if (request()->filled('q') || filled($category ?? request('category')))
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Reset</a>
        @endif
    </form>
</div>

<table class="table table-bordered bg-white">
    <thead>
    <tr>
        <th>ID</th>
        <th>Judul</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($products as $p)
        <tr>
            <td>{{ $p['id'] }}</td>
            <td>{{ $p['title'] }}</td>
            <td>
                <a href="{{ route('products.index', ['category' => $p['category']]) }}" class="badge bg-secondary text-decoration-none">
                    {{ $p['category'] }}
                </a>
            </td>
            <td>${{ number_format($p['price'], 2) }}</td>
            <td>
                <a href="{{ route('products.show', $p['id']) }}" class="btn btn-info btn-sm text-white">Lihat</a>
                <a href="{{ route('products.edit', $p['id']) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('products.destroy', $p['id']) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin hapus?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted">Produk tidak ditemukan.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection