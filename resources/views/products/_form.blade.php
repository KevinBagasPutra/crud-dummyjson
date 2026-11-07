@csrf

<div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $product['title'] ?? '') }}">
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" rows="3" class="form-control">{{ old('description', $product['description'] ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Kategori</label>
    <input type="text" name="category" class="form-control"
           value="{{ old('category', $product['category'] ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Harga (USD)</label>
    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror"
           value="{{ old('price', $product['price'] ?? '') }}">
    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<button class="btn btn-success">Simpan</button>
<a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>