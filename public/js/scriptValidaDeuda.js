 // VALIDACIONES PARA DEUDA CREATE
 function validaDeudaCreate() {
     $("#deuda_create").ajaxSubmit({
         beforeSubmit: function () {
             $('#deuda_create').validate({
                 errorPlacement: function (label, element) {
                     label.insertAfter(element);
                 },
                 rules: {
                     tipo_cuenta: {
                         required: true
                     },
                     periodo: {
                         required: true
                     },
                     fecha_vto: {
                         required: true
                     }
                 },
                 messages: {
                     tipo_cuenta: {
                         required: "CAMPO OBLIGATORIO"
                     },
                     periodo: {
                         required: "CAMPO OBLIGATORIO"
                     },
                     fecha_vto: {
                         required: "CAMPO OBLIGATORIO"
                     },
                 }
             });
             return $('#deuda_create').valid();
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
                 text: "Se generaron " + response.cantidad + " deudas de empresa",
                 icon: "success",
                 buttons: "ACEPTAR",
                 closeOnClickOutside: false,
             }).then(function () {
                 // para desarrollo
                 //window.location.replace("empresas");
                 // PARA HOSTING
                 // window.location.replace("../empresas");
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
         if (response.resultados == "errorEmpresa") {
             swal({
                 title: "ATENCION",
                 text: response.msj,
                 icon: "info",
                 buttons: "ACEPTAR",
                 closeOnClickOutside: false,
             }).then(function () {
                 //window.location.replace("indexSecuestro");
             });
         }
     }
 }
