@extends('layouts.index')
@section('content')
<div class="card">
    <div class="card-body">
        <br />
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h5 class="card-title">Form Staff</h5>
        <!-- No Labels Form -->
        <form class="row g-3" method="POST" action="{{ route('staff.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <label for="basic-url" class="form-label">NIP</label>
                <input type="text" class="form-control" name="nip"
                    value="" placeholder="NIP">
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="basic-url" class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama"
                    value="" placeholder="Nama Staff">
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-12">
                <fieldset class="row mb-3r">
                    <label for="basic-url" class="form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        @foreach($ar_gender as $g )
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value=" {{ $g }}" >
                                <label class="form-check-label">
                                    {{ $g }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
                @error('gender')
                    <font color="red">{{ $message }}</font>
                @enderror 
            </div>
            
            <div class="col-12">
                <label for="basic-url" class="form-label">Alamat</label>
                <textarea class="form-control" 
                 name="alamat" cols="50" rows="5"></textarea>
                 @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                 @enderror  
            </div>
            <div class="col-md-12">
                <input type="text" class="form-control" 
                 name="email" value="" placeholder="Email">
                 @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                 @enderror  
            </div>
            <div class="col-md-12">
                <label for="basic-url" class="form-label">Foto</label>
                
                <input type="file" class="form-control" name="foto">

                @error('foto')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                <a href="{{ url('/staff') }}" class="btn btn-secondary btn-sm">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection