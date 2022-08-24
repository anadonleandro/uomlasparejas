@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptIndexDeudaManual.js')}}"></script>
<script src="{{asset('js/scriptValidaPagoManual.js')}}"></script>
<script src="{{asset('sweetalert/sweetalert.js') }}"></script>
<br>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .columnaConNumero {
        text-align: right;
    }

    .thead {
        text-align: left;
    }

</style>
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
                <a href="{{url('imputacionManual')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-info class texto" title="NUEVO PAGO MANUAL DE DEUDA">
                        <i class="fas fa-user"></i>
                    </button>
                </a>
                <b>LISTADO DE IMPUTACIONES MANUALES DE DEUDAS</b>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="tablaDeudaManual" class="table table-striped table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="fuenteNunito">EMPRESA</th>
                                    <th class="fuenteNunito">CONCEPTO</th>
                                    <th class="fuenteNunito">FECHA PAGO</th>
                                    <th class="fuenteNunito">PERIODO</th>
                                    <th class="fuenteNunito">AFILIADOS</th>
                                    <th class="fuenteNunito">$ BASE REMUN.</th>
                                    <th class="fuenteNunito">$ DEPOSITADO</th>
                                    <th class="fuenteNunito">USUARIO</th>
                                    <th class="fuenteNunito">GENERADO</th>
                                    <th class="fuenteNunito">ELIMINAR</th>
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
