@extends('layouts.app')
@section('content')

<div class="row" style="text-align: center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <p><h3><b>ERROR 419</b></h3></p>
    </div>
</div>
<div class="row" style="text-align: center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <p><h3><b>SESION EXPIRADA</b></h3></p>
    </div>
</div>
<div class="row" style="text-align: center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a href="{{ route('login') }}">
       		<button class="btn btn-dark">
                   INICIAR SESION
            </button>
        </a>
    </div>
</div>

<!-- <div class="relative pb-full md:flex md:pb-0 md:min-h-screen w-full md:w-1/2">
    <div style="background-image: url(http://10.1.3.224/test/public/svg/404.svg);" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
</div> -->

@endsection