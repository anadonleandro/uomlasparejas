var cont = 0;
$(document).ready(function () {
    $("#buscar").focusout(function () {
        var dni = $('#buscar').val();
        var tipo = $('#tipo').val();

        $.ajax({
                type: 'GET',
                url: '/buscar_beneficiario',
                data: {
                    'tipo': tipo,
                    'dni': dni
                }
            })
            .done(function (response) {
                if (response.error) {
                    // error en el controlador
                    swal({
                        title: "ERROR",
                        text: response.error,
                        icon: "error",
                        buttons: "ACEPTAR",
                        closeOnClickOutside: false,
                    });
                } else {
                    // sin errores en controlador
                    if (response.beneficiario == null) {
                        //si no encuentra persona
                        swal({
                            title: "ATENCION..!!",
                            text: "SIN REGISTROS PARA EL DNI INGRESADO",
                            icon: "info",
                            buttons: "ACEPTAR",
                            closeOnClickOutside: false,
                        });
                    } else {
                        // si encontro persona
                        if (tipo == 0) {
                            // SI ES TITULAR
                            id_titular = (response.beneficiario.id_titular);
                            apenom = (response.beneficiario.nom_titular);
                            tipoafiliado = "TITULAR";
                            dni = (response.beneficiario.nom_tipo + " - " + response.beneficiario.nro_doc);
                            if (response.beneficiario.sexo == 1) {
                                sexo = "MASCULINO";
                            } else {
                                sexo = "FEMENINO";
                            }
                            titular = (response.beneficiario.nom_titular);
                            if (cont == 1) {
                                swal({
                                    title: "ATENCION..!!",
                                    text: "YA SELECCIONO UN TITULAR, FAMILIAR",
                                    icon: "info",
                                    buttons: "ACEPTAR",
                                    closeOnClickOutside: false,
                                });
                            } else {
                                var fila = '<tr class="selected" id="fila' + cont + '"><td><button type="button" class="btn btn-warning" onclick="quitar(' + cont +
                                    ');">X</button></td><td><input type="hidden" name="apenom[]" value="' + id_titular + '">' + apenom +
                                    '</td><td><input type="hidden" name="tipoafiliado[]">' + tipoafiliado +
                                    '</td><td><input type="hidden" name="dni[]">' + dni +
                                    '</td><td><input type="hidden" name="sexo[]">' + sexo +
                                    '</td><td><input type="hidden" name="titular[]">' + titular +
                                    '</td></tr>';
                                cont++;
                                $('#beneficiario').append(fila);
                            }


                            $('#id_titular').val(response.beneficiario.id_titular);
                            $('#apenom').val(response.beneficiario.nom_titular);
                            $('#tipoafiliado').val("TITULAR");
                            $('#dni').val(response.beneficiario.nom_tipo + " - " + response.beneficiario.nro_doc);
                            if (response.beneficiario.sexo == 1) {
                                $('#sexo').val("MASCULINO");
                            } else {
                                $('#sexo').val("FEMENINO");
                            }
                            $('#titular').val(response.beneficiario.nom_titular);
                            $('#tipoBeneficiario').val(0);

                        } else {
                            // SI ES FAMILIAR
                            id_familiar = (response.beneficiario.id_familiar);
                            apenom = (response.beneficiario.nom_familiar);
                            tipoafiliado = (response.beneficiario.nom_vinculo);
                            dni = (response.beneficiario.nom_tipo + " - " + response.beneficiario.nro_doc);
                            if (response.beneficiario.sexo == 1) {
                                sexo = "MASCULINO";
                            } else {
                                sexo = "FEMENINO";
                            }
                            titular = (response.beneficiario.nom_titular);
                            if (cont == 1) {
                                swal({
                                    title: "ATENCION..!!",
                                    text: "YA SELECCIONO UN TITULAR, FAMILIAR",
                                    icon: "info",
                                    buttons: "ACEPTAR",
                                    closeOnClickOutside: false,
                                });
                            } else {
                                var fila = '<tr class="selected" id="fila' + cont + '"><td><button type="button" class="btn btn-warning" onclick="quitar(' + cont +
                                    ');">X</button></td><td><input type="hidden" name="apenom[]" value="' + id_familiar + '">' + apenom +
                                    '</td><td><input type="hidden" name="tipoafiliado[]">' + tipoafiliado +
                                    '</td><td><input type="hidden" name="dni[]">' + dni +
                                    '</td><td><input type="hidden" name="sexo[]">' + sexo +
                                    '</td><td><input type="hidden" name="titular[]">' + titular +
                                    '</td></tr>';
                                cont++;
                                $('#beneficiario').append(fila);
                            }

                            $('#id_titular').val(response.beneficiario.id_titular);
                            $('#id_familiar').val(response.beneficiario.id_familiar);
                            $('#apenom').val(response.beneficiario.nom_familiar);
                            $('#tipoafiliado').val(response.beneficiario.nom_vinculo);
                            $('#dni').val(response.beneficiario.nom_tipo + " - " + response.beneficiario.nro_doc);
                            if (response.beneficiario.sexo == 1) {
                                $('#sexo').val("MASCULINO");
                            } else {
                                $('#sexo').val("FEMENINO");
                            }
                            $('#titular').val(response.beneficiario.nom_titular);
                            $('#tipoBeneficiario').val(1);
                        }
                    }
                }
            })
            .fail(function (_jqXHR, textStatus, errorThrown, response) { // What to do if we fail

                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            })
        //.fail(function () {})
    });
});

function quitar(index) {
    cont = 0;
    $("#fila" + index).remove();
}
