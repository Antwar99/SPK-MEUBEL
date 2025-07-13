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
                    <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Data Kategori</a></li>
                </ol>
            </div>
        </div>

       <div class="card mb-4">
    <div class="card-body table-responsive">
 <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    {{-- Kiri: Tambah dan Hapus --}}
    <div class="d-flex flex-wrap gap-2 align-items-center">
        {{-- Tambah Kayu --}}
        <a href="{{ route('wood.create') }}" class="btn btn-primary ">
            <i class="fas fa-plus me-1"></i> Tambah
        </a>

        {{-- Delete All --}}
        <form id="deleteAllWoodForm" action="{{ route('wood.destroyAll') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-danger " id="deleteAllWoodBtn">
                <i class="fas fa-trash-alt me-1"></i> Hapus Semua
            </button>
        </form>
    </div>

    {{-- Kanan: Import dan Export --}}
    <div class="d-flex flex-wrap gap-2 align-items-center">
        {{-- Import Excel --}}
        <form action="{{ route('wood.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="file" required accept=".xls,.xlsx"
                   class="form-control " style="max-width: 270px;">
            <button type="submit" class="btn btn-primary ">
                <i class="fas fa-file-import me-1"></i> Import
            </button>
        </form>

        {{-- Export Excel --}}
        <a href="{{ route('wood.export') }}" class="btn btn-success ">
            <i class="fas fa-file-excel me-1"></i> Export
        </a>
    </div>
</div>


                {{-- Validasi --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
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
                        <label class="form-label col-lg-7 col-sm-7 col-md-7" for="perPage">entries per page</label>
                    </div>

                    <form action="{{ route('wood.index') }}" method="GET" class="ms-auto float-end">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>

                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode Kayu</th>
                            <th>Nama Kayu</th>
                           
                            <th>Supplier</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($woods->count())
                            @foreach ($woods as $wood)
                                <tr>
                                    <td>{{ ($woods->currentpage() - 1) * $woods->perpage() + $loop->index + 1 }}</td>
                                    <td>{{ $wood->kode_Kayu }}</td>
                                    <td>{{ Str::upper($wood->nama_kayu) }}</td>
                                    
                                    <td>{{ $wood->Supplier ?? '-' }}</td>
                                    <td>{{ $wood->category->category_name ?? 'Tidak Punya Kategori' }}</td>
                                    <td>
                                        <a href="{{ route('wood.edit', $wood->id) }}" class="badge bg-warning">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('wood.destroy', $wood->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button class="badge bg-danger border-0 btnDelete" data-object="kayu">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center text-danger p-4">
                                    <h4>Belum ada data Kayu</h4>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{ $woods->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</main>

<script>
    function submitForm() {
        var perPageSelect = document.getElementById('perPage');
        var perPageValue = perPageSelect.value;

        var url = new URL(window.location.href);
        var params = new URLSearchParams(url.search);

        params.set('perPage', perPageValue);

        url.search = params.toString();
        window.location.href = url.toString();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('deleteAllWoodBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua data kayu akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAllWoodForm').submit();
            }
        });
    });
</script>


@endsection
