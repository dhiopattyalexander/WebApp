@extends('layouts.index')

@section('content')
<div class="card">
    <div class="card-body">
        <br />

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h5 class="card-title fw-bold">Form Edit Staff</h5>

        <!-- Form Edit -->
        <form class="row g-3"
              method="POST"
              action="{{ route('staff.update', $row->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- NIP -->
            <div class="col-md-12">
                <label class="form-label">NIP</label>

                <input type="text"
                       class="form-control"
                       name="nip"
                       value="{{ old('nip', $row->nip) }}"
                       placeholder="NIP">

                @error('nip')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nama -->
            <div class="col-md-12">
                <label class="form-label">Nama</label>

                <input type="text"
                       class="form-control"
                       name="nama"
                       value="{{ old('nama', $row->nama) }}"
                       placeholder="Nama Staff">

                @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Gender -->
            <div class="col-md-12">
                <label class="form-label">Jenis Kelamin</label>

                @foreach($ar_gender as $g)
                    <div class="form-check">
                        <input class="form-check-input"
                               type="radio"
                               name="gender"
                               value="{{ $g }}"
                               {{ old('gender', $row->gender) == $g ? 'checked' : '' }}>

                        <label class="form-check-label">
                            {{ $g }}
                        </label>
                    </div>
                @endforeach

                @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="col-md-12">
                <label class="form-label">Alamat</label>

                <textarea class="form-control"
                          name="alamat"
                          rows="5"
                          placeholder="Alamat Staff">{{ old('alamat', $row->alamat) }}</textarea>

                @error('alamat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="col-md-12">
                <label class="form-label">Email</label>

                <input type="email"
                       class="form-control"
                       name="email"
                       value="{{ old('email', $row->email) }}"
                       placeholder="Email">

                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Foto -->
            <div class="col-md-12">
                <label class="form-label">Foto</label>

                <div class="mb-2">
                    <img src="{{ asset('storage/' . ($row->foto ?? 'profile.jpg')) }}"
                         width="120"
                         class="img-thumbnail"
                         alt="Foto Staff">
                </div>

                <input type="file"
                       class="form-control"
                       name="foto">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti foto
                </small>

                @error('foto')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary btn-sm">
                    Update
                </button>

                <a href="{{ url('/staff') }}"
                   class="btn btn-secondary btn-sm">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection