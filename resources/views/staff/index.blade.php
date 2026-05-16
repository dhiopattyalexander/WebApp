@extends('layouts.index')
@section('content')

@php
$ar_judul = ['NO', 'NIP', 'NAMA', 'GENDER', 'EMAIL', 'FOTO', 'ACTION'];
$no = 1;
@endphp

<h3 class="fw-bold">Data Staff</h3>
<a href="{{ route('staff.create') }}"
   class="btn btn-primary btn-sm mb-3"
   title="Tambah Data">
    Tambah Data Staff
</a>

<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-primary text-center">
            <tr>
                @foreach($ar_judul as $jdl)
                    <th scope="col">{{ $jdl }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($ar_staff as $row)
            <tr>

                <!-- No -->
                <th scope="row">{{ $no++ }}</th>

                <!-- Data -->
                <td>{{ $row->nip }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->gender }}</td>
                <td>{{ $row->email }}</td>

                <!-- Foto -->
                <td class="text-center">

                    <img src="{{ asset('storage/' . ($row->foto ?? 'profile.jpg')) }}"
                         width="80"
                         height="80"
                         class="img-thumbnail object-fit-cover"
                         alt="Foto Staff">

                </td>

                <!-- Action -->
                <td>
                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                          action="{{ route('staff.destroy', $row->id) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <a class="btn btn-info btn-sm"
                           href="{{ route('staff.show', $row->id) }}"
                           title="Detail Staff">

                            <i class="bi bi-eye"></i>
                        </a>

                        <a class="btn btn-warning btn-sm"
                           href="{{ route('staff.edit', $row->id) }}"
                           title="Ubah Staff">

                            <i class="bi bi-pencil-fill"></i>
                        </a>

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                title="Hapus Staff">

                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection