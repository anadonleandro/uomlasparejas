@extends ('layouts.master')

@section ('contenido')
<html>

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />
</head>
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

            <!-- tabla con errores -->

            @if(isset($erroresEmpresa))
            <div class="row justify-content-left">
                <div class="col-md-12">
                    <br>
                    <div class="card">
                        <div class="card-header bgsize-primary-4 white card-header">
                            <h4 class="card-title"><b> Concepto a Procesar: " {{$concepto}} "</b></h4>
                            <h4 class="card-title"><b> - Archivo: "{{$erroresEmpresa[0]->nombre_archivo}} " </b></h4>
                            <h4 class="card-title"><b style="color:indianRed"> - / NO SE PUEDE PROCESAR - HAY
                                    ERRORES</b>
                            </h4>
                        </div>
                        @if ($message = Session::get('errors'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        <br>
                        @endif
                        <div class="card-body">
                            <div class=" card-content table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <th>EMPRESA</th>
                                        <th>DEPOSITO</th>
                                        <th>PERIODO</th>
                                        <th>EMPLEADOS</th>
                                        <th>BASE CALC. $ TOTAL REMUN.</th>
                                        <th>$ DEPOSITADO</th>
                                        <th>CONVENIO</th>
                                        <th>CUOTA</th>
                                        <th>ERRORES</th>
                                    </thead>
                                    <tbody>
                                        @foreach($erroresEmpresa as $row)
                                        <tr>
                                            @if($row->empresa == "EMPRESA INEXISTENTE")
                                            <td style="color:indianred">
                                                <!-- empresa -->
                                                {{ $row->cod_empresa." - ".$row->empresa }}
                                            </td>
                                            @else
                                            <td>
                                                <!-- empresa -->
                                                {{ $row->cod_empresa." - ".$row->empresa }}
                                            </td>
                                            @endif
                                            <td>
                                                <!-- fecha deposito -->
                                                {{ date("d/m/Y",strtotime($row->fecha_deposito)) }}</td>
                                            <td>
                                                <!-- periodo mm/aaaa -->
                                                @if ($row->periodo <= 0) <i style="color:indianred"> Sin Datos</i>
                                                    @else
                                                    {{ date("m/Y",strtotime($row->periodo)) }}</td>
                                            @endif
                                            <td>
                                                <!-- cantidad empleados -->
                                                {{ $row->cant_afil_titulares }}</td>
                                            <td>
                                                <!-- base de calculos / importe total remuneracion -->
                                                {{ $row->ipte_total_remuneracion }}</td>
                                            <td>
                                                <!-- base de calculos -->
                                                {{ $row->ipte_depositado }}</td>
                                            <td>
                                                <!-- convenio -->
                                                {{ $row->nro_acuerdo }}</td>
                                            <td>
                                                <!-- cuota -->
                                                {{ $row->nro_cuota }}</td>
                                            <td style="color:indianred">
                                                <!-- se ve si hay errores -->
                                                {{ $row->mensajeError }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN Tabla datos CON errores -->

            @elseif(isset($datosExcel))
            <!-- Tabla datos SIN errores -->
            <div class="row justify-content-left">
                <div class="col-md-12">
                    <br>
                    <div class="card">
                        <div class="card-header bgsize-primary-4 white card-header">

                            <a href="{{url('export')}}" class="card-link float-sm-right">
                                <button class="btn btn-outline-info class texto" title="PROCESAR EXCEL">
                                    <i class="fas fa-spinner"></i> PROCESAR EXCEL
                                </button>
                            </a>
                            <h4 class="card-title"><b> Concepto a Procesar: " {{$concepto}} "</b></h4>
                            <h4 class="card-title"><b> - Archivo: "{{$datosExcel[0]->nombre_archivo}} " </b></h4>
                            </h4>
                        </div>
                        @if ($message = Session::get('errors'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        <br>
                        @endif
                        <div class="card-body">
                            <div class=" card-content table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <th>EMPRESA</th>
                                        <th>DEPOSITO</th>
                                        <th>PERIODO</th>
                                        <th>EMPLEADOS</th>
                                        <th>BASE CALCULO</th>
                                        <th>$ DEPOSITADO</th>
                                        <th>CONVENIO</th>
                                        <th>CUOTA</th>
                                    </thead>
                                    <tbody>
                                        @foreach($datosExcel as $row)
                                        <tr>
                                            @if($row->empresa == "EMPRESA INEXISTENTE")
                                            <td style="color:indianred">
                                                <!-- empresa -->
                                                {{ $row->cod_empresa." - ".$row->empresa }}
                                            </td>
                                            @else
                                            <td>
                                                <!-- empresa -->
                                                {{ $row->cod_empresa." - ".$row->empresa }}
                                            </td>
                                            @endif
                                            <td>
                                                <!-- fecha deposito -->
                                                {{ date("d/m/Y",strtotime($row->fecha_deposito)) }}</td>
                                            <td>
                                                <!-- periodo mm/aaaa -->
                                                {{ date("m/Y",strtotime($row->periodo)) }}</td>
                                            <td>
                                                <!-- cantidad empleados -->
                                                {{ $row->cant_afil_titulares }}</td>
                                            <td>
                                                <!-- base de calculos -->
                                                {{ $row->ipte_total_remuneracion }}</td>
                                            <td>
                                                <!-- base de calculos -->
                                                {{ $row->ipte_depositado }}</td>
                                            <td>
                                                <!-- convenio -->
                                                {{ $row->nro_acuerdo }}</td>
                                            <td>
                                                <!-- cuota -->
                                                {{ $row->nro_cuota }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN Tabla datos sin errores -->
    @endif

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });

    </script>
</div>


</html>

@endsection
