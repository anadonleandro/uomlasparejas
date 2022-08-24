@extends ('layouts.master')
@section ('contenido')

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota">
                <a href="{{url('titulares')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-primary class texto" title="LISTADO DE TITULARES">
                        <i class="fas fa-long-arrow-alt-left"></i>
                    </button>
                </a>
                <b> DETALLE DEL TITULAR </b>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">DOCUMENTO </label>
                            <input type="number" name="nro_doc" class="form-control" value="{{$titular->nro_doc}}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">TIPO </label>
                            <input type="text" name="nro_doc" class="form-control" value="{{$tipoDocumento->nom_tipo}}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">CUIL </label>
                            <input type="text" name="cuil" class="form-control" value="{{$titular->cuil}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">APELLIDO Y NOMBRES</label>
                            <input type="text" name="nom_titular" class="form-control"
                                style="text-transform: uppercase;" value="{{$titular->nom_titular}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">TELEFONO </label>
                            <input type="text" name="telefono" class="form-control" style="text-transform: uppercase;"
                                value="{{$titular->telefono}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="fuenteNunito">DOMICILIO </label>
                            <input type="text" name="direccion" class="form-control" style="text-transform: uppercase;"
                                value="{{$titular->direccion}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">LOCALIDAD </label>
                            <input type="text" name="cpostal" class="form-control" style="text-transform: uppercase;"
                                value="{{$localidad}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="fuenteNunito">CORREO ELECTRONICO </label>
                            <input type="email" name="mail" class="form-control" value="{{$titular->mail}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">CBU </label>
                            <input type="number" name="cbu" class="form-control" value="{{$titular->cbu}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">SEXO </label>
                            @if ($titular->sexo == 1)
                            <input type="text" name="cbu" class="form-control" value="MASCULINO" readonly>
                            @elseif($titular->sexo == 2)
                            <input type="text" name="cbu" class="form-control" value="FEMENINO" readonly>
                            @else
                            <input type="text" name="cbu" class="form-control" value="NO DECLARA" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">CONDICION </label>
                            @if ($titular->incapacidad == 0)
                            <input type="text" name="cbu" class="form-control" value="NORMAL" readonly>
                            @elseif($titular->incapacidad == 1)
                            <input type="text" name="cbu" class="form-control" value="CAPACIDAD DIFERENTE" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">ESTADO CIVIL </label>
                            <input type="text" name="cbu" class="form-control" value="{{$estadoCivil->nombre}}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">CATEGORIA </label>
                            <input type="text" name="cbu" class="form-control" value="{{$categoria->nom_categoria}}"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA NACIMIENTO </label>
                            <input type="date" name="fec_nacimiento" class="form-control"
                                value="{{$titular->fec_nacimiento}}" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA ALTA </label>
                            <input type="date" name="fec_alta" class="form-control" value="{{$titular->fec_alta}}"
                                readonly>
                        </div>
                    </div>

                </div>

                <div class="class row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">AFILIADO A </label>
                            @if ($titular->afiliado_a == 1)
                            <input type="text" name="afiliado_a" class="form-control" value="OBRA SOCIAL" readonly>
                            @elseif($titular->afiliado_a == 2)
                            <input type="text" name="afiliado_a" class="form-control" value="GREMIO" readonly>
                            @else
                            <input type="text" name="afiliado_a" class="form-control" value="OBRA SOCIAL Y GREMIO" readonly>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">EMPRESA </label>
                            <input type="text" name="fec_alta" class="form-control" value="{{$empresa}}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="fuenteNunito">OBSERVACIONES</label>
                        <input type="text" class="form-control" name="obs" value="{{$titular->obs}}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
