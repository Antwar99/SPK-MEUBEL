@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Sub Kriteria</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Sub Kriteria</li>
    </ol>

    <div class="card mb-4">
                <div class="card-body table-responsive">
                   <table class="table table-bordered">
                       <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                        {{-- Kiri: Tambah dan Hapus --}}
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            {{-- Tambah Kriteria --}}
                            <a href="{{ route('sub-criteria.create') }}" class="btn btn-primary ">
                                <i class="fas fa-plus me-1"></i>Kriteria
                            </a>

                            {{-- Hapus Semua --}}
                            <form id="deleteAllsubcriteriaForm" action="{{ route('sub-criteria.destroyAll') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger" id="deleteAllsubcriteriaBtn">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus Semua
                                </button>
                            </form>
                        </div>

                        {{-- Kanan: Import dan Export --}}
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            {{-- Import Form --}}
                            <form action="{{ route('sub-criteria.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                @csrf
                                <input type="file" name="file" class="form-control " style="max-width: 270px;" required>
                                <button type="submit" class="btn btn-primary ">
                                    <i class="fas fa-file-import me-1"></i>Import
                                </button>
                            </form>

                            {{-- Export Button --}}
                            <a href="{{ route('sub-criteria.export') }}" class="btn btn-success ">
                                <i class="fas fa-file-export me-1"></i>Export
                            </a>
                        </div>
                    </div>

                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Kriteria</th>
                                <th>Sub kriteria</th>
                                <th>Level</th> {{-- Tambahan: Sangat Baik, Baik, dst --}}
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subCriterias as $sub)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sub->criteria->name }}</td>
                                    <td>{{ $sub->name }}</td> 
                                    <td>{{ $sub->level }}</td> 
                                    <td>{{ $sub->value }}</td>
                                    <td>
                                        <a href="{{ route('sub-criteria.edit', $sub->id) }}" class="badge bg-warning">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                    <form action="{{ route('sub-criteria.destroy', $sub->id) }}" method="POST" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button class="badge bg-danger border-0 btnDelete" data-object="kriteria">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button>
                                                            </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Belum ada data sub kriteria.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

        </div>
    </div>
</div>
{{-- SweetAlert untuk Hapus Semua --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('deleteAllsub-criteriaBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua data subkriteria akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAllsub-criteriaForm').submit();
            }
        });
    });
</script>
@endsection
