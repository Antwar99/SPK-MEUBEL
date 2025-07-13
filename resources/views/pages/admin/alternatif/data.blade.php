@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="row align-items-center">
        <div class="col-sm-6 col-md-8">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </div>
    </div>
        <div class="card mb-4">
            <div class="card-body table-responsive">
            @can('admin')
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            {{-- Kiri: Tambah dan Hapus Semua --}}
            <div class="d-flex flex-wrap gap-2 align-items-center">
        {{-- Tambah Alternatif --}}
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAlternativeModal">
            <i class="fas fa-plus me-1"></i> Tambah
        </button>

        {{-- Hapus Semua --}}
        <form id="deleteAllForm" action="{{ route('alternatif.destroyAll') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger" id="deleteAllBtn">
                <i class="fas fa-trash-alt me-1"></i> Hapus Semua
            </button>
        </form>
    </div>

    {{-- Kanan: Import dan Export --}}
    <div class="d-flex flex-wrap gap-2 align-items-center">
        {{-- Import --}}
        <form action="{{ route('alternatives.import') }}" method="POST" enctype="multipart/form-data"
              class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="file" accept=".xls,.xlsx"
                   class="form-control" style="max-width: 270px;" required>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-file-import me-1"></i> Import
            </button>
        </form>

        {{-- Export --}}
        <a href="{{ route('alternatives.export') }}" class="btn btn-primary text-white">
            <i class="fas fa-file-export me-1"></i> Export
        </a>
    </div>
</div>
@endcan



            {{-- Error messages --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-sm-flex align-items-center justify-content-between">
                <div class="d-sm-flex align-items-center mb-3">
                    <select class="form-select me-3" id="perPage" name="perPage" onchange="submitForm()">
                        @foreach ($perPageOptions as $option)
                            <option value="{{ $option }}" {{ $option == $perPage ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                    <label class="form-label" for="perPage">entri per halaman</label>
                </div>

                <form action="{{ route('alternatif.index') }}" method="GET" class="ms-auto float-end">
                    <div class="input-group mb-2">
                        <input type="text" name="search" class="form-control" placeholder="Cari kayu..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <table class="table table-bordered table-responsive">
                <thead class="table-primary align-middle">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Nama Kayu</th>
                        <th class="text-center" rowspan="2">Kategori</th>
                        <th class="text-center" colspan="{{ $criterias->count() }}">Kriteria</th>
                        @can('admin')
                            <th class="text-center" rowspan="2">Aksi</th>
                        @endcan
                    </tr>
                    <tr>
                        @forelse ($criterias as $criteria)
                            <th class="text-center">{{ $criteria->name }}</th>
                        @empty
                            <th class="text-center">Data Kriteria Tidak Ada</th>
                        @endforelse
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @forelse ($alternatives as $alternative)
                        <tr>
                            <td class="text-center">
                                {{ ($alternatives->currentpage() - 1) * $alternatives->perpage() + $loop->index + 1 }}
                            </td>
                            <td>{{ Str::upper($alternative->nama_kayu) }}</td>
                            <td class="text-center">{{ $alternative->category->category_name ?? '-' }}</td>
                            @foreach ($criterias as $key => $criteria)
                                <td class="text-center">
                                    {{ $alternative->alternatives[$key]->alternative_value ?? 'Empty' }}
                                </td>
                            @endforeach
                            @can('admin')
                                <td class="text-center">
                                    <a href="{{ route('alternatif.edit', $alternative->id) }}"
                                        class="badge bg-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('alternatif.destroy', $alternative->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="badge bg-danger border-0 btnDelete" data-object="alternatif">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 5 + $criterias->count() }}" class="text-center text-danger">
                                Belum ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $alternatives->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Kayu -->
<div class="modal fade" id="addAlternativeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addAlternativeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Kayu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('alternatif.index') }}" method="post">
                @csrf
                <div class="modal-body">
                    <ul class="list-group mb-3">
                        <li class="list-group-item bg-success text-white">Masukkan nilai dengan pilihan sub kriteria</li>
                        <li class="list-group-item bg-success text-white">setiap sub kriteria yang dipilih sudah mendapat 
                            nilai sesuai dengan level</li>
                        <li class="list-group-item bg-warning text-black">sangat baik (4), baik (3), cukup (2), buruk (1)</li>
                    </ul>

                   {{-- Pilih Kayu --}}
                <div class="mb-3">
                    <label for="wood_id" class="form-label">Daftar Kayu</label>
                    <select class="form-select @error('wood_id') is-invalid @enderror" id="wood_id" name="wood_id" required>
                        <option disabled selected>--Pilih Kayu--</option>
                        @foreach ($wood_list as $kategori => $woods)
                            <optgroup label="{{ $kategori }} ({{ $woods->count() }})">
                                @foreach ($woods as $wood)
                                    <option value="{{ $wood->id }}" data-category="{{ $wood->category_id }}">
                                        {{ $wood->nama_kayu }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('wood_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

{{-- Input Hidden untuk Category ID --}}
<input type="hidden" name="category_id" id="category_id_hidden">


                  @foreach ($criterias as $criteria)
                        <div class="mb-3">
                            <label for="subcriteria_{{ $criteria->id }}" class="form-label">
                                {{ $criteria->name }}
                            </label>
                            <select name="subcriteria_id[]" class="form-select" required>
                                <option value="" disabled selected>Pilih Subkriteria</option>
                                @foreach ($criteria->subcriterias as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->name }} (Nilai: {{ $sub->value }})</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="criteria_id[]" value="{{ $criteria->id }}">
                        </div>
                    @endforeach

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="{{ $criterias->count() ? 'submit' : 'button' }}" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function submitForm() {
        let perPage = document.getElementById('perPage').value;
        let url = new URL(window.location.href);
        let params = new URLSearchParams(url.search);
        params.set('perPage', perPage);
        url.search = params.toString();
        window.location.href = url.toString();
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#category').on('change', function () {
        let categoryID = $(this).val();
        if (categoryID) {
            $.ajax({
                url: '/alternatif/wood-by-category/' + categoryID,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#wood').empty().append('<option value="">--Pilih Kayu--</option>');
                    $.each(data, function (index, wood) {
                        $('#wood').append('<option value="' + wood.id + '">' + wood.nama_kayu + '</option>');
                    });
                },
                error: function () {
                    alert('Gagal mengambil data kayu.');
                }
            });
        } else {
            $('#wood').empty().append('<option value="">--Pilih Kayu--</option>');
        }
    });
</script>
<script>
    document.getElementById('wood_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const categoryId = selectedOption.getAttribute('data-category');
        document.getElementById('category_id_hidden').value = categoryId;
    });
</script>
<script>
    document.getElementById('deleteAllBtn').addEventListener('click', function (e) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua data alternatif akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAllForm').submit();
            }
        });
    });
</script>



@endsection
