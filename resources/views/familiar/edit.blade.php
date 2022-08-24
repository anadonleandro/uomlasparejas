@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script> 
<script src="{{asset('js/scriptValidaFamiliar.js')}}"></script>
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
            <div class="class texto">
                <div class="card-header color-header-nota" style="background-color: #be9096;">
                   
                    <b>MODIFICAR FAMILIAR DE: {{$nombreTitular}}</b>
                </div>
            </div>
            <form action="{{url('editFamiliar')}}" method="post" id="familiar_edit">
                <input type="hidden" name="id_familiar" value="{{$familiar->id_familiar}} ">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fuenteNunito">APELLIDO Y NOMBRES</label>
                                <input type="text" name="nom_familiar" class="form-control" value="{{$familiar->nom_familiar}}" style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">TIPO </label>
                                <select name="tp_doc" id="tp_doc" class="form-control">
                                    @foreach($tiposDocumento as $tipo)
                                    @if($tipo->id == $familiar->tp_doc)
                                    <option selected value="{{$tipo->id}}">{{$tipo->nom_tipo}}</option>
                                    @else
                                    <option value="{{$tipo->id}}">{{$tipo->nom_tipo}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">DOCUMENTO </label>
                                <input type="number" name="nro_doc" class="form-control" value="{{$familiar->nro_doc}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">VINCULO </label>
                                <select name="vinculo" id="vinculo" class="form-control">
                                    @foreach($vinculos as $vinc)
                                    @if($vinc->id == $familiar->vinculo)
                                    <option selected value="{{$vinc->id}}">{{$vinc->nom_vinculo}}</option>
                                    @else
                                    <option value="{{$vinc->id}}">{{$vinc->nom_vinculo}}</option>
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
                                <input type="text" name="cuil" class="form-control" style="text-transform: uppercase;" value="{{$familiar->cuil}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fuenteNunito">DOMICILIO </label>
                                <input type="text" name="direccion" class="form-control" value="{{$familiar->direccion}}" style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="fuenteNunito">LOCALIDAD </label>
                                <select name="id_cpostal" id="id_cpostal" class="form-control selectpicker" data-live-search="true">
                                    @foreach($localidades as $localidad)
                                    @if($familiar->id_cpostal == $localidad->id)
                                    <option value="{{$localidad->id}}" selected>
                                        {{$localidad->cpostal." - ".$localidad->nombre}}
                                    </option>
                                    @else
                                    <option value="{{$localidad->id}}">{{$localidad->cpostal." - ".$localidad->nombre}}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">TELEFONO </label>
                                <input type="text" name="telefono" class="form-control" value="{{$familiar->telefono}}" style="text-transform: uppercase;">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fuenteNunito">FECHA ALTA </label>
                                <input type="date" name="fec_alta" class="form-control" value="{{$familiar->fec_alta}}" max="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="fuenteNunito">FECHA NACIMIENTO </label>
                                <input type="date" name="fec_nacimiento" class="form-control" value="{{$familiar->fec_nacimiento}}" max="<?php echo date("Y-m-d", strtotime(date("Y-m-d"))); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="fuenteNunito">OBSERVACIONES</label>
                            <input name="obs" style="text-transform: uppercase;" class="form-control" value="{{$familiar->obs}}"></input>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                            <button class="btn btn-block btn-outline-success"  type="button" onclick="validaFamiliarEdit()">
                                <div class="iconos-class"><i class="fas fa-check" aria-hidden="true"></i> GUARDAR
                                    MODIFICACIONES </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection