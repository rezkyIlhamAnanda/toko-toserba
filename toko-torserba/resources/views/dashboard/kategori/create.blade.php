@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-center align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h3 text-center" style="color: #0B773D;">Input Data Kategori</h2>
</div>
<div class="row">
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- Nama Kategori --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Nama Kategori">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Gambar Kategori --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Kategori</label>
                    <input
                        type="file"
                        class="form-control @error('image') is-invalid @enderror"
                        name="image"
                        id="image">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
  </div>
</div>
@endsection
