@extends('layouts.admin')

@section('content')

<div class="container-fluid px-4 border-bottom">
    <h1 class="mt-4 h2">{{ $title }}</h1>
    <p>Masukkan nilai rata-rata dari kriteria bahan baku kayu</p>
</div>

<form class="col-lg-8 container-fluid px-4 mt-3" method="POST"
    action="{{ route('alternatif.update', $wood->id) }}">
    @method('PUT')
    @csrf

    <fieldset disabled>
        <div class="row">
            <div class="mb-3 col-lg-6">
                <label for="name" class="form-label">Nama Kayu</label>
                <input type="text" class="form-control" value="{{ old('name', $wood->nama_kayu) }}" readonly required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-lg-6">
                <label for="category" class="form-label">Kategori</label>
                <input type="text" class="form-control" value="{{ old('category', $wood->category->category_name) }}" readonly required>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </fieldset>

    @foreach ($wood->alternatives as $value)
        <div class="mb-3">
            <input type="hidden" name="criteria_id[]" value="{{ $value->criteria->id }}">
            <input type="hidden" name="alternative_id[]" value="{{ $value->id }}">

            <label for="{{ str_replace(' ', '', $value->criteria->name) }}" class="form-label">
                Nilai <b>{{ $value->criteria->name }}</b>
            </label>
            <input type="text" id="{{ str_replace(' ', '', $value->criteria->name) }}"
                class="form-control @error('alternative_value') is-invalid @enderror"
                name="alternative_value[]" placeholder="Masukkan nilai"
                onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57)|| event.charCode == 46)"
                value="{{ floatval($value->alternative_value) }}" maxlength="5" autocomplete="off" required>

            @error('alternative_value')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endforeach

    @if ($newCriterias->count())
        <input type="hidden" name="wood_id" value="{{ $wood->id }}">
        <input type="hidden" name="category_id" value="{{ $wood->category_id }}">
        @foreach ($newCriterias as $value)
            <div class="mb-3">
                <input type="hidden" name="new_criteria_id[]" value="{{ $value->id }}">
                <label for="{{ str_replace(' ', '', $value->name) }}" class="form-label">
                    Nilai <b>{{ $value->name }}</b>
                </label>
                <input type="text" id="{{ str_replace(' ', '', $value->name) }}"
                    class="form-control @error('new_alternative_value') is-invalid @enderror"
                    name="new_alternative_value[]" placeholder="Masukkan nilai"
                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57)|| event.charCode == 46)"
                    maxlength="3" autocomplete="off" required>

                @error('new_alternative_value')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @endforeach
    @endif

    <button type="submit" class="btn btn-primary mb-3">Simpan Perubahan</button>
    <a href="/dashboard/alternatif" class="btn btn-danger mb-3">Batal</a>
</form>

@endsection
