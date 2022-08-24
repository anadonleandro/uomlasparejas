@extends ('layouts.master')

@section ('contenido')

@if (Session::has('success'))
<div class='bg-info' style='padding: 20px'>
    {{Session::get('success')}}
</div>
<hr />
@endif

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="texto">
                <div class="col-md-12">
                    <div class="card-header" style="text-align:center;">
                        <a href="{{url('usuarios/create')}}" class="card-link float-sm-left">
                            <button class="btn btn-outline-success" title="Nuevo Usuario">NUEVO USUARIO
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </a>
                        <b> OPERADORES DEL SISTEMA </b>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table  table-hover">
                            <thead>
                                <th>NOMBRE</th>
                                <th>CORREO</th>
                                <th>FECHA ALTA</th>
                                <th>ATRIBUTOS</th>
                                <th>ESTADO</th>
                                <th>OPCIONES</th>
                            </thead>
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <!-- Apellido y Nombre -->
                                <td>
                                    {{ $usuario->name }}
                                </td>
                                <!-- correo -->
                                <td>
                                    {{ $usuario->email }}
                                </td>

                                <!-- fecha de Alta -->
                                <td>
                                    {{date("d-m-Y",strtotime($usuario->fec_alta)) }}
                                </td>
                                <!-- Atributos -->
                                <td>
                                    @switch ($usuario->roll)
                                    @case (1)
                                        ADMINISTRADOR
                                        @break
                                    @case (2)
                                        CONSULTAS GENERALES
                                        @break
                                    @case (3)
                                        CARGAS/CONSULTAS GRALES
                                        @break
                                    @case (4)
                                        GESTION DEUDAS/PAGOS
                                        @break
                                    @endswitch
                                </td>
                                <!-- Estado -->
                                <td>
                                    @if ($usuario->estado == 1)
                                    ACTIVO
                                    @else
                                    INACTIVO
                                    @endif
                                </td>

                                <td style="text-align: center; width: 18%;">
                                    @if ($usuario->id != 1)
                                    <!--USUARIO DISTINTO AL ADMINISTRADOR DIP -->
                                    <div class="row">
                                        <!-- Boton editar -->
                                        <div class="col-md-3 col-xs-12">
                                            <div class="form-group">
                                                <form action="{{url('editar/usuario')}}" method="post">
                                                    @csrf
                                                    <button class="btn btn-outline-warning" type="submit" title="MODIFICAR">
                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </button>
                                                    <input type="hidden" name="id" id="id" value="{{$usuario->id}} ">
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Boton Imprimir -->
                                        <!-- <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                            <div class="form-group">
                                                <form action="{{url('usuariopdf')}}" method="post" target="_blank">
                                                    @csrf
                                                    <button class="btn btn-outline-danger" type="submit" title="IMPRIMIR">
                                                        <i class="fa fa-file-pdf"></i>
                                                    </button>
                                                    <input name="id" value="{{$usuario->id}}" type="hidden">
                                                </form>
                                            </div>
                                        </div> -->
                                    </div>
                                    @else
                                    <!--USUARIO  ADMINISTRADOR UOM -->
                                    <div class="row">
                                        <!-- Boton editar -->
                                        <div class="col-md-3 col-xs-12">
                                            <div class="form-group">
                                                <form action="{{url('editar/usuario')}}" method="post">
                                                    @csrf
                                                    <button disabled class="btn btn-outline-warning" type="submit" title="MODIFICAR">
                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </button>
                                                    <input type="hidden" name="id" id="id" value="{{$usuario->id}} ">
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Boton Imprimir -->
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection