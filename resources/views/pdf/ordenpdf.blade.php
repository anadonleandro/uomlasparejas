<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OrdenDeConsulta.pdf</title>
</head>
<!--ESTILO...................................................................................-->
<style>
    html {
        min-height: 100%;
        position: relative;
    }

    body {
        margin: 0;
        margin-bottom: 40px;
    }

    header {
        position: fixed;
        left: 0px;
        top: 20px;
        right: 0px;
        height: 40px;
        background-color: white;
    }

    body {
        font-family: sans-serif;
        margin: 30mm 1mm 5mm 1mm;
        top: 310px;
    }

    body tr {
        font-size: 12px;
    }

    body p {
        text-align: justify;
        font-size: 15px;
    }

    .titulo {
        text-align: center;
        font-size: 20px;
        text-decoration: underline;
    }

    body th {
        font-size: 16px;
    }

    @page {
        /*margin: 95px 70px;*/
        margin: -5px 50;
        margin-bottom: 0px;
    }

    footer {
        position: fixed;
        left: 0px;
        bottom: -40px;
        right: 0px;
        height: 40px;
        border-bottom: 2px solid #ddd;
    }

    footer .page:after {
        content: counter(page);
    }

    footer table {
        width: 100%;
    }

    footer p {
        text-align: center;
    }

    footer .izq {
        text-align: center;
    }

    #watermarkkkkkk {
        position: fixed;
        font-size: 70px;
        top: 45%;
        width: 100%;
        text-align: center;
        opacity: .1;
        transform: rotate(-0deg);
        transform-origin: 50% 50%;
        z-index: -1000;
    }

    #watermark {
        position: fixed;
        font-size: 110px;
        top: 45%;
        width: 100%;
        text-align: center;
        opacity: .1;
        transform: rotate(-45deg);
        transform-origin: 50% 50%;
        z-index: -1000;
    }

    .interlineado {
        line-height: 50%;
        font-size: 11px;
    }

    .color-header-nota {
        font-size: 11px;
    }

    .tabla-detalle th {
        font-size: 10px;
    }

    .redondo {
        border: 1px solid black;
        border-radius: 10px;
    }

    .tabla-detalle tr {
        font-size: 10px;
    }

    .footer-detalle p {
        font-size: 10px;
    }

    .rectangulo-detalle {
        text-align: left;
        width: 640px;
        height: 15px;
        border: 1px solid #000;
        background-color: lightslategrey;
    }
</style>
<!--ESTILO...................................................................................-->

<!--HEADER...................................................................................-->

<header>
    <hr />
    <table>
        <tr>
            <td style="text-align:left">
                <img src="img/logo_uom.png" class="logo" width="30" height="30" />
            </td>
            <td style="text-align: left; width: 185px;">
                <b style="font-size: 16px;">O.S.U.O.M.R.A.</b>
            </td>
            <td style="text-align: left; width: 280px;">
                <b style="font-size: 15px;">*** 181 - Seccional Las Parejas ***</b>
            </td>
            <td style="text-align: right; width: 200%px;">
                <b style="font-size: 11px">Fecha:
                    {{$fecha_hora->format('d / m / Y')." - ".$fecha_hora->format('H:m')}}</b>
            </td>
        </tr>

        <tr>
            <td style="text-align: left;">
            </td>
            <td style="text-align: left; width: 185px;">
                <b style="font-size: 11px">SECCIONAL LAS PAREJAS</b>
            </td>
            <td style="text-align: left; width: 280px;">
            </td>
            <td style="text-align: right; width: 200%x;">
                <b style="font-size: 11px">N° Bono: {{$orden->id}}</b>
            </td>
        </tr>
    </table>
    <hr />
</header>

<!--BODY.....................................................................................-->

<body>
    <section>
        <table>
            <tr>
                <td class="redondo" style="text-align: left; width: 500px;">
                    <p class="interlineado"><b>Tipo Estudio:</b> {{$tipoEstudio->nom_tipo}} </p>
                    <p class="interlineado"><b>Fecha Estudio:</b> {{date("d / m / Y",strtotime($orden->fecha_estudio))}}
                    </p>
                    <p class="interlineado"><b>Fecha Realización:</b>
                        @if (isset($orden->fecha_realizacion))
                        {{date("d / m / Y",strtotime($orden->fecha_realizacion))}}
                        @else
                        <i>SIN DATOS</i>
                        @endif
                    </p>
                    <p class="interlineado"><b>Solicitante:</b> {{$orden->solicitante}}</p>
                </td>
                <td class="redondo">
                    <div style="text-align: center;"><b> PENDIENTE</b>
                    </div>
                    <p class="interlineado"><b>Operador:</b> {{$usuario->name}}</p>
                </td>
            </tr>
        </table>
        <!-- <br> -->
        <table>
            <tr>
                <td style="text-align: left; width: 300px;">
                    <p class="interlineado"><b>Titular:</b> {{$titular->nom_titular}} - <i> (TITULAR) </i></p>
                    <p class="interlineado"><b>Tipo y Nro de Doc:</b>
                        {{$tipoDocumentoTitular->nom_tipo. " - ". $dniTitular}}
                    </p>
                </td>
                <td style="text-align: left; width: 195px;">
                    <p class="interlineado"><b></b></p>
                    <p class="interlineado"><b>Edad:</b>
                        @if ($edadTitular != "SIN DATOS")
                        {{$edadTitular}} AÑOS
                        @else
                        <i>{{$edadTitular}}</i>
                        @endif
                    </p>
                </td>
                <td class="redondo">
                    <div style="text-align: center;"><b> FECHA
                            VENCIMIENTO</b>
                        <div style="text-align:center"><b> {{date("d / m / Y",strtotime($vencimiento))}}</b></div>
                    </div>

                </td>
            </tr>
            @if ($orden->tipo_beneficiario == 0)
            <tr>
                <td style="text-align: left; width: 300px;">
                    <p class="interlineado"><b>Beneficiario:</b> {{$titular->nom_titular}} - <i> (TITULAR) </i></p>
                    <p class="interlineado"><b>Tipo y Nro de Doc:</b>
                        {{$tipoDocumentoTitular->nom_tipo. " - ". $dniTitular}}
                    </p>
                </td>
                <td style="text-align: left; width: 195px;">
                    <p class="interlineado"><b></b></p>
                    <p class="interlineado"><b>Edad:</b>
                        @if ($edadTitular != "SIN DATOS")
                        {{$edadTitular}} AÑOS
                        @else
                        <i>{{$edadTitular}}</i>
                        @endif
                    </p>
                </td>
            </tr>
            @else
            <tr>
                <td style="text-align: left; width: 300px;">
                    <p class="interlineado"><b>Beneficiario:</b> {{$familiar->nom_familiar}} - <i> (FAMILIAR) </i></p>
                    <p class="interlineado"><b>Tipo y Nro de Doc:</b>
                        {{$tipoDocumentoFamiliar->nom_tipo. " - ". $dniFamiliar}}
                    </p>
                </td>
                <td style="text-align: left; width: 195px;">
                    <p class="interlineado"><b></b></p>
                    <p class="interlineado"><b>Edad:</b>
                        @if ($edadFamiliar != "SIN DATOS")
                        {{$edadFamiliar}} AÑOS
                        @else
                        <i>{{$edadFamiliar}}</i>
                        @endif
                    </p>
                </td>
            </tr>
            @endif
        </table>
        <table>
            <tr>
                <td class="redondo" style="text-align: left; width: 642px;">
                    <p class="interlineado"><b>Diagnóstico:</b> {{$orden->diagnostico}}</p>
                    <p class="interlineado"><b>Observaciones:</b> {{$orden->obs}} </p>
                    <p class="interlineado"><b></b> </p>
                </td>
            </tr>
        </table>

        <br>

        <div class="rectangulo-detalle"> <b style="font-size:10px"> DETALLE DE PRACTICAS </b></div>



        <table class="tabla-detalle">
            <thead>
                <th class="fuenteNunito" style="width:10%;">CODIGO</th>
                <th class="fuenteNunito" style="text-align:left; width:480px;">DESCRIPCION</th>
                <th class="fuenteNunito" style="text-align:center;width:15%">CANTIDAD</th>
                <th class="fuenteNunito" style="text-align:right;width:15%">IMPORTE</th>
            </thead>

            <tbody>

                @foreach($orden->getDetalle as $detalle)
                <tr>
                    <td>
                        {{$detalle->getPmo->codigo}}
                    </td>
                    <td style="width:70%;">
                        {{$detalle->getPmo->denominacion}}
                    </td>
                    <td style="text-align:center">
                        {{$detalle->cantidad}}
                    </td>
                    <td style="text-align:right">
                        {{$detalle->importe}}
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
        <table>
            <tr>
                <td class="footer-detalle" style="width: 640px;">
                    <p class="interlineado" style="text-align: right;"><b>SUBTOTAL $ {{$orden->importe_total}} - Imp. Bonificación $ {{$orden->importe_bonificacion}} - TOTAL $ {{$orden->importe_total - $orden->importe_bonificacion}}</b></p>
                </td>
            </tr>
        </table>
        <hr>
        <p class="interlineado"><b>Derivación:</b> </p>
        <p class="interlineado">{{$orden->derivacion}} </p>

        <table>
            <tr>
                <td>
                    <p style="width: 200px; text-align: left;font-size: 10px">
                        ............................................. </p>
                    <p style="width: 200px; text-align: left;font-size: 10px"> Fecha y sello del Prestador </p>
                </td>
                <td>
                    <p style="width: 200px; text-align: center;font-size: 10px">
                        ............................................. </p>
                    <p style="width: 200px; text-align: center;font-size: 10px"> Firma del Afiliado </p>
                </td>
                <td>
                    <p style="width: 40px;"> </p>
                    <p style="width: 40px;"></p>
                </td>
                <td>
                    <p style="width: 40px;"> </p>
                    <p style="width: 40px;"></p>
                </td>
                <td style="text-align:right;">
                    <img width="100" height="100" src="data:image/png;base64, {!! $qrcode !!}">
                </td>
            </tr>
        </table>
        <hr>
        <table>
            <tr>
                <td style="text-align: left; width: 500px;">
                    @if ($orden->tipo_beneficiario == 0)
                    <p class="interlineado"><b>Beneficiario:</b> {{$titular->nom_titular}}</p>
                    <p class="interlineado"><b>Tipo y Nro de Doc:</b>
                        {{$tipoDocumentoTitular->nom_tipo. " - ". $dniTitular}}
                    </p>
                    @else
                    <p class="interlineado"><b>Beneficiario:</b> {{$familiar->nom_familiar}}</p>
                    <p class="interlineado"><b>Tipo y Nro de Doc:</b>
                        {{$tipoDocumentoFamiliar->nom_tipo. " - ". $dniFamiliar}}
                    </p>
                    @endif
                    <p class="interlineado"></p>
                </td>
                <td style="text-align: right; width: 195px;">
                    <p class="interlineado"><b>Operador:</b> {{$usuario->name}}</p>
                    <p class="interlineado"><b>Fecha:
                            {{$fecha_hora->format('d / m / Y')." - ".$fecha_hora->format('H:m')}}</b></p>
                    <p class="interlineado"><b>N° Bono: {{$orden->id}} </b></p>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width: 400px;">
                </td>
                <td style="width: 250px;">
                    <p class="interlineado" style="text-align: right;"><b>TOTAL $
                            {{$orden->importe_total-$orden->importe_bonificacion}} </b></p>
                    <p class="interlineado" style="text-align: right;">Para la boca de expendio -
                        {{$fecha_hora->format('d / m / Y')." - ".$fecha_hora->format('H:m')}}
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <table>
            <tr>
                <td style="text-align: left; width: 500px;">
                    @if ($orden->tipo_beneficiario == 0)
                    <p class="interlineado"><b>Beneficiario:</b> {{$titular->nom_titular}}</p>
                    <p class="interlineado"><b>Tipo y Nro de Doc:</b>
                        {{$tipoDocumentoTitular->nom_tipo. " - ". $dniTitular}}
                    </p>
                    @else
                    <p class="interlineado"><b>Beneficiario:</b> {{$familiar->nom_familiar}}</p>
                    <p class="interlineado"><b>Tipo y Nro de Doc:</b>
                        {{$tipoDocumentoFamiliar->nom_tipo. " - ". $dniFamiliar}}
                    </p>
                    @endif
                    <p class="interlineado"><b>Motivo Bonificación</b></p>
                </td>
                <td style="text-align: right; width: 195px;">
                    <p class="interlineado"><b>Fecha:
                            {{$fecha_hora->format('d / m / Y')." - ".$fecha_hora->format('H:m')}}</b></p>
                    <p class="interlineado"><b>N° Bono: {{$orden->id}} </b></p>
                    <p class="interlineado"></p>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width: 655px;">
                    <p class="interlineado" style="text-align: right;"><b>SUBTOTAL $ {{$orden->importe_total}} - Imp. Bonificación $ {{$orden->importe_bonificacion}} - TOTAL $ {{$orden->importe_total - $orden->importe_bonificacion}}</b></p>
                    <p class="interlineado" style="text-align: right;">Para el afiliado -
                        {{$fecha_hora->format('d / m / Y')." - ".$fecha_hora->format('H:m')}}
                    </p>
                </td>
            </tr>
        </table>

    </section>
</body>
<div style="page-break-after: auto;"> </div>

</html>