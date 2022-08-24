<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .nombre_sistema {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            color: #2A2A2A;
            font-size: 55px;
        }

        .nombre_division {
            font-family: monospace;
            color: #2A2A2A;
            font-size: 40px;
        }

        .nombre_agencia {
            font-family: sans-serif;
            color: #2A2A2A;
            font-size: 30px;
        }

        .links>a {
            /* formato de link de acceso */
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #868686;
            padding: 0 25px;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: solid;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .container-login100 {
            opacity: 0.8;

        }

        .portada {

            background: url("img/fondo_login.jpg") no-repeat fixed center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            height: 100%;
            width: 100%;
            text-align: center;

        }

        .imgLogo {
            width: 300px;
            height: 300px;
            border-radius: 20px;
        }

        .tabla_centrada {
            width: 100%;
            position: fixed;
            margin-left: auto;
            margin-right: auto;
            top: 40%;
        }
    </style>
</head>

<body>
    <div class="portada">
        <!-- LOGO -->
        <!-- <img src='img/logo.jpg' class='imgLogo' /> -->
        <br>
        <div class="class tabla_centrada">
            <table>
                <tr>
                    <div class="class nombre_sistema">
                        SISTEMA CONTROL DE PAGOS
                    </div>
                </tr>
                <br>
                <tr>
                    <div class="class nombre_division">
                    UOM - Las Parejas
                    </div>
                </tr>
                <br>
                <tr>
                    <div class="class nombre_agencia">
                        (...Oficina desarrolladora...)
                    </div>
                </tr>
                <br>
                <tr>
                    <div class="  links">
                        <a href="{{ route('login') }}">INGRESAR AL SISTEMA</a>
                    </div>
                </tr>               
            </table>
        </div>
    </div>
</body>

</html>