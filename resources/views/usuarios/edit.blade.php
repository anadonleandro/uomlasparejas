@extends ('layouts.master')

@section ('contenido')

<br>

<div class="row">
    <div class="col-md-6">
        <div class="card border-info mb-3">
            <div class="col-md-12">
                <div class="card-header" style="text-align:center;">
                    <a href="{{route('listadoUsuarios')}}" class="card-link float-sm-left">
                        <button class="btn btn-outline-primary" type="submit">
                            <div class="iconos-class"><i class="fa fa-reply" aria-hidden="true"></i> VOLVER </div>
                        </button>
                    </a>
                    <b> EDITAR OPERADOR DEL SISTEMA</b>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <form action="{{url('update/usuario')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">APELLIDO Y NOMBRES</label>
                                    <input type="text" name="name" value="{{ $usuario->name}}" class="form-control" style="text-transform: uppercase;" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="roll">ATRIBUTOS</label>
                                    <select class="form-control" name="roll" required>
                                        @if ($usuario->roll == 1)
                                        <option value="1" selected>ADMINISTRADOR</option>
                                        <option value="2">CONSULTAS GENERALES</option>
                                        <option value="3">CARGAS/CONSULTAS GRALES</option>
                                        <option value="4">GESTION DEUDAS/PAGOS</option>
                                        @elseif ($usuario->roll == 2)
                                        <option value="1">ADMINISTRADOR</option>
                                        <option value="2" selected>CONSULTAS GENERALES</option>
                                        <option value="3">CARGAS/CONSULTAS GRALES</option>
                                        <option value="4">GESTION DEUDAS/PAGOS</option>
                                        @elseif ($usuario->roll == 3)
                                        <option value="1">ADMINISTRADOR</option>
                                        <option value="2">CONSULTAS GENERALES</option>
                                        <option value="3" selected>CARGAS/CONSULTAS GRALES</option>
                                        <option value="4">GESTION DEUDAS/PAGOS</option>
                                        @else
                                        <option value="1">ADMINISTRADOR</option>
                                        <option value="2">CONSULTAS GENERALES</option>
                                        <option value="3">CARGAS/CONSULTAS GRALES</option>
                                        <option value="4" selected>GESTION DEUDAS/PAGOS</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="estado">ESTADO</label>
                                    <select class="form-control" name="estado" required>
                                        @if ($usuario->estado == 1)
                                        <option value="1" selected>ACTIVO</option>
                                        <option value="2">INACTIVO</option>
                                        @else
                                        <option value="1">ACTIVO</option>
                                        <option value="2" selected>INACTIVO</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>EMAIL</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="email" value="{{substr( $usuario->email ,0,-8) }}" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">@uom.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">DOCUMENTO</label>
                                    <input type="number" name="dni" value="{{$usuario->dni}}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="obs">OBSERVACIONES</label>
                                    <textarea style="text-transform: uppercase;" class="form-control" name="obs" rows="3" maxlength="300">
                                    {{$usuario->obs}}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $usuario->id}}" class="form-control">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-warning btn-block"><i class="fas fa-check-square"></i> GUARDAR</button>
                                    <button class="btn btn-outline-danger btn-block" type="reset"><i class="fas fa-times"></i>
                                        CANCELAR</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="text-align: center;">
                <b>BLANQUEAR CONTRASEÑA</b>
            </div>
            <div class="card-body">
                <b>
                    <p style="color: black; text-align:center; font-size: 18px">
                        <i> La nueva contraseña será el Documento (D.N.I.) del operador </i>
                    </p>
                </b>
                <form action="{{url('usuario/password/blanquear')}}" method="GET">
                    <input type="hidden" name="id" id=id value="{{$usuario->id}}">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-success btn-block"><i class="fas fa-check"></i>
                                    PROCESAR BLANQUEO
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection