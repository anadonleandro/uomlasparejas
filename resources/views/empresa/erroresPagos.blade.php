@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptConsultaErroresPagos.js')}}"></script>
<style>
    .columnaConNumero {
        text-align: right;
    }

    .thead {
        text-align: left;
    }

</style>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota" style="background-color: #be9096;">
                <b>BUSCAR EMPRESAS INEXISTENTES</b>
            </div>
            @if ($message = Session::get('errors'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            <br>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA DESDE</label>
                            <input type="date" name="fecha_desde" id="fecha_desde" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA HASTA</label>
                            <input type="date" name="fecha_hasta" id="fecha_hasta" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <button class="btn btn-block btn-outline-success" type="button" onclick="filtrar()">
                            <div class="iconos-class"><i class="fas fa-search" aria-hidden="true"></i> COMENZAR
                                BUSQUEDA </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota" style="background-color: #be9096;">
                <b>RESULTADOS</b>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tablaConsultaErrores" class="table table-striped table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="fuenteNunito">EMPRESA</th>
                                        <th class="fuenteNunito">CUIT</th>
                                        <th class="fuenteNunito">EMPLEADOS</th>
                                        <th class="fuenteNunito">$ DEPOSITADO</th>
                                        <th class="fuenteNunito">CONCEPTO</th>
                                        <th class="fuenteNunito">PROCESADO</th>
                                        <th class="fuenteNunito">ARCHIVO</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection