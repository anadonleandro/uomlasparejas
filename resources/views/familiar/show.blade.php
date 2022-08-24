@extends ('layouts.master')
@section ('contenido')

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota">
                <b> DETALLE DEL FAMILIAR DE: {{$nombreTitular}} </b>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fuenteNunito">APELLIDO Y NOMBRES</label>
                            <input type="text" name="nom_familiar" class="form-control" readonly
                                value="{{$familiar->nom_familiar}}" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">TIPO </label>
                            <select name="tp_doc" id="tp_doc" class="form-control" readonly>
                                    @foreach($tiposDocumento as $tipo)
                                    @if($tipo->id == $familiar->tp_doc)
                                    <option selected value="{{$tipo->id}}">{{$tipo->nom_tipo}}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">DOCUMENTO </label>
                            <input type="number" name="nro_doc" class="form-control" readonly
                                value="{{$familiar->nro_doc}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">VINCULO </label>
                            <select name="vinculo" id="vinculo" class="form-control" readonly>
                                    @foreach($vinculos as $vinc)
                                    @if($vinc->id == $familiar->vinculo)
                                    <option selected value="{{$vinc->id}}">{{$vinc->nom_vinculo}}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">CUIL </label>
                            <input type="text" name="cuil" class="form-control" style="text-transform: uppercase;"
                                readonly value="{{$familiar->cuil}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">DOMICILIO </label>
                            <input type="text" name="direccion" class="form-control" readonly
                                value="{{$familiar->direccion}}" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">LOCALIDAD </label>
                            <select name="id_cpostal" id="id_cpostal" class="form-control" readonly>
                                    @foreach($localidades as $localidad)
                                    @if($familiar->id_cpostal == $localidad->id)
                                    <option value="{{$localidad->id}}" selected>
                                        {{$localidad->cpostal." - ".$localidad->nombre}}
                                    </option>
                                    @endif
                                    @endforeach
                            </select>                            
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">TELEFONO </label>
                            <input type="text" name="telefono" class="form-control" readonly
                                value="{{$familiar->telefono}}" style="text-transform: uppercase;">
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA ALTA </label>
                            <input type="date" name="fec_alta" class="form-control" readonly
                                value="{{$familiar->fec_alta}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA NACIMIENTO </label>
                            <input type="date" name="fec_nacimiento" class="form-control" readonly
                                value="{{$familiar->fec_nacimiento}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fuenteNunito">OBSERVACIONES</label>
                        <input name="obs" style="text-transform: uppercase;" readonly value="{{$familiar->obs}}" class="form-control"></input>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
