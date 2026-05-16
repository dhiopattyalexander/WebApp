<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Laravel</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

<div class="container-fluid">

    <!-- Header -->
    <div class="row">
        <div class="col-12">
            @include('layouts.header')
        </div>
    </div>

    <!-- Menu -->
    <div class="row">
        <div class="col-12">
            @include('layouts.menu')
        </div>
    </div>

    <!-- Content -->
    <div class="row mt-3">

        <!-- Main Content -->
        <div class="col-md-8 mb-3">

            @if(Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if(Session::get('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif

            <div class="card p-3 shadow-sm">
                @yield('content')
            </div>

        </div>

        <!-- Sidebar -->
        <div class="col-md-4 mb-3">
            @include('layouts.sidebar')
        </div>

    </div>

    <!-- Footer -->
    <div class="row">
        <div class="col-12">
            @include('layouts.footer')
        </div>
    </div>

</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>