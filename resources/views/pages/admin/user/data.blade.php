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

        {{-- datatable --}}
        <div class="card mb-4">
            <div class="card-body table-responsive">
                <div class="d-sm-flex align-items-center justify-content-between">
                      <div class="d-flex flex-wrap gap-2 align-items-center">
                    <a href="{{ route('users.create') }}" type="button" class="btn btn-primary mb-3"><i
                            class="fas fa-plus me-1"></i>Pengguna</a>

                              {{-- Hapus Semua --}}
                        <form id="deleteAllUsersForm" action="{{ route('users.destroyAll') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger mb-3" id="deleteAllUsersBtn">
                                <i class="fas fa-trash-alt me-1"></i> Hapus Semua
                            </button>
                        </form>
                    </div>
                                    {{-- Kanan: Import dan Export --}}
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        {{-- Import --}}
                        <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data"
                            class="d-flex align-items-center gap-2">
                            @csrf
                            <input type="file" name="file" accept=".xls,.xlsx"
                                class="form-control mb-3" style="max-width: 270px;" required>
                            <button type="submit" class="btn btn-success mb-3">
                                <i class="fas fa-file-import me-1"></i> Import
                            </button>
                        </form>

                        {{-- Export --}}
                        <a href="{{ route('users.export') }}" class="btn btn-primary mb-3 text-white">
                            <i class="fas fa-file-export me-1"></i> Export
                        </a>
                    </div>

                </div>

               

                {{-- validate req field --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- file request --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <table id="datatablesSimple" class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->count())
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $user->name }}</td>
                                    <td class="text-center">{{ $user->username }}</td>
                                    <td class="text-center">{{ $user->email }}</td>
                                    
                                    <td class="text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="badge bg-warning"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="badge bg-danger border-0 btnDelete" data-object="siswa"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-danger text-center p-4">
                                    <h4>Operator belum membuat pengguna</h4>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('deleteAllUsersBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin ingin menghapus semua pengguna?',
            text: 'Seluruh data pengguna akan dihapus kecuali akun yang sedang login!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus semua!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteAllUsersForm').submit();
            }
        });
    });
</script>

@endsection
