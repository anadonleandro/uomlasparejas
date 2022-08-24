@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptIndexArchivosExcel.js')}}"></script>
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
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota">
               
                <b>LISTADO ARCHIVOS EXCEL PROCESADOS</b>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="tablaArchivosExcel" class="table table-striped table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="fuenteNunito">ARCHIVO</th>
                                    <th class="fuenteNunito">PROCESADO</th>
                                    <th class="fuenteNunito">CANTIDAD</th>
                                    <th class="fuenteNunito">DEUDAS GENERADAS</th>
                                    <th class="fuenteNunito">EXTRAS</th>
                                    <th class="fuenteNunito">NO GENERADAS</th>
                                    <th class="fuenteNunito">CONVENIOS</th>
                                    <th class="fuenteNunito">USUARIO</th>
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
