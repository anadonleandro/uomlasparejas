@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptIndexTitular.js')}}"></script>
<br>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row justify-content-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @if(Session::has('msg'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="close" title="Cerrar">
                <span aria-hidden="true">Cerrar</span>
            </button>
            {{Session::get('msg')}}

        </div>
        @endif
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="close" title="Cerrar">
                <span aria-hidden="true">Cerrar</span>
            </button>
            {{Session::get('message')}}
        </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header color-header-nota">
                <a href="{{url('nuevoTitular')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-info class texto" title="NUEVO TITULAR">
                        <i class="fas fa-user"></i>
                    </button>
                </a>
                <b>LISTADO DE TITULARES</b>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="tablaTitular" class="table table-striped table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="fuenteNunito">NOMBRE</th>
                                    <th class="fuenteNunito">DOCUMENTO</th>
                                    <th class="fuenteNunito">EMPRESA</th>
                                    <th class="fuenteNunito">LOCALIDAD</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
