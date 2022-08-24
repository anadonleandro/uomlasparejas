@extends ('layouts.master')

@section ('contenido')
<!-- <script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>-->
<script src="{{asset('js/scriptValidaTitular.js')}}"></script>
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
                <b>NUEVO TITULAR</b>
            </div>
            <form action="{{route('guardarTitular')}}" method="POST" id="titular_create">
                @csrf
                <div class="card-body">
                    <div class="row">
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
                                <label class="fuenteNunito">CUIL </label>
                                <input type="text" name="cuil" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fuenteNunito">APELLIDO Y NOMBRES</label>
                                <input type="text" name="nom_titular" class="form-control"
                                    style="text-transform: uppercase;">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fuenteNunito">DOMICILIO </label>
                                <input type="text" name="direccion" class="form-control"
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fuenteNunito">CORREO ELECTRONICO </label>
                                <input type="email" name="mail" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">CBU </label>
                                <input type="number" name="cbu" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                                <label class="fuenteNunito">ESTADO CIVIL </label>
                                <select name="ecivil" id="ecivil" class="form-control">
                                    @foreach($estadosCiviles as $estado)
                                    <option value="{{$estado->id}}">
                                        {{$estado->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">CATEGORIA </label>
                                <select name="id_categoria" id="id_categoria" class="form-control">
                                    @foreach($categorias as $categoria)
                                    <option value="{{$categoria->id}}">
                                        {{$categoria->nom_categoria}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">FECHA NACIMIENTO </label>
                                <input type="date" name="fec_nacimiento" class="form-control"
                                    max="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">FECHA ALTA </label>
                                <input type="date" name="fec_alta" class="form-control"
                                    max="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>">
                            </div>
                        </div>

                    </div>

                    <div class="class row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">AFILIADO A </label>
                                <select name="afiliado_a" id="afiliado_a" class="form-control">
                                    <option selected disabled>Seleccione...</option>
                                    <option value="1">OBRA SOCIAL</option>
                                    <option value="2">GREMIO</option>
                                    <option value="3">O. SOCIAL Y GREMIO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fuenteNunito">EMPRESA </label>
                                <select name="id_empresa" id="id_empresa" class="form-control selectpicker"
                                    data-live-search="true">
                                    @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id_empresa}}">
                                        {{$empresa->cod_empresa." - ".$empresa->nom_empresa}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="fuenteNunito">OBSERVACIONES</label>
                            <input type="text" class="form-control" name="obs" style="text-transform: uppercase;"
                                class="form-control"></input>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                            <button class="btn btn-block btn-outline-success" type="button"
                                onclick="validaTitularCreate()">
                                <div class="iconos-class"><i class="fas fa-check" aria-hidden="true"></i> GUARDAR
                                    TITULAR </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
