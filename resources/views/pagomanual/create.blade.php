@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptValidaPagoManual.js')}}"></script>
<script src="{{asset('sweetalert/sweetalert.js') }}"></script>

<style type="text/css">
    label.error {
        height: 17px;
        padding: 1px 1px 0px 1px;
        font-size: 15px;
        color: #DBA901;
    }

</style>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota" style="background-color: #be9096;">
                <a href="{{url('pagosManuales')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-info" title="LISTADO DE PAGOS MANUALES">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </a>
                <b>IMPUTACION MANUAL DE PAGO</b>
            </div>
            <form action="/guardaPagoManual" method="POST" id="pago_manual_create">
                @csrf
                <div class="class card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fuenteNunito">CONCEPTO </label>
                                    <select name="tipo_cuenta" id="tipo_cuenta" class="form-control">
                                        <option value="1">OBRA SOCIAL</option>
                                        <option value="2">2,5% SINDICAL</option>
                                        <option value="3">SEGURO</option>
                                        <option value="4">2% SINDICAL</option>
                                        <option value="5">ACUERDO DE PAGOS</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="fuenteNunito">EMPRESA</label>
                                    <select name="cod_empresa" id="cod_empresa" class="form-control selectpicker"
                                        data-live-search="true">
                                        @foreach($empresas as $empresa)
                                        <option value="{{$empresa->cod_empresa}}">
                                            {{$empresa->cod_empresa." - ".$empresa->nom_empresa}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fuenteNunito">FECHA DE PAGO </label>
                                    <input type="date" name="fecha_deposito" class="form-control"
                                        value="<?php echo date("Y-m-d"); ?>"
                                        max="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="fuenteNunito">PERIODO</label>
                                    <input type="month" name="periodo" id="periodo" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="fuenteNunito">CANT. AFILIADOS </label>
                                    <input type="number" name="cant_afil_titulares" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="fuenteNunito">$ BASE REMUN. </label>
                                    <input type="number" name="ipte_total_remuneracion" value="0" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="fuenteNunito">$ DEPOSITADO </label>
                                    <input type="number" name="ipte_depositado" value="0" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="fuenteNunito">N° ACUERDO </label>
                                    <input type="number" name="nro_acuerdo" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="fuenteNunito">N° CUOTA </label>
                                    <input type="number" name="nro_cuota" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-muted">
                        <div class="row">
                            <div class="col-md-12" style="text-align: right;">
                                <button class="btn btn-block btn-outline-success" type="button"
                                    onclick="validaPagoManualCreate()">
                                    <div class="iconos-class"><i class="fas fa-check" aria-hidden="true"></i>
                                        IMPUTACION MANUAL </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
