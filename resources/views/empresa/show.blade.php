@extends ('layouts.master')
@section ('contenido')
<html>
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('#detalleEmpleados').hide();
            $('#detalleEmpleados').DataTable({
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

                "columnDefs": [
                    {
                        "targets": [0]
                    },
                    {
                        "targets": [1]
                    },
                    {
                        "targets": [2]
                    }
                ],
            });
            $('#detalleEmpleados').show();
    });

</script>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota">
                <a href="{{url('empresas')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-primary class texto" title="LISTADO GENERAL DE EMPRESAS">
                        <i class="fas fa-long-arrow-alt-left"></i>
                    </button>
                </a>
                <b> DETALLE DE LA EMPRESA </b>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">TIPO EMPRESA </label>
                            @if($empresa->tpempresa==1)
                            <input type="text" value="METALURGICA" class="form-control" readonly>
                            @else
                            <input type="text" value="OTRAS" class="form-control" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="fuenteNunito">CODIGO </label>
                            <input type="numer" name="cod_empresa" value="{{$empresa->cod_empresa}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="fuenteNunito">RAZON SOCIAL </label>
                            <input type="text" name="nom_empresa" value="{{$empresa->nom_empresa}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">ACTIVIDAD </label>
                            <input type="text" name="actividad" value="{{$empresa->actividad}}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">CUIT </label>
                            <input type="text" name="cuit" value="{{$empresa->cuit}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">DOMICILIO </label>
                            <input type="text" name="domicilio" value="{{$empresa->domicilio}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">LOCALIDAD </label>
                            <select name="id_cpostal" id="id_cpostal" class="form-control" readonly>
                                @foreach($localidades as $localidad)
                                @if($empresa->id_cpostal == $localidad->id)
                                <option value="{{$localidad->id}}" selected>{{$localidad->cpostal." - ".$localidad->nombre}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">TELEFONO </label>
                            <input type="text" name="telefono" value="{{$empresa->telefono}}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">CORREO ELECTRONICO </label>
                            <input type="text" name="email" value="{{$empresa->email}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">INICIO ACTIVIDAD </label>
                            <input type="date" name="fecha_inicio_actividad" value="{{$empresa->fecha_inicio_actividad}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA ALTA </label>
                            <input type="date" name="fecha_alta" value="{{$empresa->fecha_alta}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito"> OB. METALURGICOS</label>
                            <input type="number" name="cantidad_obreros" value="{{$afilGremio}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">OSUOMRA </label>
                            <input type="number" name="cantidad_afiliados" value="{{$afilObraSocial}}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">ESTADO EMPRESA </label>
                            @if($empresa->estado==0)
                            <input type="text" value="ACTIVA" class="form-control" readonly>
                            @else
                            <input type="text" value="INACTIVA" class="form-control" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-10">
                        <label class="fuenteNunito">OBSERVACIONES</label>
                        <textarea name="obs" style="text-transform: uppercase;" class="form-control" rows="2" readonly>{{$empresa->obs}}</textarea>
                    </div>
                </div>
                @isset($empresa_modificado->fecha_mod)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <label class="fuenteNunito">ULTIMA MODIFICACION </label>
                            <input type="text" value="{{date("d-m-Y / H:i",strtotime($empresa_modificado->fecha_mod)). " - ". $usuario_modifico->name}}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                @endisset
            </div>
        </div>
    </div>
</div>
@if(isset($datosEmpleado[0]))
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota">
                <b> DETALLE DE {{$totalEmpleados}} EMPLEADOS DE LA EMPRESA {{$empresa->nom_empresa}}</b>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table id="detalleEmpleados" class="table table-striped table-condensed table-hover mb-0">
                            <thead>
                                <th class="fuenteNunito">DOCUMENTO</th>
                                <th class="fuenteNunito">APELLIDO Y NOMBRES</th>
                                <th class="fuenteNunito">AFILIADO A</th>                                
                            </thead>
                            <tbody>
                                @if($datosEmpleado[0]->nro_doc >= 0)
                                @foreach($datosEmpleado as $row)
                                <tr>
                                    <td>
                                        <!-- nro documento -->
                                        {{ $row->nro_doc }}
                                    </td>
                                    <td>
                                        <!-- nombre del empleado -->
                                        {{ $row->nom_titular }}
                                    </td>
                                    <td>
                                    @switch($row->afiliado_a)
                                        @case(1)
                                            OBRA SOCIAL
                                            @break
                                        @case(2)
                                            GREMIO
                                            @break
                                        @case(3)
                                            OBRA SOCIAL Y GREMIO
                                            @break
                                    @endswitch
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
@endif
</html>
@endsection