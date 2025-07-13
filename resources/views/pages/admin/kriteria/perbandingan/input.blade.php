@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-sm-6 col-md-8">
                <h1 class="mt-4">{{ $title }}</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('perbandingan.index') }}">Perbandingan Kriteria</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive col-lg-12">
                    
                    @if (!empty($details) && $details->isNotEmpty())
                        <form action="{{ route('perbandingan.update', $details->first()->criteria_analysis_id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $details->first()->criteria_analysis_id }}">

                            <table class="table table-bordered">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center">Kriteria Pertama</th>
                                        <th class="text-center">Intensitas Kepentingan</th>
                                        <th class="text-center">Kriteria Kedua</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($details as $index => $detail)
    <tr>
        {{-- Hidden input untuk ID detail (wajib untuk update) --}}
        <input type="hidden" name="criteria_analysis_detail_id[]" value="{{ $detail->id }}">

        <td class="text-center">{{ $detail->firstCriteria->name }}</td>

        <td class="text-center">
            <select class="form-select" name="comparison_values[]" required>
                <option value="" disabled {{ is_null($detail->comparison_value) ? 'selected' : '' }}>--Pilih Nilai--</option>
                @for ($i = 1; $i <= 9; $i++)
                    <option value="{{ $i }}" {{ $detail->comparison_value == $i ? 'selected' : '' }}>
                        {{ $i }} -
                        @switch($i)
                            @case(1) Sama Pentingnya @break
                            @case(2) Mendekati sedikit lebih penting @break
                            @case(3) Sedikit lebih penting @break
                            @case(4) Mendekati lebih penting @break
                            @case(5) Lebih penting @break
                            @case(6) Mendekati sangat penting @break
                            @case(7) Sangat penting @break
                            @case(8) Mendekati mutlak sangat penting @break
                            @case(9) Mutlak sangat penting @break
                        @endswitch
                    </option>
                @endfor
            </select>
        </td>

        <td class="text-center">{{ $detail->secondCriteria->name }}</td>
    </tr>
@endforeach


                                </tbody>
                            </table>

                            <div class="d-flex justify-content-between mt-3">
                                @can('admin')
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                                    </button>
                                @endcan

                                @if ($isDoneCounting)
                                    <a href="{{ route('perbandingan.result', $criteria_analysis->id) }}" class="btn btn-success">
                                        <i class="fa-solid fa-eye"></i> Hasil
                                    </a>
                                @else
                                    <button class="btn btn-success" disabled>
                                        <i class="fa-solid fa-eye"></i> Operator belum menyimpan kriteria
                                    </button>
                                @endif
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning text-center">
                            Tidak ada data perbandingan kriteria yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
