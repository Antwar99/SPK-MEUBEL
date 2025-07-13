@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4 border-bottom">
        <h1 class="mt-4 h2">{{ $title }}</h1>
    </div>

    <form class="col-lg-8 container-fluid px-4 mt-3" method="POST" action="{{ route('wood.update', $wood->id) }}"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf

        {{-- Kode Kayu --}}
        <div class="mb-3">
            <label for="kode_kayu" class="form-label">Kode Kayu</label>
            <input type="text" id="kode_kayu" name="kode_kayu"
                class="form-control @error('kode_kayu') is-invalid @enderror"
                value="{{ old('kode_kayu', $wood->kode_kayu) }}" required maxlength="10">

            @error('kode_kayu')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Nama Kayu --}}
        <div class="mb-3">
            <label for="nama_kayu" class="form-label">Nama Kayu</label>
            <input type="text" id="nama_kayu" name="nama_kayu"
                class="form-control @error('nama_kayu') is-invalid @enderror"
                value="{{ old('nama_kayu', $wood->nama_kayu) }}" required>

            @error('nama_kayu')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

    

        {{-- Supplier --}}
        <div class="mb-3">
            <label for="supplier" class="form-label">Supplier</label>
            <input type="text" id="supplier" name="supplier"
                class="form-control @error('supplier') is-invalid @enderror"
                value="{{ old('supplier', $wood->supplier) }}" required>

            @error('supplier')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select id="category_id" name="category_id"
                class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="" disabled>Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $wood->category_id) == $category->id ? 'selected' : '' }}>
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

        {{-- Tombol --}}
        <button type="submit" class="btn btn-primary mb-3">Perbarui</button>
        <a href="{{ route('wood.index') }}" class="btn btn-secondary mb-3">Kembali</a>
    </form>
@endsection
