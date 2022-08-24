@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptValidaFamiliar.js')}}"></script>
<script src="{{asset('js/scriptValidaNumeros.js')}}"></script>
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
                <a href="{{url('titulares')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-info" title="LISTADO DE TITULARES">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </a>
                <b>NUEVO FAMILIAR DE: {{$titular->nom_titular}}</b>
            </div>
            <form action="{{route('guardarFamiliar')}}" method="POST" id="familiar_create">
                <input type="hidden" name="id_titular" value="{{$titular->id_titular}} ">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fuenteNunito">APELLIDO Y NOMBRES</label>
                                <input type="text" name="nom_familiar" class="form-control"
                                    style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">DOCUMENTO </label>
                                <input type="number" name="nro_doc" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">TIPO </label>
                                <select name="tp_doc" id="tp_doc" class="form-control">
                                    @foreach($tiposDocumento as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nom_tipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">VINCULO </label>
                                <select name="vinculo" id="vinculo" class="form-control">
                                    @foreach($vinculos as $vinculos)
                                    <option value="{{$vinculos->id}}">{{$vinculos->nom_vinculo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">CUIL </label>
                                <input type="text" name="cuil" class="form-control" style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">SEXO </label>
                                <select name="sexo" id="sexo" class="form-control">
                                    <option value="1">MASCULINO</option>
                                    <option value="2">FEMENINO</option>
                                    <option selected value="3">NO DECLARA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">CONDICION </label>
                                <select name="incapacidad" id="incapacidad" class="form-control">
                                    <option selected value="0">NORMAL</option>
                                    <option value="1">CAPACIDAD DIFERENTE</option>
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">FECHA ALTA </label>
                                <input type="date" name="fec_alta" class="form-control"
                                    value="<?php echo date("Y-m-d"); ?>"
                                    max="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">FECHA NACIMIENTO </label>
                                <input type="date" name="fec_nacimiento" class="form-control"
                                    max="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fuenteNunito">DOMICILIO </label>
                                <input type="text" name="direccion" class="form-control"
                                    style="text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="fuenteNunito">OBSERVACIONES</label>
                            <input type="text" name="obs" style="text-transform: uppercase;"
                                class="form-control"></input>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                            <button class="btn btn-block btn-outline-success" type="button"
                                onclick="validaFamiliarCreate()">
                                <div class="iconos-class"><i class="fas fa-check" aria-hidden="true"></i> GUARDAR
                                    FAMILIAR </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
