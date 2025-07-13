@extends('layouts.admin')

@section('content')
    <div class="container-fluid px-4 border-bottom">
        <h1 class="mt-4 h2">{{ $title }}</h1>
    </div>

    <form class="col-lg-8 container-fluid px-4 mt-3" method="POST" action="{{ route('users.store') }}"
        enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" autofocus required placeholder="Masukan nama lengkap">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                name="username" value="{{ old('username') }}" required placeholder="Masukan username">
            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email') }}" required placeholder="example@example.com">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                    id="myInput" name="password" required placeholder="Masukan password" aria-describedby="basic-addon2">
                <span class="input-group-text" id="basic-addon2">
                    <i class="fa-solid fa-eye-slash pointer" id="hide" onclick="myFunction()"></i>
                    &nbsp;
                    <i class="fa-solid fa-eye pointer" id="show" onclick="myFunction()"></i>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" name="password_confirmation"
                required placeholder="Ulangi password">
        </div>

        <button type="submit" class="btn btn-primary mb-3">Save</button>
        <a href="{{ route('users.index') }}" class="btn btn-danger mb-3">Cancel</a>
    </form>
@endsection

@section('scripts')
    <script>
        function myFunction() {
            var input = document.getElementById("myInput");
            var hide = document.getElementById("hide");
            var show = document.getElementById("show");

            if (input.type === "password") {
                input.type = "text";
                hide.style.display = "inline";
                show.style.display = "none";
            } else {
                input.type = "password";
                hide.style.display = "none";
                show.style.display = "inline";
            }
        }

        // Hide eye icon on load
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("hide").style.display = "none";
        });
    </script>
@endsection
