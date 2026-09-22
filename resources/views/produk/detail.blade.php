@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')

<div class="container mt-4">

    <h1 class="mb-4">Halaman Detail Produk</h1>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Detail Produk
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/' . $produk->foto) }}" class="img-thumbnail" width="250"
                        alt="{{ $produk->nama }}">
                </div>

                <div class="col-md-8">

                    <table class="table table-bordered">
                        <tr>
                            <th width="35%">Nama Produk</th>
                            <td>{{ $produk->nama }}</td>
                        </tr>

                        <tr>
                            <th>Harga Beli</th>
                            <td>Rp {{ number_format($produk->harga_beli,0,',','.') }}</td>
                        </tr>

                        <tr>
                            <th>Harga Jual</th>
                            <td>Rp {{ number_format($produk->harga_jual,0,',','.') }}</td>
                        </tr>

                        <tr>
                            <th>Stok</th>
                            <td>{{ $produk->stok }}</td>
                        </tr>

                        <tr>
                            <th>Penginput</th>
                            <td>{{ $produk->user->name ?? '-' }}</td>
                        </tr>


                    </table>

                    <div class="mt-3">
                        <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        @can('update', $produk)
                        <a href="{{ route('produk.edit', $produk) }}" class="btn btn-warning">
                            Edit
                        </a>
                        @endcan

                        @can('delete', $produk)
                        <form action="{{ route('produk.destroy', $produk) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                Hapus
                            </button>
                        </form>
                        @endcan

                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection