@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>{{ $product['title'] }}</h5>
        <p class="text-muted">{{ $product['category'] }}</p>
        <p>{{ $product['description'] }}</p>
        <p><strong>Harga:</strong> ${{ number_format($product['price'], 2) }}</p>
        @if (!empty($product['thumbnail']))
            <img src="{{ $product['thumbnail'] }}" alt="{{ $product['title'] }}" width="200">
        @endif
    </div>
</div>
<a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">&laquo; Kembali</a>
@endsection