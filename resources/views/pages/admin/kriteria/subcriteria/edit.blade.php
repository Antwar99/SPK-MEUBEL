@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4 border-bottom">
        <h1 class="mt-4 h2">{{ $title }}</h1>
    </div>

    <div class="container-fluid px-4 mt-3">
        <div class="row align-items-center">
            <form class="col-lg-8" method="POST" action="{{ route('sub-criteria.update', $subCriteria->id) }}">
                @method('PUT')
                @csrf

                <div class="mb-3">
                    <label for="criteria_kode" class="form-label">Kriteria</label>
                    <select name="criteria_kode" id="criteria_kode" class="form-select @error('criteria_kode') is-invalid @enderror" required>
                        <option value="" disabled>Pilih Kriteria</option>
                        @foreach ($criterias as $criteria)
                            <option value="{{ $criteria->kode }}" {{ old('criteria_kode', $subCriteria->criteria_kode) == $criteria->kode ? 'selected' : '' }}>
                                {{ $criteria->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('criteria_kode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sub_name" class="form-label">Nama Sub Kriteria</label>
                    <input type="text" class="form-control @error('sub_name') is-invalid @enderror" id="sub_name"
                        name="sub_name" value="{{ old('sub_name', $subCriteria->name) }}" required>
                    @error('sub_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="label" class="form-label">Level</label>
                    <select name="label" id="label" class="form-select @error('label') is-invalid @enderror" required>
                        <option value="">Pilih</option>
                        <option value="Sangat Baik" {{ old('label', $subCriteria->level) == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                        <option value="Baik" {{ old('label', $subCriteria->level) == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Cukup" {{ old('label', $subCriteria->level) == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                        <option value="Buruk" {{ old('label', $subCriteria->level) == 'Buruk' ? 'selected' : '' }}>Buruk</option>
                    </select>
                    @error('label')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label">Nilai</label>
                    <input type="number" step="0.01" class="form-control @error('value') is-invalid @enderror"
                        id="value" name="value" value="{{ old('value', $subCriteria->value) }}" required>
                    @error('value')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mb-3">Simpan Perubahan</button>
                <a href="{{ route('sub-criteria.index') }}" class="btn btn-danger mb-3">Batal</a>
            </form>
        </div>
    </div>
@endsection
