@extends ('layouts.master')

@section ('contenido')

<br>

<div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-10">
        <div class="card border-info mb-3">
            <div class="col-md-12">
                <div class="card-header" style="text-align:center;">
                    <a href="{{url('listadoUsuarios')}}" class="card-link float-sm-left">
                        <button class="btn btn-outline-primary" type="submit">
                            <div class="iconos-class"><i class="fa fa-reply" aria-hidden="true"></i> VOLVER </div>
                        </button>
                    </a>
                    <b> NUEVO OPERADOR DEL SISTEMA </b>
                </div>
            </div>
            <div class="card-body">
                <form action="{{url('guardar/usuario')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">APELLIDO Y NOMBRE</label>
                                <input type="text" name="name" class="form-control" style="text-transform: uppercase;" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="roll">ATRIBUTOS</label>
                                <select class="form-control" name="roll" required>
                                    <option selected disabled>SELECCIONE</option>
                                    <option value="1">ADMINISTRADOR</option>
                                    <option value="2">CONSULTAS GENERALES</option>
                                    <option value="3">CARGAS/CONSULTAS GRALES</option>
                                    <option value="4">GESTION DEUDAS/PAGOS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="estado">ESTADO</label>
                                <select class="form-control" name="estado" required>
                                    <option selected disabled>SELECCIONE</option>
                                    <option value="1">ACTIVO</option>
                                    <option value="2">INACTIVO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>EMAIL</label>
                            <div class="input-group mb-3">
                                <input type="text" name="email" class="form-control" aria-label="Recipient's username"
                                 aria-describedby="basic-addon2" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">@uom.com</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">DOCUMENTO</label>
                                <input type="number" name="dni" class="form-control" required>
                            </div>
                        </div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="obs">OBSERVACIONES</label>
                                <textarea style="text-transform: uppercase;" class="form-control" name="obs" rows="3" maxlength="300">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button type="submit" class="btn btn-block btn-outline-success">
                                <i class="fas fa-check-square"></i> GUARDAR
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-1">
    </div>
</div>

@endsection