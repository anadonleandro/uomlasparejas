@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptIndexEmpresa.js')}}"></script>
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
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota">
                <a href="{{url('nuevaEmpresa')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-info class texto" title="NUEVA EMPRESA">
                        <i class="fas fa-warehouse"></i> NUEVA EMPRESA
                    </button>
                </a>
                <b>LISTADO GENERAL DE EMPRESAS</b>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="tablaEmpresa" class="table table-striped table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="fuenteNunito">CODIGO</th>
                                    <th class="fuenteNunito">CUIT</th>
                                    <th class="fuenteNunito">RAZON SOCIAL</th>
                                    <th class="fuenteNunito">ACTIVIDAD</th>
                                    <th class="fuenteNunito">INI. ACTIV.</th>
                                    <th class="fuenteNunito">FECHA ALTA</th>
                                    <th class="fuenteNunito">ESTADO</th>
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
