@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptConsultaConvenio.js')}}"></script>
<br>

<style>
    .columnaConNumero {
        text-align: right;
    }

    .thead {
        text-align: left;
    }

</style>

<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota" style="background-color: #be9096;">
                <b>BUSCAR CONVENIO POR EMPRESA</b>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fuenteNunito">EMPRESA DESDE</label>
                            <select name="empresa_desde" id="empresa_desde" class="form-control selectpicker"
                                data-live-search="true" required>
                                @foreach($empresas as $empresa)
                                <option value="{{$empresa->id_empresa}}">
                                    {{$empresa->cod_empresa." - ".$empresa->nom_empresa}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fuenteNunito">EMPRESA HASTA</label>
                            <select name="empresa_hasta" id="empresa_hasta" class="form-control selectpicker"
                                data-live-search="true" required>
                                @foreach($empresas as $empresa)
                                <option value="{{$empresa->id_empresa}}">
                                    {{$empresa->cod_empresa." - ".$empresa->nom_empresa}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">CONCEPTO </label>
                            <select name="concepto" id="concepto" class="form-control" required>
                                <option value="0" selected>TODOS</option>
                                <option value="1">OBRA SOCIAL</option>
                                <option value="2">2,5% SINDICAL</option>
                                <option value="3">SEGURO</option>
                                <option value="4">2% SINDICAL</option>
                                <option value="5">ACUERDO DE PAGOS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA ACREDITACION DESDE</label>
                            <input type="date" name="fecha_desde" id="fecha_desde" value="<?php echo date("Y-m-d"); ?>"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA ACREDITACION HASTA</label>
                            <input type="date" name="fecha_hasta" id="fecha_hasta" value="<?php echo date("Y-m-d"); ?>"
                                class="form-control" required>
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
                            <table id="tablaConsultaConvenio" class="table table-striped table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="fuenteNunito">EMPRESA</th>
                                        <th class="fuenteNunito">ACREDITACION</th>
                                        <th class="fuenteNunito">CONCEPTO</th>
                                        <th class="fuenteNunito">$ TOTAL</th>
                                        <th class="fuenteNunito">$ DEPOSITADO</th>
                                        <!-- <th class="fuenteNunito">ACUERDO</th> -->
                                        <th class="fuenteNunito">CUOTA</th>
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
