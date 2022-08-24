@extends ('layouts.master')

@section ('contenido')

<style type="text/css">
    .tg {
        border-collapse: collapse;
        border-spacing: 0
    }

    .tg td {
        font-family: Arial, sans-serif;
        font-size: 14px;
        padding: 10px 5px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
        border-color: black;
    }

    .tg th {
        font-family: Arial, sans-serif;
        font-size: 14px;
        font-weight: normal;
        padding: 10px 5px;
        border-style: solid;
        border-width: 1px;
        overflow: hidden;
        word-break: normal;
        border-color: black;
    }

    .tg .titulo {
        color: DarkSlateGray;
        font-size: 23px;
        background-color: #eeeeee;
        border-color: #ffffff;
        text-align: center;
        vertical-align: center
    }

    .tg .escudo {
        background-color: #efefef;
        border-color: #ffffff;
        vertical-align: center;
        margin-left: auto;
        margin-right: auto;
        width: 200px;
        height: 200px;
    }

    .tg .texto1 {
        font-family: monospace;
        color: DarkSlateGray;
        font-size: 20px;
        background-color: #eeeeee;
        border-color: #ffffff;
        text-align: center;
        vertical-align: center
    }

    .tg .texto2 {
        font-family: monospace;
        color: DarkSlateGray;
        font-size: 21px;
        background-color: #eeeeee;
        border-color: #ffffff;
        text-align: center;
        vertical-align: center
    }

    .tg .texto3 {
        font-family: monospace;
        color: DarkSlateGray;
        font-size: 18px;
        background-color: #eeeeee;
        border-color: #ffffff;
        text-align: center;
        vertical-align: center
    }

    .aic {
        position: static;
        height: 200px;
        width: 600px;
        top: 40px;
        left: 27%;
        z-index: 1;
    }

    .fondo {
        /*  position:s;*/
        background-color: red;
    }

</style>

<!-- 
    IMAGEN CENTRAL DE ARRIBA
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body" style="background-color:#222d32; opacity: 0.8" class="fondo">
                <div style="text-align:center">
                    <figure>
                        <img src='img/Logotipo 02.png' class='aic' />
                    </figure>
                </div>
            </div>
        </div>
    </div>
</div> -->

<br>

<table class="tg" style="margin: 0 auto;" style="border-radius: 20px;">
    <tr>
        
        <th class="titulo"><b>SISTEMA UOM - Las Parejas</b></th>
        <th class="escudo" rowspan="4"><img src='img/logo_uom.png' ; style="width: 200px; height: 200px;"
                class="img-thumbnail"></th>
    </tr>
    <tr>
        <td class="texto1"><b>ALFASYS COMPUTACION</b></td>
    </tr>
    <tr>
        <td class="texto3"><i class="fa fa-phone"></i> <b>Teléfono:</b>
            <i>342 1 123 456</i></td>
    </tr>
    <tr>
        <td class="texto3"><i class="fa fa-envelope"></i> <b>Correo:</b>
            <i>soporte_sistema@gmail.com</i></td>
    </tr>
</table>

<br>


@endsection
