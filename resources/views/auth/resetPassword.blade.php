@extends('layouts.app')

<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/muestra_password.js')}}"></script>

@section('content')

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-2">
            <div class="card-header" style="background-color:#EC7762;">
                <h4>
                    <div class="login-logo" style="text-align:center">
                        <img src='../public/img/escudopol.jpg' ; style="width: 50px; height: 50px;"
                            class="img-thumbnail">
                        SISTEMA GESTION CUSTODIAS
                        <h5><small style="color:white;">CONTRASEÑA VENCIDA</small></h5>
                    </div>
                </h4>
            </div>
            <div class="row justify-content-center">
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(\Session::has('message'))
                    <p class="alert alert-info">
                        {{ \Session::get('message') }}
                    </p>
                    @endif

                    @if(\Session::has('error_validacion'))
                    <p class="alert alert-danger">
                        {{ \Session::get('error_validacion') }}
                        <button type="button" class="close" title="CERRAR" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </p>
                    @endif

                    <form method="POST" action="{{url('usuario/resetpass')}}">
                        @csrf
                        <div class="row">
                            <label class="col-md-4 col-form-label"><b> NUEVA CONTRASEÑA </b></label>
                            <div class="col-md-7">
                                <div class="input-group mb-3" id="show_hide_password-b">
                                    <input type="password" name="password" id="password" class="form-control"
                                        aria-describedby="basic-addon2" required>
                                    <div class="input-group-append" style="height: 9mm">
                                        <a class="input-group-text" id="basic-addon2"><i class="fa fa-eye-slash"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input name="id" type="hidden" class="form-control" value="{{$usuario->id}}">
                        <div class="row">
                            <label class="col-md-4 col-form-label"> <b>REINGRESE CONTRASEÑA</b></label>
                            <div class="col-md-7">
                                <div class="input-group mb-3" id="show_hide_password-c">
                                    <input type="password" name="password2" id="password2" class="form-control"
                                        aria-describedby="basic-addon2" required>
                                    <div class="input-group-append" style="height: 9mm">
                                        <a class="input-group-text" id="basic-addon2"><i class="fa fa-eye-slash"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="class row">
                            <div class="col-md-12">
                                <p class="text-muted">
                                    <i> - La contraseña debe contener entre 6 y 12 caracteres, al menos una Mayúscula
                                        y un Número </i>
                                </p>
                            </div>
                        </div>
                        <div style="text-align:center">
                            <p id="idMsg" hidden class="alert-danger"> Las contraseñas no coinciden </p>
                            <input type="submit" style="height: 11mm" id="btnAceptar" disabled class="btn btn-primary btn-block"
                                value="ACEPTAR">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#password2").keyup(function () {
        var pass2 = $("#password2").val();
        var pass1 = $("#password").val();

        if (pass1 == '' || pass2 == '') {
            $("#btnAceptar").prop("disabled", true);
            $("#idMsg").attr("hidden", false);
        } else {
            if (pass1 == pass2) {
                $("#btnAceptar").prop("disabled", false);
                $("#idMsg").attr("hidden", true);
            } else {
                $("#btnAceptar").prop("disabled", true);
                $("#idMsg").attr("hidden", false);
            }
        }
    });

    $("#password").keyup(function () {
        var pass2 = $("#password2").val();
        var pass1 = $("#password").val();
        if (pass1 == '' || pass2 == '') {
            $("#btnAceptar").prop("disabled", true);
            $("#idMsg").attr("hidden", false);
        } else {
            if (pass1 == pass2) {
                $("#btnAceptar").prop("disabled", false);
                $("#idMsg").attr("hidden", true);
            } else {
                $("#btnAceptar").prop("disabled", true);
                $("#idMsg").attr("hidden", false);
            }
        }
    });

</script>

@endsection
