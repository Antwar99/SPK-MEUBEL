@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Detail Kategori : {{ $category }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('wood.index') }}">Data Kayu</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Data Kategori</a></li>
            <li class="breadcrumb-item active">{{ $category}}</li>
        </ol>

        {{-- datatable --}}
        <div class="card col-lg-10">
            <div class="card-body table-responsive">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode Kayu</th>
                            <th>Nama Kayu</th>
                            <th>Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($woods->count())
                            @foreach ($woods as $wood)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $wood->kode_Kayu}}</td>
                                    <td>{{ $wood->nama_kayu }}</td>
                                    <td>{{ $wood->Supplier }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-danger text-center p-4">
                                    <h4>Belum ada data Kayu</h4>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
