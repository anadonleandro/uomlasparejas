@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>

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

<div class="row">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header color-header-nota">
                <div class="col-md-2">
                    <div class="class row">
                        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                            <div class="form-group">
                                <form action="{{url('nuevoFamiliar')}}" method="get">
                                    <button class="btn btn-outline-success" type="submit" title="NUEVO FAMILIAR">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                    <input name="id_titular" value="{{$titular->id_titular}}" type="hidden">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-10">
                    <b>LISTADO DE FAMILIARES DE: " {{$titular->nom_titular}} "</b>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="tablaListadoFamiliar" class="table table-striped table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th class="fuenteNunito">NOMBRE</th>
                                    <th class="fuenteNunito">DOCUMENTO</th>
                                    <th class="fuenteNunito">FECHA NACIMIENTO</th>
                                    <th class="fuenteNunito">VINCULO</th>
                                    <th class="fuenteNunito">OPCIONES</th>
                                </tr>
                            </thead>
                            @foreach($familiares as $familiar)
                            <tbody>
                                <tr>
                                    <td><!-- nombre -->
                                        {{$familiar->nom_familiar}}
                                    </td>

                                    <td><!-- documento-->
                                        {{$familiar->nro_doc}}
                                    </td>

                                    <td><!-- FECHA NACIMIENTO -->
                                        @if($familiar->fec_nacimiento != '0000-00-00')
                                        {{date("d-m-Y",strtotime($familiar->fec_nacimiento))}}
                                        @else
                                        SIN DATOS
                                        @endif
                                    </td>

                                    <td><!-- vinculo-->
                                        @foreach($vinculos as $vinculo)
                                        @if($vinculo->id == $familiar->vinculo)
                                        {{$vinculo->nom_vinculo}}
                                        @endif
                                        @endforeach
                                    </td>
                                    <!-- AMPLIAR -->
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3 col-xs-12">
                                                <div class="form-group">
                                                    <form action="{{url('familiar/show')}}" method="post">
                                                        @csrf
                                                        <button class="btn btn-outline-info" type="submit"
                                                            title="AMPLIAR">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                        <input type="hidden" name="id_familiar" id="id_familiar"
                                                            value="{{$familiar->id_familiar}} ">
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- Boton editar -->
                                            <div class="col-md-3 col-xs-12">
                                                <div class="form-group">
                                                    <form action="{{url('familiar/edit')}}" method="post">
                                                        @csrf
                                                        <button class="btn btn-outline-warning" type="submit"
                                                            title="MODIFICAR">
                                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                                        </button>
                                                        <input type="hidden" name="id_familiar" id="id_familiar"
                                                            value="{{$familiar->id_familiar}} ">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
