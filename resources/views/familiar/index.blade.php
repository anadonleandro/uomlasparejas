@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptIndexFamiliar.js')}}"></script>
<br>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row justify-content-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @if(Session::has('msg'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="close" title="Cerrar">
                <span aria-hidden="true">Cerrar</span>
            </button>
            {{Session::get('msg')}}

        </div>
        @endif
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="close" title="Cerrar">
                <span aria-hidden="true">Cerrar</span>
            </button>
            {{Session::get('message')}}
        </div>
        @endif
    </div>
</div>

<div class="row ">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header color-header-nota">
                <b>BUSCAR FAMILIAR</b>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-sm-5 col-md-5 col-xs-4">
                            <div class="form-group">
                                <label for="opcion">SELECCIONE UNA OPCION</label>
                                <select name="opcion" id="opcion" class="form-control" onchange="opcionChange();"
                                    autofocus required>
                                    <option value="1">APELLIDO Y NOMBRE</option>
                                    <option value="2">NUMERO DE DOCUMENTO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5 col-sm-5 col-md-5 col-xs-4">
                            <div class="form-group">
                                <label for="parametro">INGRESE VALOR A BUSCAR </label>
                                <input type="number" class="form-control" name="paramNumero" required
                                    style="display:block" id="paramNumero">
                                <input type="text" class="form-control" name="paramTexto" required style="display:none"
                                    id="paramTexto" onkeyup="mayus(this);">

                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-2">
                            <br>
                            <label for="buscar"></label>
                            <button name="buscar" id="buscar" class="btn btn-info" type="button"
                                onclick="filtrar()">BUSCAR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mostrarTabla" s style="visibility: hidden;">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header color-header-nota">
                <div class="col-md-2">
                    <div class="class row">
                        <a href="{{url('nuevoFamiliar')}}" class="card-link float-sm-left">
                            <button class="btn btn-outline-info class texto" title="NUEVO FAMILIAR">
                                <i class="fas fa-user"></i>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="col-md-10">
                    <b>LISTADO DE FAMILIARES</b>
                </div>
            </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tablaFamiliar" class="table table-striped table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="fuenteNunito">NOMBRE</th>
                                        <th class="fuenteNunito">DOCUMENTO</th>
                                        <th class="fuenteNunito">NOMBRE DEL TITULAR</th>
                                        <th class="fuenteNunito">VINCULO</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
