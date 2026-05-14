@extends('layouts.index')
@section('content')
@foreach ($ar_staff as $row)
<div class="card" style="width: 15rem;">
  <img src="{{ asset('images/profile.jpg') }}" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">{{ $row->nama }}</h5>
    <p class="card-text">{{ $row->nip }}</p>
      <p class="card-text">{{ $row->gender }}</p>
    <a href="#" class="btn btn-primary">Detail</a>
  </div>
</div>
@endforeach
@endsection 