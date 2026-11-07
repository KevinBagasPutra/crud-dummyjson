@extends('layouts.app')

@section('content')
<h5>Edit Produk #{{ $product['id'] }}</h5>
<form action="{{ route('products.update', $product['id']) }}" method="POST">
    @method('PUT')
    @include('products._form')
</form>
@endsection