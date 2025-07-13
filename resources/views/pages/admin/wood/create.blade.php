@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4 border-bottom">
        <h1 class="mt-4 h2">{{ $title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">{{ $title }}</li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Data Kategori</a></li>
        </ol>
    </div>

    <form class="col-lg-8 container-fluid px-4 mt-3" method="POST" action="{{ route('wood.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Kode Kayu --}}
        <div class="mb-3">
            <label for="kode_kayu" class="form-label">Kode Kayu</label>
            <input type="text" id="kode_kayu" name="kode_kayu" maxlength="10"
                class="form-control @error('kode_kayu') is-invalid @enderror"
                value="{{ old('kode_kayu') }}" required placeholder="Masukkan kode kayu">
            @error('kode_kayu')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Nama Kayu --}}
        <div class="mb-3">
            <label for="nama_kayu" class="form-label">Nama Kayu</label>
            <input type="text" class="form-control @error('nama_kayu') is-invalid @enderror"
                id="nama_kayu" name="nama_kayu" value="{{ old('nama_kayu') }}" required placeholder="Masukkan nama kayu">
            @error('nama_kayu')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    

        {{-- Supplier --}}
        <div class="mb-3">
            <label for="supplier" class="form-label">Supplier</label>
            <input type="text" class="form-control @error('supplier') is-invalid @enderror"
                id="supplier" name="supplier" value="{{ old('supplier') }}" required placeholder="Masukkan nama supplier">
            @error('supplier')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select class="form-select @error('category_id') is-invalid @enderror"
                id="category_id" name="category_id" required>
                <option value="" disabled selected>Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mb-3">Simpan</button>
        <a href="{{ route('wood.index') }}" class="btn btn-danger mb-3">Batal</a>
    </form>
@endsection
