@extends('layouts.app')

@section('content')
<h5>Tambah Produk</h5>
<form action="{{ route('products.store') }}" method="POST">
    @include('products._form')
</form>
@endsection