@extends ('layouts.master')

@section ('contenido')
<html>
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptProcesaExcel.js')}}"></script>
<script src="{{asset('sweetalert/sweetalert.js') }}"></script>

<script>
    $(document).ready(function () {

        //$('#example').DataTable();
        $('#example').hide();
        $('#procesar').hide();

        var progreso = 0;
        var timerId = setInterval(function () {
            // Aumento en 10 el progeso
            progreso += 10;
            $('#bar').css('width', progreso + '%');
            $('#bar').attr('aria-valuenow', progreso);
            $('#bar').text(progreso + '%');

            //Si llegó a 100 elimino el interval
            if (progreso == 100) {
                $('#example').DataTable({
                    lengthMenu: [
                        [25, 50, 100, -1],
                        [25, 50, 100, "Todos"]
                    ],
                    language: {
                        "decimal": "",
                        "emptyTable": "NO HAY INFORMACION PARA MOSTRAR",
                        "info": "MOSTRANDO _START_ A _END_ DE _TOTAL_ REGISTROS",
                        "infoEmpty": "MOSTRANDO 0 A 0 DE 0 REGISTROS",
                        "infoFiltered": "(FILTRADO DE UN TOTAL DE _MAX_ REGISTROS)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "MOSTRAR _MENU_ REGISTROS",
                        "loadingRecords": "CARGANDO...",
                        "processing": "PROCESANDO...",
                        "search": "BUSCAR:",
                        "zeroRecords": "SIN RESULTADOS",
                        "paginate": {
                            "first": "PRIMERO",
                            "last": "ULTIMO",
                            "next": "SIGUIENTE",
                            "previous": "ANTERIOR"
                        }
                    },

                    "columnDefs": [{
                            "targets": [4],
                            className: 'columnaConNumero'
                        },
                        {
                            "targets": [5],
                            className: 'columnaConNumero'
                        },
                        {
                            "targets": [6],
                            className: 'columnaConNumero'
                        },
                        {
                            "targets": [7],
                            className: 'columnaConNumero'
                        },
                        {
                            "targets": [8],
                            className: 'columnaConNumero'
                        }
                    ],

                });
                $('#example').show();
                $('#procesar').show();
                $('#bar').hide();
                clearInterval(timerId);
            }
        }, 75);
    });

</script>

<style>
    .columnaConNumero {
        text-align: right;
    }

    .thead {
        text-align: left;
    }

</style>

<br>

<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota">
                <b>CARGA EXCEL PAGOS DE DEUDAS</b>
            </div>
            <div class="row justify-content-centre" style="margin-top: 4%">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bgsize-primary-4 white card-header">
                            <h4 class="card-title"><b> ARCHIVO EXCEL TIPO (.xls - .xlsx) </b></h4>
                        </div>
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                            <br>
                            @endif
                            @if(Session::has('message'))
                            <div class="alert alert-warning alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{Session::get('message')}}
                            </div>
                            <br>
                            @endif

                            <form action='{{url("import")}}' method="post" enctype="multipart/form-data">
                                @csrf
                                <fieldset>
                                    <div class="input-group">
                                        <input type="file" required class="form-control" name="uploaded_file"
                                            id="uploaded_file">
                                        @if ($errors->has('uploaded_file'))
                                        <p class="text-right mb-0">
                                            <small class="danger text-muted"
                                                id="file-error">{{ $errors->first('uploaded_file') }}</small>
                                        </p>
                                        @endif
                                        
                                        <div class="input-group-append" id="button-addon2">
                                            <button class="btn btn-info square" type="submit"><i
                                                    class="ft-upload mr-1"></i>
                                                CARGAR</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($datosExcel[0]))
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="row justify-content-left">
                <div class="col-md-12">
                    <br>
                    <div class="card">
                        <div class="card-header bgsize-primary-4 white card-header">
                            <form action="{{url('procesaPagos')}}" method="POST" id="procesa_pagos">
                                @csrf
                                <button class="btn btn-outline-info class texto float-sm-right" id="procesar"
                                    type="button" title="PROCESAR EXCEL" onclick="procesaPagos()">
                                    <i class="fas fa-spinner"></i> PROCESAR EXCEL
                                </button>
                                <input type="hidden" name="items" id="items" value="{{json_encode($datosExcel,TRUE)}}">
                            </form>
                            @if(isset($concepto))
                            <h4 class="card-title"><b> CONCEPTO A PROCESAR: " {{$concepto}} "</b></h4>
                            @endif
                            <h4 class="card-title"><b> - ARCHIVO: "{{$datosExcel[0]->nombre_archivo}} " </b></h4>
                            @if(isset($erroresEmpresa))
                            <h4 class="card-title"><b style="color:indianRed"> - / CON ERRORES</b>
                            </h4>
                            @else
                            <h4 class="card-title"><b style="color:forestgreen"> - / SIN ERRORES</b>
                            </h4>
                            @endif
                        </div>
                        @if ($message = Session::get('errors'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        <br>
                        @endif
                        <div class="card-body">
                            <div class="progress">
                                <div id="bar"
                                    class="progress-bar progress-bar-striped progress-bar-animated bg-success active"
                                    role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                            <br>
                            <div class=" card-content table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <th>CODIGO</th>
                                        <th>EMPRESA</th>
                                        <th>DEPOSITO</th>
                                        <th>PERIODO</th>
                                        <th>EMPLEADOS</th>
                                        <th>BASE CALC. $ TOTAL REMUN.</th>
                                        <th>$ DEPOSITADO</th>
                                        <th>CONVENIO</th>
                                        <th>CUOTA</th>
                                    </thead>
                                    <tbody>
                                        @if($datosExcel[0]->cod_empresa >= 0)
                                        @foreach($datosExcel as $row)
                                        <tr>
                                            <td>
                                                <!-- cod empresa -->
                                                {{ $row->cod_empresa }}
                                            </td>
                                            @if($row->empresa == "EMPRESA INEXISTENTE")
                                            <td style="color:indianred">
                                                <!-- empresa -->
                                                {{ $row->empresa }}
                                            </td>
                                            @else
                                            <td>
                                                <!-- empresa -->
                                                {{ $row->empresa }}
                                            </td>
                                            @endif
                                            <td>
                                                <!-- fecha deposito -->
                                                @if($row->fecha_deposito > 0)
                                                {{ date("d/m/Y",strtotime($row->fecha_deposito)) }}
                                                @endif
                                            </td>
                                            <td>
                                                <!-- periodo mm/aaaa -->
                                                @if($row->periodo > 0)
                                                {{ date("m/Y",strtotime($row->periodo)) }}
                                                @else
                                                {{ $row->periodo}}
                                                @endif
                                            </td>
                                            <td>
                                                <!-- cantidad empleados -->
                                                {{ $row->cant_afil_titulares }}
                                            </td>
                                            <td>
                                                <!-- base de calculos -->
                                                {{ $row->ipte_total_formateado }}
                                            </td>
                                            <td>
                                                <!-- base de calculos -->
                                                {{ $row->ipte_depositado_formateado }}
                                            </td>
                                            <td>
                                                <!-- convenio -->
                                                {{ $row->nro_acuerdo }}
                                            </td>
                                            <td>
                                                <!-- cuota -->
                                                {{ $row->nro_cuota }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

</html>

@endsection
