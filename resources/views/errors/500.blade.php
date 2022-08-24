@extends('layouts.app')
@section('content')
<div class="row justify-content-center " style="text-align:center">

    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

        <div class="card border-danger mb-3">
            <div class="card-header">Disculpe, surgió un error inesperado! Vuelva a intentarlo mas tarde.
            </div>
            <div class="card-body text-danger">
                <h5 class="card-title">Código error:</h5>
                <p class="card-text">{{$exception->getMessage()}}</p>
            </div>
            <div class="card-footer bg-transparent border-danger">
                <h6><b>Correo Eléctronico: </b></h6>
                <h5><b>...</b></h5>
            </div>
        </div>

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
    <div style="background-image: url(http://10.1.3.224/test/public/svg/404.svg);"
        class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
</div> -->

@endsection
