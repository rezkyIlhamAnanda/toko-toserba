@extends('layouts.main')

@section('content')
<div class="container py-4">

    {{-- Judul Halaman --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color: #0B773D;">Edit Data Kategori</h2>
        <p class="text-muted">Perbarui informasi kategori produk </p>
    </div>

    {{-- Card Form --}}
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4">

                    {{-- Form --}}
                    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Input Nama --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Nama Kategori</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   placeholder="Masukkan nama kategori"
                                   value="{{ old('name', $category->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Input Gambar --}}
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Gambar Kategori</label>
                            <div class="d-flex align-items-center gap-3">
                                <input type="file"
                                       name="image"
                                       id="image"
                                       class="form-control @error('image') is-invalid @enderror"
                                       accept="image/*">
                                @if ($category->image)
                                    <img src="{{ asset('images/categories/' . $category->image) }}"
                                         alt="Gambar Kategori"
                                         class="rounded shadow-sm"
                                         width="90" height="90"
                                         style="object-fit: cover;">
                                @endif
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>

                            <button type="submit"
                                    class="btn px-4 text-white fw-semibold"
                                    style="background-color: #0B773D;">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Sedikit CSS tambahan untuk mempercantik --}}
<style>
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    label {
        color: #0B773D;
    }
</style>
@endsection
