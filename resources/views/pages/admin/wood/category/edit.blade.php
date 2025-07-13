@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4 border-bottom">
        <h1 class="mt-4 h2">{{ $title }}</h1>
    </div>

 <form class="col-lg-8 container-fluid px-4 mt-3" method="POST" action="{{ route('category.update', $category->id) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="category_name" class="form-label">Nama Kategori</label>
        <input type="text" id="category_name" name="category_name" class="form-control @error('category_name') is-invalid @enderror"
            value="{{ old('category_name', $category->category_name) }}" autofocus required placeholder="Masukkan nama kategori">

        @error('category_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary mb-3">Update</button>
    <a href="{{ route('category.index') }}" class="btn btn-danger mb-3">Cancel</a>
</form>

@endsection
