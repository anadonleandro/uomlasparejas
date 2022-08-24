 function procesaPagos() {
     $("#procesa_pagos").ajaxSubmit({
         beforeSubmit: function () {
             $('#procesa_pagos').validate({
                 errorPlacement: function (label, element) {
                     label.insertAfter(element);
                 },
             });
             return $('#procesa_pagos').valid();
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
         console.log(response.resultado);
         if (response.resultado == "ok") {
             swal({
                 title: "ATENCION...!!!",
                 text: "SE PROCESARON EN TOTAL: " + response.cantidad + " REGISTROS - DEUDAS GENERADAS: " + response.generada + " - PAGOS EXTRAS: " + response.extras + " - DEUDAS NO GENERADAS: " + response.noGenerada + " - CONVENIOS: " + response.convenio,
                 icon: "success",
                 buttons: "ACEPTAR",
                 closeOnClickOutside: false,
             }).then(function () {
                 // para desarrollo
                 window.location.replace("home");
                 // PARA HOSTING
                 // window.location.replace("../home");
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
                 //window.location.replace("indexSecuestro");
                 window.location.replace("home");
             });
         }
     }
 }
 // VALIDACIONES PARA EMPRESA EDIT
 function validaEmpresaEdit() {
     $("#empresa_edit").ajaxSubmit({
         beforeSubmit: function () {
             $('#empresa_edit').validate({
                 errorPlacement: function (label, element) {
                     label.insertAfter(element);
                 },
                 rules: {
                     cod_empresa: {
                         maxlength: 5,
                         required: true
                     },
                     nom_empresa: {
                         maxlength: 50,
                         required: true
                     },
                     cuit: {
                         maxlength: 11
                     },
                     actividad: {
                         maxlength: 40,
                         required: true
                     },
                     domicilio: {
                         maxlength: 50,
                         required: true
                     },
                     telefono: {
                         maxlength: 30
                     },
                     email: {
                         maxlength: 40
                     },
                     fecha_inicio_actividad: {
                         required: true,
                         date: true
                     },
                     fecha_alta: {
                         required: true,
                         date: true
                     },
                     cantidad_obreros: {
                         number: true
                     },
                     cantidad_afiliados: {
                         number: true
                     },
                     obs: {
                         maxlength: 255
                     }
                 },
                 messages: {
                     cod_empresa: {
                         maxlength: "5 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     nom_empresa: {
                         maxlength: "50 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     cuit: {
                         maxlength: "11 CARACTERES MÁXIMO"
                     },
                     actividad: {
                         maxlength: "40 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     domicilio: {
                         maxlength: "50 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     telefono: {
                         maxlength: "30 CARACTERES MÁXIMO"
                     },
                     email: {
                         maxlength: "40 ES EL MÁXIMO PERMITIDO"
                     },
                     fecha_inicio_actividad: {
                         required: "CAMPO OBLIGATORIO",
                         date: "SÓLO FECHAS DD/MM/AAAA"
                     },
                     fecha_alta: {
                         required: "CAMPO OBLIGATORIO",
                         date: "SÓLO FECHAS DD/MM/AAAA"
                     },
                     cantidad_obreros: {
                         number: "SÓLO NÚMEROS"
                     },
                     cantidad_afiliados: {
                         number: "SÓLO NÚMEROS"
                     },
                     obs: {
                         maxlength: "255 ES EL MÁXIMO PERMITIDO"
                     },
                 }
             });
             return $('#empresa_edit').valid();
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
                 // para desarrollo
                 window.location.replace("/empresas");
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
     }
 }

 // VALIDACIONES PARA ELEMENTO EDIT
 function validaElementoEdit() {
     $("#notaelemento_edit").ajaxSubmit({
         beforeSubmit: function () {
             $('#notaelemento_edit').validate({
                 errorPlacement: function (label, element) {
                     label.insertAfter(element);
                 },
                 rules: {
                     descripcion_ubicacion: {
                         required: {
                             depends: function () {
                                 $(this).val($.trim($(this).val()));
                                 return true;
                             }
                         },
                         minlength: 5,
                         maxlength: 50
                     },
                     detalle: {
                         required: {
                             depends: function () {
                                 $(this).val($.trim($(this).val()));
                                 return true;
                             }
                         },
                         minlength: 10,
                         maxlength: 500
                     }
                 },
                 messages: {
                     descripcion_ubicacion: {
                         required: "CAMPO OBLIGATORIO",
                         maxlength: "50 ES EL MÁXIMO PERMITIDO",
                         minlength: "5 ES EL MÍNIMO PERMITIDO"
                     },
                     detalle: {
                         required: "CAMPO OBLIGATORIO",
                         maxlength: "500 ES EL MÁXIMO PERMITIDO",
                         minlength: "10 ES EL MÍNIMO PERMITIDO"
                     }
                 }
             });
             return $('#notaelemento_edit').valid();
         },
         target: '#output',
         dataType: 'json',
         success: afterSuccess,
         error: error
     });

     function error(response, status, xhr) {

     }

     function afterSuccess(response, status, xhr) {
         if (response.resultados == "ok") {
             swal({
                 title: "ELEMENTO EDITADO",
                 text: "MODIFICACIÓN EXITOSA",
                 icon: "success",
                 buttons: "ACEPTAR",
                 closeOnClickOutside: false,
             }).then(function () {
                 window.location.replace("indexSecuestro");
             });
          
         }
         if (response.resultados == "error") {
             swal({
                 title: "HA OCURRIDO UN ERROR",
                 text: response.error,
                 buttons: "ACEPTAR",
                 closeOnClickOutside: false,
             }).then(function () {
                 window.location.replace("../editSecuestro");;
             });
         }
         if (response.resultados == "error2") {
             swal({
                 title: "ATENCIÓN...!!!",
                 text: "No se realizó ninguna modificación",
                 icon: "info",
                 buttons: "ACEPTAR",
                 closeOnClickOutside: false,
             }).then(function () {});
         }
     }
 }
