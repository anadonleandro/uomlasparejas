@extends ('layouts.master')

@section ('contenido')

<style rel="stylesheet">
    .aic {
        position: static;
        height: 200px;
        width: 600px;
        top: 40px;
        left: 27%;
        z-index: 1;
    }

    table .collapse.in {
        display: table-row;
    }

    /* fuente de las etiqueras HOME */
    .numero_etiqueta {
        font-family: Nunito;
        font-size: 25px;
    }

</style>

<script src="{{asset('/js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('/js/demo.js')}}"></script>

<br>

<div class="row">
    <div class="col-md-4">
        <a class="text-decoration-none" href="{{url('empresas')}}" title="LISTADO GENERAL DE EMPRESAS">
            <div class="card card-stats bg-secondary mb-3">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-2 col-md-2">
                            <div class="icon-big text-center icon-warning">
                                <img src="./img/fabrica.png" width="60" height="60">
                            </div>
                        </div>
                        <div class="col-6 col-md-9">
                            <div class="numbers">
                                <p class="card-category fuenteNunito" style="font-size:18px"><b> EMPRESAS</b></p>
                                <div style="text-align:center; color:Tan">
                                    <p class="numero_etiqueta" id="total_empresas">
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <br>

        <a class="text-decoration-none" href="{{url('titulares')}}" title="LISTADO GENERAL DE TITULARES">
            <div class="card card-stats bg-secondary mb-3">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-2 col-md-2">
                            <div class="icon-big text-center icon-warning">
                                <img src="./img/personas.png" width="60" height="60">
                            </div>
                        </div>
                        <div class="col-6 col-md-9">
                            <div class="numbers">
                                <p class="card-category fuenteNunito" style="font-size:18px"><b>TITULARES</b></p>
                                <div style="text-align:center; color:Tan">
                                    <p class="numero_etiqueta" id="total_titulares">
                                        <p>
                                </div>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <a class="text-decoration-none" href="{{url('nuevaDeuda')}}" title="GENERAR DEUDA">
                    <div class="card card-stats bg-secondary mb-3">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-3 col-md-3">
                                    <div class="icon-big text-center icon-warning">
                                        <img src="./img/listado.png" width="60" height="60">
                                    </div>
                                </div>
                                <div class="col-9 col-md-9">
                                    <div class="numbers">
                                        <p class="card-category fuenteNunito" style="font-size:18px"><b> DEUDAS
                                            </b></p>
                                        <div style="text-align:center; color:Tan">
                                            <p class="numero_etiqueta" id="elementos_remitidos">
                                                GENERAR
                                                <p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <a class="text-decoration-none" href="{{url('procesaDeuda')}}" title="CARGAR ARCHIVO EXCEL">
                    <div class="card card-stats bg-secondary mb-3">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-3 col-md-3">
                                    <div class="icon-big text-center icon-warning">
                                        <img src="./img/nueva.png" width="60" height="60">
                                    </div>
                                </div>
                                <div class="col-9 col-md-9">
                                    <div class="numbers">
                                        <p class="card-category fuenteNunito" style="font-size:18px"><b> ARCHIVO
                                                EXCEL</b>
                                        </p>
                                        <div style="text-align:center; color:Tan">
                                            <p class="numero_etiqueta" id="ordenes_allanamiento">
                                                PROCESAR PAGOS <p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body" style=" opacity: 0.8" class="fondo">
                <div style="text-align:center">
                    <figure>
                        <img src='img/logo_uom.png' class='aickk' width="250" height="250" />
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

@endsection
