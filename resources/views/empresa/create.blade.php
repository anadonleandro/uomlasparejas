@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptValidaEmpresa.js')}}"></script>
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
                <a href="{{url('empresas')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-info" title="LISTADO GENERAL DE EMPRESAS">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </a>
                <b>NUEVA EMPRESA</b>
            </div>
            <form action="{{route('guardarEmpresa')}}" method="POST" id="empresa_create">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">TIPO DE EMPRESA </label>
                                <select name="tipoEmpresa" id="tipoEmpresa" class="form-control">
                                    <option selected value="1">METALURGICA</option>
                                    <option value="2">OTRAS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">CODIGO </label>
                                <input type="number" name="cod_empresa" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fuenteNunito">RAZON SOCIAL </label>
                                <input type="text" name="nom_empresa" class="form-control"
                                    style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fuenteNunito">ACTIVIDAD </label>
                                <input type="text" name="actividad" class="form-control"
                                    style="text-transform: uppercase;">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">CUIT </label>
                                <input type="text" name="cuit" class="form-control" style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fuenteNunito">DOMICILIO </label>
                                <input type="text" name="domicilio" class="form-control"
                                    style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fuenteNunito">LOCALIDAD </label>
                                <select name="id_cpostal" id="id_cpostal" class="form-control selectpicker"
                                    data-live-search="true">
                                    @foreach($localidades as $localidad)
                                    <option value="{{$localidad->id}}">{{$localidad->cpostal." - ".$localidad->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">TELEFONO </label>
                                <input type="text" name="telefono" class="form-control"
                                    style="text-transform: uppercase;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fuenteNunito">CORREO ELECTRONICO </label>
                                <input type="text" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fuenteNunito">INICIO ACTIVIDAD </label>
                                <input type="date" name="fecha_inicio_actividad" class="form-control"
                                    value="<?php echo date("Y-m-d"); ?>"
                                    max="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fuenteNunito">FECHA ALTA </label>
                                <input type="date" name="fecha_alta" class="form-control"
                                    value="<?php echo date("Y-m-d"); ?>"
                                    max="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>">
                            </div>
                        </div>
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">CANT. OBREROS </label>
                                <input type="number" name="cantidad_obreros" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">CANT. AFILIADOS </label>
                                <input type="number" name="cantidad_afiliados" class="form-control">
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="fuenteNunito">OBSERVACIONES</label>
                            <textarea name="obs" style="text-transform: uppercase;" class="form-control"
                                rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                            <button class="btn btn-block btn-outline-success" type="button"
                                onclick="validaEmpresaCreate()">
                                <div class="iconos-class"><i class="fas fa-check" aria-hidden="true"></i> GUARDAR
                                    EMPRESA </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
