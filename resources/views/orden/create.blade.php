@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptGetPrecio.js')}}"></script>
<script src="{{asset('js/scriptBuscaBeneficiario.js')}}"></script>
<script src="{{asset('js/scriptValidaOrden.js')}}"></script>
<script src="{{asset('sweetalert/sweetalert.js') }}"></script>

<!-- PARA HOSTING
<script src="{{('../public/js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{('../public/js/scriptGetPrecio.js')}}"></script>
<script src="{{('../public/js/scriptBuscaBeneficiario.js')}}"></script>
<script src="{{('../public/js/scriptValidaOrden.js')}}"></script>
<script src="{{('../public/sweetalert/sweetalert.js') }}"></script> -->

<!-- <style type="text/css">
    label.error {
        height: 17px;
        padding: 1px 1px 0px 1px;
        font-size: 15px;
        color: #DBA901;
    }

</style> -->

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota" style="background-color: #be9096;">
                <b>NUEVA ORDEN</b>
            </div>
            <form action="{{route('guardarOrden')}}" method="POST" id="orden_create">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <!-- <label for="buscar">TIPO BENEFICIARIO </label> -->
                                <select name="tipo" id="tipo" class="form-control">
                                    <option selected value="0">TITULAR</option>
                                    <option value="1">FAMILIAR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <!-- <label for="buscar">DNI BENEFICIARIO </label> -->
                                <input type="text" placeholder="DNI BENEFICIARIO" name="buscar" id="buscar" class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="id_titular" id="id_titular" class="form-control">
                        <input type="hidden" name="id_familiar" id="id_familiar" class="form-control">
                        <input type="hidden" name="tipoBeneficiario" id="tipoBeneficiario" class="form-control">
                        <div class="col-md-8">
                            <table id="beneficiario" class="table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color:#A9D0F5; font-size: 13px;">
                                    <th><i class="fas fa-trash-alt"></i></th>
                                    <th>APELLIDO Y NOMBRE</th>
                                    <th>TIPO AFILIADO</th>
                                    <th>TIPO Y NRO DE DNI</th>
                                    <th>SEXO</th>
                                    <th>TITULAR</th>
                                </thead>
                                <tbody style="font-size: 13px;">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <div class="row">
                        
                    </div> -->
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha">FECHA ESTUDIO</label>
                                <input type="date" name="fecha_estudio" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha">FECHA REALIZACION</label>
                                <input type="date" name="fecha_realizacion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for=""></label>
                                <input type="text" placeholder="SOLICITANTE"" name=" solicitante" id="solicitante" style="text-transform:uppercase;" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for=""> </label>
                                <input type="text" placeholder="DIAGNOSTICO" name="diagnostico" id="diagnostico" style="text-transform:uppercase;" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <!-- <label for="">DERIVACION </label> -->
                                <input type="text" placeholder="DERIVACION" name="derivacion" id="derivacion" style="text-transform:uppercase;" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <!-- <label for="">OBSERVACIONES </label> -->
                                <input type="text" placeholder="OBSERVACIONES" name="obs" id="obs" style="text-transform:uppercase;" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <!-- <label class="">TIPO ESTUDIO </label> -->
                                <select name="tipo_estudio" id="tipo_estudio" class="form-control">
                                    @foreach($tiposPrestaciones as $tipo)
                                    <option value="{{$tipo->id}}">{{$tipo->nom_tipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <!-- <label class="">DESCRIPCION - practicas PMO</label> -->
                                <select name="descripcionmedica" id="descripcionmedica" class="form-control selectpicker" data-live-search="true" onchange="cargarPrecio()">

                                    @foreach($practicasPmo as $tipoPmo)
                                    <option value="{{$tipoPmo->id}}_{{$tipoPmo->codigo}}_{{$tipoPmo->denominacion}}">
                                        {{$tipoPmo->codigo." - ".substr($tipoPmo->denominacion, 0, 70)}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <!-- <label for="">CANTIDAD</label> -->
                                <input type="text" value="1" placeholder="CANT" name="cantidad" id="cantidad" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <!-- <label for="">IMPORTE</label> -->
                                <input type="text" placeholder="VALOR" name="importe" id="importe" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <!-- <label ></label> -->
                                <button type="button" id="bt_add" class="btn btn-primary btn-block" title="AGREGAR ITEM"><i class="far fa-arrow-alt-circle-down"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color:#A9D0F5; font-size: 13px;">
                                    <th><i class="fas fa-trash-alt"></i></th>
                                    <th>CODIGO</th>
                                    <th>DESCRIPCION</th>
                                    <th width="15%" style="text-align:center">CANTIDAD</th>
                                    <th width="15%" style="text-align:center">SUBTOTAL</th>
                                </thead>
                                <tbody style="font-size: 13px;">
                                </tbody>
                                <tfoot style="font-size: 13px;">
                                    <tr>
                                        <th colspan="4">
                                            <p style="text-align: right; font-size: 13px;">TOTAL:</p>
                                        </th>
                                        <th>
                                            <p style="text-align: right; font-size: 13px;"><span style="text-align: right; font-size: 13px;" id="total">$ 0</span>
                                                <input type="hidden" name="total_pagar" id="total_pagar">
                                            </p>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <!-- <label for="">BONIFICACION</label> -->
                                <input type="number" placeholder="$ BONIFICACION" name="bonificacion" id="bonificacion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <!-- <label for="">MOTIVO BONIFICACION</label> -->
                                <input type="text" placeholder="MOTIVO BONIFICACION" style="text-transform:uppercase;" name="motivo_bonificacion" id="motivo_bonificacion" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-6" style="text-align: right;">
                            <button class="btn btn-block btn-outline-success" type="button" onclick="validaOrdenCreate()">
                                <div class="iconos-class"><i class="fas fa-check" aria-hidden="true"></i> GUARDAR
                                    ORDEN </div>
                            </button>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                            <button class="btn btn-block btn-outline-danger" onclick="limpiarTabla()" type="reset">
                                <div class="iconos-class"><i class="fas fa-times" aria-hidden="true"></i> CANCELAR
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#bt_add').click(function() {
            agregar();
        });
    });

    var cont = 0;
    total = 0;
    subtotal = [];
    $("#guardar").hide();

    function agregar() {

        id_titular = $('#id_titular').val();
        id_familiar = $('#id_familiar').val();
        tipoBeneficiario = $('#tipoBeneficiario').val();
        //tipo_estudio = $("#tipo_estudio option:selected").val();

        datosDescripcionMedica = document.getElementById('descripcionmedica').value.split('_');
        //alert(datosDescripcionMedica);
        id_pmo = datosDescripcionMedica[0];
        cod_pmo = datosDescripcionMedica[1];
        denominacion_pmo = datosDescripcionMedica[2];

        cantidad = $("#cantidad").val();
        importe = $("#importe").val();

        if (id_titular) {

            subtotal[cont] = parseInt(cantidad * importe); // calcula importe total de la practica y lo manda a subtotal
            total = total + subtotal[cont];

            var fila = '<tr class="selected" id="fila' + cont +
                '"><td><button type="button" class="btn btn-warning" onclick="eliminar(' + cont +
                ');">X</button></td><td><input type="hidden" name="id_pmo[]" value="' +
                id_pmo + '">' + cod_pmo +
                '</td><td><input type="hidden" name="" value="">' + denominacion_pmo +
                '</td><td width="15%" style="text-align:center"><input type="hidden" name="cantidad[]" value="' +
                cantidad + '">' + cantidad +
                '</td><td align="right"><input type="hidden" name="subtotal[]" value="' +
                subtotal[cont] + '"> $ ' + subtotal[cont] + ' </td></tr > ';
            cont++;
            limpiar();
            totales();
            evaluar();
            $('#detalles').append(fila);

        } else {
            swal({
                title: "ATENCION..!!",
                text: "FALTA SELECCIONAR UN BENEFICIARIO",
                icon: "info",
                buttons: "ACEPTAR",
                closeOnClickOutside: false,
            });
            //alert("ERROR..!! TIPO DE PRACTICA, DESCRIPCION O CANTIDAD INCOMPLETOS");
        }
    }

    function limpiar() {
        $('#tipo_estudio').prop('selected', false).find('option:first').prop('selected', true);
        $("#descripcionmedica").selectpicker('refresh');
        $("#cantidad").val(1);
        $("#importe").val("");
    }

    function totales() {
        $("#total").html("$ " + total);
        $("#total_pagar").val(total);
    }

    function evaluar() {
        if (total > 0) {
            $("#guardar").show();
        } else {
            $("#guardar").hide();
        }
    }

    function eliminar(index) {
        total = total - subtotal[index];
        totales();
        $("#fila" + index).remove();
        evaluar();
    }

    function limpiarTabla() {
        total = 0;
        $("#total").html("$ " + total);
        $("#total_pagar").val(total);
        $('#detalles tbody').children().remove();
        $('#beneficiario tbody').children().remove();
    }
</script>
@endsection