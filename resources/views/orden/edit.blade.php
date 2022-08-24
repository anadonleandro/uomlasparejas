@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptValidaOrden.js')}}"></script>
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
                    <a href="{{url('ordenes')}}" class="card-link float-sm-left">
                        <button class="btn btn-outline-info class texto" title="LISTADO GENERAL DE ORDENES">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </a>
                    <b>MODIFICAR ESTADO DE LA ORDEN - N° DE BONO: {{$orden->id}} </b>
                </div>
            </div>
            <form action="{{url('editOrden')}}" method="post" id="orden_edit">
                <input type="hidden" name="id" value="{{$orden->id}} ">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="fuenteNunito">ESTADO </label>
                                <select name="estado" class="form-control" required>
                                    @if ($orden->estado == 1)
                                    <option selected value="1">ACTIVA</option>
                                    <option value="2">PASIVA</option>
                                    @else
                                    <option value="1">ACTIVA</option>
                                    <option selected value="2">PASIVA</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="fuenteNunito">INGRESE MOTIVO DEL CAMBIO </label>
                                <input type="text" name="obs_anulo" style="text-transform:uppercase;" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                            <button class="btn btn-block btn-outline-success" type="button" onclick="validaOrdenEdit()">
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