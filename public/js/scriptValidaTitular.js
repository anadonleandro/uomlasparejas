 // VALIDACIONES PARA titular CREATE


 ////////////////////////// EN PROCESO ////////////////////////////////////////////////


 function validaTitularCreate() {
     $("#titular_create").ajaxSubmit({
         beforeSubmit: function () {
             $('#titular_create').validate({
                 errorPlacement: function (label, element) {
                     label.insertAfter(element);
                 },
                 rules: {
                     nro_doc: {
                         number: true,
                         maxlength: 8,
                         required: true
                     },
                     cuil: {
                         maxlength: 11
                     },
                     nom_titular: {
                         maxlength: 100,
                         required: true
                     },
                     telefono: {
                         maxlength: 40
                     },
                     direccion: {
                         maxlength: 60,
                         required: true
                     },
                     domicilio: {
                         maxlength: 50,
                         required: true
                     },
                     telefono: {
                         maxlength: 30
                     },
                     direccion: {
                         maxlength: 60,
                         required: true
                     },
                     email: {
                         maxlength: 50
                     },
                     cbu: {
                         maxlength: 22
                     },
                     fec_nacimiento: {
                         required: true,
                         date: true
                     },
                     fec_alta: {
                         required: true,
                         date: true
                     },
                     obs: {
                         maxlength: 255
                     }
                 },
                 messages: {
                     nro_doc: {
                         number: "SÓLO NÚMEROS",
                         maxlength: "8 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     cuil: {
                         maxlength: "11 CARACTERES MÁXIMO"
                     },
                     nom_titular: {
                         maxlength: "100 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     telefono: {
                         maxlength: "40 CARACTERES MÁXIMO"
                     },
                     direccion: {
                         maxlength: "60 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     telefono: {
                         maxlength: "30 CARACTERES MÁXIMO"
                     },
                     email: {
                         maxlength: "50 ES EL MÁXIMO PERMITIDO"
                     },
                     fec_nacimiento: {
                         required: "CAMPO OBLIGATORIO",
                         date: "SÓLO FECHAS DD/MM/AAAA"
                     },
                     fec_alta: {
                         required: "CAMPO OBLIGATORIO",
                         date: "SÓLO FECHAS DD/MM/AAAA"
                     },
                     obs: {
                         maxlength: "255 ES EL MÁXIMO PERMITIDO"
                     },
                 }
             });
             return $('#titular_create').valid();
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
                 // PARA DESARROLLO
                 window.location.replace("titulares");
                 // PARA HOSTING
                // window.location.replace("../titulares");

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
 // VALIDACIONES PARA TIRULAR EDIT
 function validaTitularEdit() {
     $("#titular_edit").ajaxSubmit({
         
         beforeSubmit: function () {
             $('#titular_edit').validate({
                 errorPlacement: function (label, element) {
                     label.insertAfter(element);
                 },
                 rules: {
                     nro_doc: {
                         number: true,
                         maxlength: 8,
                         required: true
                     },
                     cuil: {
                         maxlength: 11
                     },
                     nom_titular: {
                         maxlength: 100,
                         required: {
                             depends: function () {
                                 $(this).val($.trim($(this).val()));
                                 return true;
                             }
                         },
                     },
                     telefono: {
                         maxlength: 40
                     },
                     direccion: {
                         maxlength: 60,
                         required: {
                             depends: function () {
                                 $(this).val($.trim($(this).val()));
                                 return true;
                             }
                         },
                     },
                     telefono: {
                         maxlength: 30
                     },
                     mail: {
                         maxlength: 50
                     },
                     cbu: {
                         maxlength: 22
                     },
                     fec_nacimiento: {
                         required: true,
                         date: true
                     },
                     fec_alta: {
                         required: true,
                         date: true
                     },
                     obs: {
                         maxlength: 255
                     }
                 },
                 messages: {
                     nro_doc: {
                         number: "SÓLO NÚMEROS",
                         maxlength: "8 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     cuil: {
                         maxlength: "11 CARACTERES MÁXIMO"
                     },
                     nom_titular: {
                         maxlength: "100 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     telefono: {
                         maxlength: "40 CARACTERES MÁXIMO"
                     },
                     direccion: {
                         maxlength: "60 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     domicilio: {
                         maxlength: "50 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     telefono: {
                         maxlength: "30 CARACTERES MÁXIMO"
                     },
                     mail: {
                         maxlength: "50 ES EL MÁXIMO PERMITIDO"
                     },
                     fec_nacimiento: {
                         required: "CAMPO OBLIGATORIO",
                         date: "SÓLO FECHAS DD/MM/AAAA"
                     },
                     fec_alta: {
                         required: "CAMPO OBLIGATORIO",
                         date: "SÓLO FECHAS DD/MM/AAAA"
                     },
                     obs: {
                         maxlength: "255 ES EL MÁXIMO PERMITIDO"
                     },
                 }
             });
             return $('#titular_edit').valid();
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
                 // PARA DESARROLLO
                 window.location.replace("/titulares");
                   // PARA HOSTING
                // window.location.replace("../titulares");
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
