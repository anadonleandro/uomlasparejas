@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/muestra_password.js')}}"></script>
<br>
<div class="row">
    <div class="col-md-8">
        <!-- MANEJO DE ERRORES -->
        @if(\Session::has('error_password_actual'))
        <p class="alert alert-danger">
            {{ \Session::get('error_password_actual') }}
            <button type="button" class="close" title="CERRAR" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">CERRAR</span>
            </button>
        </p>
        @endif
        @if(\Session::has('error_validacion'))
        <p class="alert alert-danger">
            {{ \Session::get('error_validacion') }}
            <button type="button" class="close" title="CERRAR" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">CERRAR</span>
            </button>
        </p>
        @endif
        <!--   FIN MANEJO ERRORES -->
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
        <div class="card border-info mb-3">
            <div class="col-md-12">
                <div class="card-header" style="text-align:center;">
                    <b> CAMBIO DE CONTRASEÑA DE: <i> {{$user->name}} </i></b>
                </div>
            </div>
            <form action="{{url('usuario/cambiarpass')}}" method="post">
                @csrf
                <div class="card-body">

                    <div class="row">
                        <label class="col-md-4 col-form-label">CONTRASEÑA ACTUAL</label>
                        <div class="col-md-8">
                            <div class="input-group mb-3" id="show_hide_password-a">
                                <input type="password" name="password_actual" class="form-control" aria-describedby="basic-addon2" required>
                                <div class="input-group-addon">
                                    <a class="input-group-text" id="basic-addon2"><i class="fa fa-eye-slash" aria-hidden="true" style="height: 22px;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-md-4 col-form-label">NUEVA CONTRASEÑA</label>
                        <div class="col-md-8">
                            <div class="input-group mb-3" id="show_hide_password-b">
                                <input type="password" name="password" id="password" class="form-control" aria-describedby="basic-addon2" required>
                                <div class="input-group-addon">
                                    <a class="input-group-text" id="basic-addon2"><i class="fa fa-eye-slash" aria-hidden="true" style="height: 22px;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-md-4 col-form-label">REINGRESE CONTRASEÑA</label>
                        <div class="col-md-8">
                            <div class="input-group mb-3" id="show_hide_password-c">
                                <input type="password" name="password2" id="password2" class="form-control" aria-describedby="basic-addon2" required>
                                <div class="input-group-addon">
                                    <a class="input-group-text" id="basic-addon2"><i class="fa fa-eye-slash" aria-hidden="true" style="height: 22px;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-muted" style="color:Indianred">
                                <i> - La contraseña debe contener entre 6 y 12 caracteres, al menos una Mayúscula y un Número </i>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p id="idMsg" hidden class="alert-danger"> Las contraseÃ±as no coinciden </p>
                            <button type="submit" id="btnAceptar" class="btn btn-outline-info btn-round btn-block"><i class="fas fa-check"></i>
                                {{ __('PROCESAR CAMBIO') }}</button>
                            <button class="btn btn-outline-danger btn-block" type="reset"><i class="fas fa-close"></i>
                                CANCELAR</button>
                        </div>
                        <input type="hidden" name="id" id="id" value="{{$user->id}}">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-2">
    </div>
</div>
<script>
    $("#password2").keyup(function() {
        var pass2 = $("#password2").val();
        var pass1 = $("#password").val();

        if (pass1 == '' || pass2 == '') {
            $("#btnAceptar").prop("disabled", true);
            $("#idMsg").attr("hidden", false);
        } else {
            if (pass1 == pass2) {
                $("#btnAceptar").prop("disabled", false);
                $("#idMsg").attr("hidden", true);
            } else { // las contraseÃ±as no coinciden 
                $("#btnAceptar").prop("disabled", true);
                $("#idMsg").attr("hidden", false);
            }
        }
    });

    $("#password").keyup(function() {
        var pass2 = $("#password2").val();
        var pass1 = $("#password").val();

        if (pass1 == '' || pass2 == '') {
            $("#btnAceptar").prop("disabled", true);
            $("#idMsg").attr("hidden", false);
        } else {
            if (pass1 == pass2) {
                $("#btnAceptar").prop("disabled", false);
                $("#idMsg").attr("hidden", true);
            } else { // las contraseÃ±as no coinciden 
                $("#btnAceptar").prop("disabled", true);
                $("#idMsg").attr("hidden", false);
            }
        }
    });
</script>


@endsection