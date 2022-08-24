// VALIDACIONES PARA ORDEN CREATE
function validaOrdenCreate() {
    $("#orden_create").ajaxSubmit({
        beforeSubmit: function () {
            $('#orden_create').validate({
                errorPlacement: function (label, element) {
                    label.insertAfter(element);
                },
            });
            return $('#orden_create').valid();
        },
        target: '#output',
        dataType: 'json',
        success: afterSuccess,
        error: error
    });

    function error(response, xhr) {
        //   console.log(response, xhr)
    }

    function afterSuccess(response) {
        if (response.resultados == "ok") {
            swal({
                title: "ATENCION...!!!",
                text: "REGISTRO EXITOSO",
                icon: "success",
                buttons: "ACEPTAR",
                closeOnClickOutside: false,
            }).then(function () {
                // ruta para DESARROLLO
                window.location.replace("/ordenes");
                // ruta para HOSTING
                // window.location.replace("../public/ordenes");
            });
        }

        if (response.resultados == "error") {
            swal({
                title: "HA OCURRIDO UN ERROR",
                text: response.error,
                icon: "error",
                buttons: "ACEPTAR",
                closeOnClickOutside: false,
            }).then(function () {
                //window.location.replace("indexSecuestro");
            });
        }
    }
}
// VALIDACIONES PARA ORDEN EDIT
function validaOrdenEdit() {
    $("#orden_edit").ajaxSubmit({
        beforeSubmit: function () {
            $('#orden_edit').validate({
                errorPlacement: function (label, element) {
                    label.insertAfter(element);
                },
                rules: {
                    estado: {
                        required: true
                    },
                    obs_anulo: {
                        maxlength: 150,
                        required: true
                    }
                },
                messages: {
                    estado: {
                        required: "CAMPO OBLIGATORIO"
                    },
                    obs_anulo: {
                        maxlength: "150 CARACTERES MÁXIMO",
                        required: "CAMPO OBLIGATORIO"
                    },
                }
            });
            return $('#orden_edit').valid();
        },
        target: '#output',
        dataType: 'json',
        success: afterSuccess,
        error: error
    });

    function error(response, xhr) {
        //   console.log(response, xhr)
    }

    function afterSuccess(response) {
        if (response.resultados == "ok") {
            swal({
                title: "ATENCION...!!!",
                text: "MODIFICACION EXITOSA",
                icon: "success",
                buttons: "ACEPTAR",
                closeOnClickOutside: false,
            }).then(function () {
                // RUTA DESARROLLO
                window.location.replace("/ordenes");
                // ruta para HOSTING
                // window.location.replace("../public/ordenes");
            });
        }

        if (response.resultados == "error") {
            swal({
                title: "HA OCURRIDO UN ERROR",
                text: response.error,
                icon: "error",
                buttons: "ACEPTAR",
                closeOnClickOutside: false,
            }).then(function () {
                //window.location.replace("indexSecuestro");
            });
        }
    }
}
