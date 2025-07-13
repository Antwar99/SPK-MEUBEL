@extends('layouts.admin')

@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-sm-6 col-md-8">
                <h1 class="mt-4">{{ $title }}</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                    <li class="breadcrumb-item"><a href="{{ route('sub-criteria.index') }}">Data Sub Kriteria</a></li>
                </ol>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Kriteria --}}
        <div class="card mb-4">
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                 {{-- Tombol-tombol aksi --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        {{-- Kiri: Tambah dan Hapus --}}
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            {{-- Tambah Kriteria --}}
                            <a href="{{ route('kriteria.create') }}" class="btn btn-primary ">
                                <i class="fas fa-plus me-1"></i>Kriteria
                            </a>

                            {{-- Hapus Semua --}}
                            <form id="deleteAllKriteriaForm" action="{{ route('kriteria.destroyAll') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" id="deleteAllKriteriaBtn">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus Semua
                                </button>
                            </form>
                        </div>

                        {{-- Kanan: Import dan Export --}}
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            {{-- Import Form --}}
                            <form action="{{ route('kriteria.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                @csrf
                                <input type="file" name="file" class="form-control " style="max-width: 270px;" required>
                                <button type="submit" class="btn btn-primary ">
                                    <i class="fas fa-file-import me-1"></i>Import
                                </button>
                            </form>

                            {{-- Export Button --}}
                            <a href="{{ route('kriteria.export') }}" class="btn btn-success ">
                                <i class="fas fa-file-export me-1"></i>Export
                            </a>
                        </div>
                    </div>


                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ($criterias->count())
                            @foreach ($criterias as $criteria)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $criteria->kode }}</td> 
                                    <td>{{ $criteria->name }}</td>
                                    <td>{{ number_format($criteria->bobot, 3) }}</td>
                                    <td>{{ Str::ucfirst(Str::lower($criteria->kategori)) }}</td>
                                    <td>{{ $criteria->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('kriteria.edit', $criteria->id) }}" class="badge bg-warning">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('kriteria.destroy', $criteria->id) }}" method="POST" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="badge bg-danger border-0 btnDelete" data-object="kriteria">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-danger text-center p-4">
                                    <h4>belum membuat kriteria</h4>
                                </td>
                            </tr>
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</main>

{{-- SweetAlert untuk Hapus Semua --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('deleteAllKriteriaBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua data kriteria akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAllKriteriaForm').submit();
            }
        });
    });
</script>
@endsection
