@extends('layouts.index')
@section('content')

<div class="d-flex justify-content-center">
  <div class="card mb-3" style="max-width: 540px; width:100%;">
    <div class="row g-0">
      <div class="col-md-4 d-flex align-items-center justify-content-center p-3">
        <img src="{{ asset('storage/' . ($row->foto ?? 'profile.jpg')) }}"
             class="img-fluid rounded img-thumbnail"
             alt="..."
             width="180">
      </div>

      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title fw-bold border-bottom pb-2 mb-3">Detail Staff</h5>
          <p class="card-text">Nama: {{ $row->nama }}</p>
          <p class="card-text">NIP: {{ $row->nip }}</p>
          <p class="card-text">Jenis Kelamin: {{ $row->gender }}</p>
          <p class="card-text">Email: {{ $row->email }}</p>
          <p class="card-text">Alamat: {{ $row->alamat }}</p>

          <hr/>

          <a href="{{ url('/staff') }}" class="btn btn-primary">
            Back
          </a>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection