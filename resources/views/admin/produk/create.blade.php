@extends('layout.admin')

@section('content')

<div class="form-container">

    <h1>Tambah Produk</h1>

    <form action="/admin/produk/store" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" required>
        </div>

        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" required>
        </div>

        <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="gambar" onchange="previewImage(event)">
            <img id="preview" class="preview-img" style="display:none;">
        </div>

        <div class="form-actions">
            <a href="/admin/produk" class="btn-kembali">Kembali</a>
            <button type="submit" class="btn-simpan">Simpan</button>
        </div>

    </form>

</div>

<script>
function previewImage(event) {
    const img = document.getElementById('preview');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.style.display = 'block';
}
</script>

@endsection