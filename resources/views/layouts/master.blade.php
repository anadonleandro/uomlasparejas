<!DOCTYPE html>

<html lang="es">


<head>
    <meta http-equiv="expires" content="0">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema UOM</title>
    <!--fontawesomes -->
    <link href="{{asset('css/all.css')}}" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/jpg" href="{{asset('img/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <!-- Boostrap 4 Data Tables -->
    <!--<link rel="stylesheet" href="{{asset('datatables/1.10.20/css/jquery.dataTables.min.css')}}">-->
    <link rel="stylesheet" href="{{asset('datatables/1.10.20/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <!-- Buttons 4 Data Tables -->
    <link rel="stylesheet" href="{{asset('datatables/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('datatables/dataTables.buttons.min.css')}}">
    <!-- alertify -->
    <link rel="stylesheet" href="{{asset('css/alertify.min.css')}}">

    <style>
        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: grey;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 4px;
        }

        #myBtn:hover {
            background-color: #555;
        }

        .texto {
            /*ESTILO DE TITULOS*/
            font-family: inherit;
            color: #09576d;
            font-size: 20px;
            vertical-align: center
        }

        .color-table-head {
            background-color: #525C7D;
            font-size: 16px;
            color: #E4E6EE
                /* font-family: Georgia;
            color: #162f81;
            vertical-align: center*/
        }

        .btn-success-nuevo {
            background-color: #257A3C;
            color: #edeeed;
        }

        .btn-warning-nuevo {
            background-color: #aa5637;
            color: #edeeed;
        }

        .btn-primary-nuevo {
            background-color: #20326B;
            color: #edeeed;
        }

        .btn-primary-nuevo:hover {
            color: #fff;
            background-color: #3a4979;
            border-color: #2176bd
        }

        .color-header-nota {
            /*ESTILO DE NOTAS DE SECUESTRO*/
            text-align: center;
            font-family: Nunito;
            color: #5D5F77 !important;
            background-color: #EED1BB !important;
            font-size: 20px;
            vertical-align: center;
        }

        .color-header-allanamiento {
            /*ESTILO DE ORDEN DE ALLANAMIENTO*/
            text-align: center;
            font-family: Nunito;
            color: #5D5F77 !important;
            font-size: 20px;
            vertical-align: center;
            background-color: #bbbeee !important;
        }

        .color-header-elemento {
            /*ESTILO DE ELEMENTOS*/
            text-align: center;
            font-family: Nunito;
            color: #5D5F77 !important;
            font-size: 20px;
            vertical-align: center;
            background-color: #BBD8EE !important;
        }

        .fuenteNunito {
            font-family: Nunito;
            src: url('public/fonts/nunito/Nunito-Regular.ttf');
        }

    </style>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Izquierda navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <span class="user-name">
                            SISTEMA UOM - Las Parejas
                        </span>
                    </a>
                </li>
            </ul>
            <!-- Derecha navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Buscador Navbar -->
                <!-- <li class="nav-item">
                </li> -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->

                        <!-- User Account: style can be found in dropdown.less -->

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic nav-link"
                                data-toggle="dropdown">
                                <span class="user-name">
                                    <i class="fa fa-user-circle"></i>
                                    {{ Auth::user()->name }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-list" role="menu">
                                <li role="presentation"><a href="" class="nav-link"><i class="fa fa-calendar-check"></i>
                                        <b>Activo desde:</b>
                                        {{date("d/m/Y",strtotime(Auth::user()->fec_alta))}}</a></li>
                                <hr>
                                <li role="presentation"><a href="" class="nav-link"><i
                                            class="fa fa-exclamation-triangle"></i><b>Vto. contraseña:</b>
                                        {{date("d/m/Y",strtotime(Auth::user()->vencimiento))}}</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link" style="text-align: center;">
                <div style="text-align:center">
                    <figure>
                        <img src="{{asset('/img/logo_uom.png')}}" class="logo" width="100" height="100" />
                    </figure>
                </div>
            </a>
            @if (Auth::check())
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block">
                            <span class="brand-text font-weight-light">
                                <i class="fas fa-id-card-alt"></i>
                                {{ Auth::user()->name }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false"
                        id="linkActive" role="menu">

                        <li class="nav-item">
                            <a href="{{url('home')}}" class="nav-link">
                                <i class="fas fa-home"></i>
                                <p> INICIO</p>
                            </a>
                        </li>

                        <!-- MENU UOM -->
                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <!-- <i class="fas fa-archive"></i> -->
                                <p>
                                    <i class="right fas fa-angle-left"></i>
                                    GESTION UOM
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('empresas')}}" class="nav-link">
                                        &nbsp&nbsp<i class="fas fa-industry"></i>
                                        <p> <i> EMPRESAS </i> </p>
                                    </a>
                                </li>
                            </ul>



                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('titulares')}}" class="nav-link">
                                        &nbsp&nbsp<i class="fas fa-user"></i>
                                        <p> <i> TITULARES </i> </p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('familiares')}}" class="nav-link">
                                        &nbsp&nbsp<i class="fas fa-user-friends"></i>
                                        <p> <i> FAMILIARES </i> </p>
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <!-- FIN MENU UOM -->

                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <!-- <i class="fas fa-archive"></i> -->
                                <p>
                                    <i class="right fas fa-angle-left"></i>
                                    DEUDAS
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('nuevaDeuda')}}" class="nav-link">
                                        &nbsp&nbsp<i class="far fa-money-bill-alt"></i>
                                        <p> <i> GENERAR DEUDAS </i> </p>
                                    </a>
                                </li>
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('consultaDeuda')}}" class="nav-link">
                                        &nbsp&nbsp<i class="fas fa-search-dollar"></i>
                                        <p> <i> BUSCAR DEUDAS </i> </p>
                                    </a>
                                </li>
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('consultaConvenio')}}" class="nav-link">
                                        &nbsp&nbsp<i class="fas fa-search-dollar"></i>
                                        <p> <i> BUSCAR CONVENIOS </i> </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <!-- <i class="fas fa-archive"></i> -->
                                <p>
                                    <i class="right fas fa-angle-left"></i>
                                    PAGOS
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('procesaDeuda')}}" class="nav-link">
                                        &nbsp&nbsp<i class="fas fa-file-excel"></i>
                                        <p> <i> PROCESAR PAGOS </i> </p>
                                    </a>
                                </li>
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('erroresPagos')}}" class="nav-link">
                                        &nbsp&nbsp<i class="fas fa-exclamation-triangle"></i>
                                        <p> <i> ERRORES PAGOS </i> </p>
                                    </a>
                                </li>
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('archivosProcesados')}}" class="nav-link">
                                        &nbsp&nbsp<i class="far fa-file-excel"></i>
                                        <p> <i> ARCHIVOS PROCESADOS </i> </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <!-- <i class="fas fa-archive"></i> -->
                                <p>
                                    <i class="right fas fa-angle-left"></i>
                                    IMPUTACION MANUAL
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('imputacionManual')}}" class="nav-link">
                                        &nbsp&nbsp<i class="fas fa-hand-holding-usd"></i>
                                        <p> <i> DEUDA MANUAL </i> </p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('indexDeudaManual')}}" class="nav-link">
                                        &nbsp&nbsp<i class="fas fa-hand-holding-usd"></i>
                                        <p> <i> IMPUTACIONES </i> </p>
                                    </a>
                                </li>
                            </ul>

                        </li>
                        <!-- MENU O.S. UOM -->
                        <li class="nav-item menu-close">
                            <a href="#" class="nav-link">
                                <p>
                                    <i class="right fas fa-angle-left"></i>
                                    OBRA SOCIAL UOM
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('nuevaOrden')}}" class="nav-link">
                                        &nbsp&nbsp<i class="far fa-check-circle"></i>
                                        <p> <i> NUEVA ORDEN </i> </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('ordenes')}}" class="nav-link">
                                        &nbsp&nbsp<i class="far fa-list-alt"></i>
                                        <p> <i> ORDENES </i> </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- FIN MENU O.S. UOM -->

                        <!--MENU BUSQUEDAS MULTILEVEL -->
                        <!-- <li class="nav-item">
                            <a href="#" class="nav-link">
                                <p>
                                    MENU MULTIPLE
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <p>
                                            &nbspSUBMENU 1
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a 
                                                class="nav-link">
                                                &nbsp&nbsp<i class="fas fa-search"></i>
                                                <p><i> ITEM</i></p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a 
                                                class="nav-link">
                                                &nbsp&nbsp<i class="fas fa-search"></i>
                                                <p><i> ITEM</i></p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a 
                                                class="nav-link">
                                                &nbsp&nbsp<i class="fas fa-search"></i>
                                                <p><i> ITEM</i></p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <p>
                                            &nbspSUBMENU 2
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a 
                                                class="nav-link">
                                                &nbsp&nbsp<i class="fas fa-search"></i>
                                                <p><i> ITEM</i></p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a 
                                                class="nav-link">
                                                &nbsp&nbsp<i class="fas fa-search"></i>
                                                <p><i> ITEM</i></p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li> -->
                        <!-- FIN MULTILEVEL -->

                        <li class="nav-item">
                            <a href="cambiar/password" class="nav-link">
                                <i class="fas fa-key"></i>
                                <p> CAMBIAR CONTRASEÑA </p>
                            </a>
                        </li>
                        @if(Auth::user()->roll == 1)
                        <li class="nav-item">
                            <a href="{{url('listadoUsuarios')}}" class="nav-link">
                                <i class="fas fa-users-cog"></i>
                                <p> GESTION USUARIOS </p>
                            </a>
                        </li>
                        @endif
                        <!-- FIN USUARIOS -->
                        <li class="nav-item">
                            <a href="acercade" class="nav-link">
                                <i class="fas fa-info-circle"></i>
                                <p> ACERCA DE...</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-door-open"></i>
                                <p> SALIR DEL SISTEMA</p>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            @endif
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <!-- /.content-header -->
            <!-- Main content -->

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- /.col-md-6 -->
                        <div class="col-lg-12">
                            <!--Contenido-->
                            @yield('contenido')
                            <!--Fin Contenido-->
                            <button onclick="topFunction()" id="myBtn" title="SUBIR">
                                <i class="fas fa-chevron-up"></i>
                            </button>

                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Versión:
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2022 <a href="#">ALFASYS COMPUTACION</a></strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!--  SCRIPTS -->

    <!-- jQuery -->
    <!-- jQuery 3.6.0 -->
    <script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Datatables js  -->
    <script src="{{asset('datatables/1.10.20/js/jquery.dataTables.min.js')}}"></script>
    <!-- Datatables Boostrap 4 js  -->
    <script src="{{asset('datatables/1.10.20/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <!--  Buttons datatables -->
    <script src="{{asset('datatables/dataTables.buttons.min.js')}}"></script>
    <!--  Buttons flash -->
    <script src="{{asset('datatables/buttons.flash.min.js')}}"></script>
    <!--  jsZip DataTables export -->
    <script src="{{asset('datatables/jszip.min.js')}}"></script>
    <!--  PDF MAke -->
    <script src="{{asset('datatables/pdfmake.min.js')}}"></script>
    <!--   alertify -->
    <script src="{{asset('js/alertify.js')}}"></script>
    <script src="{{asset('js/alertify.min.js')}}"></script>
    <!--  VfsFont -->
    <script src="{{asset('datatables/vfs_fonts.js')}}"></script>
    <!--  Buttons HTML5 -->
    <script src="{{asset('datatables/buttons.html5.min.js')}}"></script>
    <!--  PDF MAke -->
    <script src="{{asset('datatables/buttons.print.min.js')}}"></script>
    <!-- jQuery Validate -->
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/additional-methods.js')}}"></script>
    <script src="{{asset('js/jquery.form.min.js')}}"></script>
    <!-- ACTIVA MOMENT -->
    <script src="{{asset('js/moment.min.js')}}"></script>

    <script>
        //el boton
        var mybutton = document.getElementById("myBtn");

        // cuando se hace scroll abajo, se muestra el boton
        window.onscroll = function () {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        // con clic, ir arriba de todo
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
        // ACTIVA EL LINK SELECCIONADO DEL MENU
        $(".nav .nav-link").on("click", function () {
            $(".nav").find(".active").removeClass("active");
            $(this).addClass("active");
        });
        // $('li a').click(function(e) {
        //     //e.preventDefault();
        //     $('a').removeClass('active');
        //     $(this).addClass('active');
        // });

    </script>
</body>

</html>
