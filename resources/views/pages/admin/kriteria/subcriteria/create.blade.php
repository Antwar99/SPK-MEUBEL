@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4 border-bottom">
        <h1 class="mt-4 h2">Tambah Sub Kriteria</h1>
    </div>

    <div class="container-fluid px-4 mt-3">
        <div class="row align-items-center">
            <form class="col-lg-10" method="POST" action="{{ route('sub-criteria.store') }}">
                @csrf

                {{-- Pilih Kriteria --}}
                <div class="mb-3">
                    <label for="criteria_kode" class="form-label">Kriteria</label>
                    <select name="criteria_kode" id="criteria_kode" class="form-select @error('criteria_kode') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Kriteria</option>
                        @foreach ($criterias as $criteria)
                            <option value="{{ $criteria->kode }}" {{ old('criteria_kode') == $criteria->kode ? 'selected' : '' }}>
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

                {{-- 4 Baris Input Sub Kriteria --}}
                @for ($i = 0; $i < 4; $i++)
                    <div class="border rounded p-3 mb-3">
                        <h6>Sub Kriteria {{ $i + 1 }}</h6>

                        <div class="mb-2">
                            <label class="form-label">Nama Sub Kriteria</label>
                            <input type="text" name="sub_name[]" class="form-control" placeholder="Contoh: Kuat Tarik" />
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Level</label>
                            <select name="sub_level[]" class="form-select">
                                <option value="">Pilih</option>
                                <option value="Sangat Baik">Sangat Baik</option>
                                <option value="Baik">Baik</option>
                                <option value="Cukup">Cukup</option>
                                <option value="Buruk">Buruk</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Nilai</label>
                            <input type="number" name="value[]" class="form-control" step="0.01" placeholder="Contoh: 4.0" />
                        </div>
                    </div>
                @endfor

                <button type="submit" class="btn btn-primary mb-3">Simpan</button>
                <a href="{{ route('sub-criteria.index') }}" class="btn btn-danger mb-3">Batal</a>
            </form>
        </div>
    </div>
@endsection
