@extends('layout.admin')

@section('content')

<h1>Kelola Produk</h1>

<a href="/admin/produk/tambah" class="btn-tambah">+ Tambah Produk</a>

<div class="produk-grid">

@foreach($produks as $p)
<div class="produk-card">

    <img src="{{ asset('assets/img/'.$p->gambar) }}">

    <div class="produk-content">
        <h3>{{ $p->nama }}</h3>
        <p>Rp {{ number_format($p->harga) }}</p>

        <div class="aksi">
            <a href="/admin/produk/edit/{{ $p->id }}">Edit</a>
            <a href="/admin/produk/delete/{{ $p->id }}">Hapus</a>
        </div>
    </div>

</div>
@endforeach

</div>

@endsection