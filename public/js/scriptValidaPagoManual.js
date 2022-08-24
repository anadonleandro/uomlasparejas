 // VALIDACIONES PARA DEUDA MANUAL CREATE
 function validaPagoManualCreate() {
     $("#pago_manual_create").ajaxSubmit({
         beforeSubmit: function () {
             $('#pago_manual_create').validate({
                 errorPlacement: function (label, element) {
                     label.insertAfter(element);
                 },
                 rules: {
                     ipte_total_remuneracion: {
                         maxlength: 12,
                         required: true
                     },
                     ipte_depositado: {
                         maxlength: 12,
                         required: true
                     }
                 },
                 messages: {
                     ipte_total_remuneracion: {
                         maxlength: "12 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     ipte_depositado: {
                         maxlength: "12 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     }
                 }
             });
             return $('#pago_manual_create').valid();
         },
         target: '#output',
         dataType: 'json',
         success: afterSuccess,
         error: error
     });

     function error(response, xhr) {}

     function afterSuccess(response) {
         if (response.resultado == "ok") {
             swal({
                 title: "ATENCION...!!!",
                 text: "SE PROCESARON EN TOTAL: " + response.cantidad + " REGISTROS - DEUDAS GENERADAS: " + response.generada + " - PAGOS EXTRAS: " + response.extras + " - DEUDAS NO GENERADAS: " + response.noGenerada + " - CONVENIOS: " + response.convenio,
                 icon: "success",
                 buttons: "ACEPTAR",
                 closeOnClickOutside: false,
             }).then(function () {
                 // para desarrollo
                 window.location.replace("pagosManuales");
                 // PARA HOSTING
                 // window.location.replace("../pagosManuales");
             });
         }

         if (response.resultado == "error") {
             swal({
                 title: "HA OCURRIDO UN ERROR",
                 text: response.error,
                 icon: "error",
                 buttons: "ACEPTAR",
                 closeOnClickOutside: false,
             }).then(function () {
                 window.location.replace("pagosManuales");
             });
         }
     }
 }
 // VALIDACION PARA PAGO MANUAL DELETE
 function validaPagoManualDelete() {
    $("#pago_manual_delete").ajaxSubmit({
        beforeSubmit: function () {
            $('#pago_manual_delete').validate({
                errorPlacement: function (label, element) {
                    label.insertAfter(element);
                }
            });
            return $('#pago_manual_delete').valid();
        },
        target: '#output',
        dataType: 'json',
        success: afterSuccess,
        error: error
    });

    function error(response, xhr) {}

    function afterSuccess(response) {
        if (response.resultado == "ok") {
            swal({
                title: "ATENCION...!!!",
                text: "IMPUTACION MANUAL ELIMINIDA",
                icon: "success",
                buttons: "ACEPTAR",
                closeOnClickOutside: false,
            }).then(function () {
                // para desarrollo
                window.location.replace("pagosManuales");
                // PARA HOSTING
                // window.location.replace("../pagosManuales");
            });
        }

        if (response.resultado == "error") {
            swal({
                title: "HA OCURRIDO UN ERROR",
                text: response.error,
                icon: "error",
                buttons: "ACEPTAR",
                closeOnClickOutside: false,
            }).then(function () {
                window.location.replace("pagosManuales");
            });
        }
    }
}
