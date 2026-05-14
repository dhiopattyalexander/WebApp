<!doctype html>
<html lang="en">
  <head>
    <title>My Laravel</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" 
         href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  </head>
  <body>  
  <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
      @include('layouts.header')
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
      @include('layouts.menu')
		</div>
	</div>
    <br/>
	<div class="row">
		<div class="col-md-8">
      @yield('content')     
		</div>
		<div class="col-md-4">
      @include('layouts.sidebar')
		</div>
	</div>
    <br/>
	<div class="row">
		<div class="col-md-12">
      @include('layouts.footer')
		</div>
	</div>
  </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  </body>
</html>