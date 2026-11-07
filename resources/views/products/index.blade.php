@extends('layouts.app')

@section('content')
<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">+ Tambah Produk</a>

<table class="table table-bordered table-striped bg-white">
    <thead>
        <tr>
            <th>ID</th><th>Judul</th><th>Kategori</th><th>Harga</th><th width="220">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($products as $p)
        <tr>
            <td>{{ $p['id'] }}</td>
            <td>{{ $p['title'] }}</td>
            <td>{{ $p['category'] }}</td>
            <td>${{ number_format($p['price'], 2) }}</td>
            <td>
                <a href="{{ route('products.show', $p['id']) }}" class="btn btn-sm btn-info">Detail</a>
                <a href="{{ route('products.edit', $p['id']) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('products.destroy', $p['id']) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus produk ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-between">
    @if ($page > 1)
        <a href="{{ route('products.index', ['page' => $page - 1]) }}" class="btn btn-outline-secondary">&laquo; Sebelumnya</a>
    @else <span></span> @endif

    <span>Halaman {{ $page }} dari {{ $lastPage }}</span>

    @if ($page < $lastPage)
        <a href="{{ route('products.index', ['page' => $page + 1]) }}" class="btn btn-outline-secondary">Berikutnya &raquo;</a>
    @else <span></span> @endif
</div>
@endsection