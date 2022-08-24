@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptValidaDeuda.js')}}"></script>
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
                <!-- <a href="{{url('empresas')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-info" title="LISTADO GENERAL DE EMPRESAS">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </a> -->
                <b>NUEVA DEUDA</b>
            </div>
            <form action="{{route('guardarDeuda')}}" method="POST" id="deuda_create">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fuenteNunito">EMPRESA DESDE </label>
                                <select name="id_empresa_desde" id="id_empresa_desde" class="form-control selectpicker"
                                    data-live-search="true">
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
                                <label class="fuenteNunito">EMPRESA HASTA </label>
                                <select name="id_empresa_hasta" id="id_empresa_hasta" class="form-control selectpicker"
                                    data-live-search="true">
                                    @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id_empresa}}">
                                        {{$empresa->cod_empresa." - ".$empresa->nom_empresa}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fuenteNunito">CONCEPTO </label>
                                <select name="tipo_cuenta[]" id="tipo_cuenta" class="form-control selectpicker"
                                    multiple="multiple">
                                    <option value="1">OBRA SOCIAL</option>
                                    <option value="2">2,5% SINDICAL</option>
                                    <option value="3">SEGURO</option>
                                    <option value="4">2% SINDICAL</option>
                                    <option value="5">ACUERDO DE PAGOS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fuenteNunito">PERIODO </label>
                                <input type="month" name="periodo" class="form-control"
                                    value="<?php echo date("Y-m"); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fuenteNunito">FECHA VTO. </label>
                                <input type="date" name="fecha_vto" class="form-control"
                                    value="<?php echo date("Y-m-d"); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                            <button class="btn btn-block btn-outline-success" type="button"
                                onclick="validaDeudaCreate()">
                                <div class="iconos-class"><i class="fas fa-check" aria-hidden="true"></i> GENERAR
                                    DEUDA </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
