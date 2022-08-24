 // VALIDACIONES PARA FAMILIAR CREATE
 function validaFamiliarCreate() {
     $("#familiar_create").ajaxSubmit({
         beforeSubmit: function () {
             $('#familiar_create').validate({
                 errorPlacement: function (label, element) {
                     label.insertAfter(element);
                 },
                 rules: {
                    nom_familiar: {
                         maxlength: 100,
                         required: true
                     },
                     nro_doc: {
                         maxlength: 10,
                         required: true
                     },
                     cuil: {
                         maxlength: 11
                     },
                     telefono: {
                         maxlength: 20
                     },
                     direccion: {
                         maxlength: 50
                     },
                     obs: {
                         maxlength: 255
                     }
                 },
                 messages: {
                    nom_familiar: {
                         maxlength: "100 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     nro_doc: {
                         maxlength: "10 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     cuil: {
                         maxlength: "11 CARACTERES MÁXIMO"
                     },
                     telefono: {
                         maxlength: "20 CARACTERES MÁXIMO"
                     },
                     direccion: {
                         maxlength: "50 ES EL MÁXIMO PERMITIDO"
                     },
                     obs: {
                         maxlength: "255 ES EL MÁXIMO PERMITIDO"
                     },
                 }
             });
             return $('#familiar_create').valid();
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
                 // para desarrollo
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
 // VALIDACIONES PARA FAMILIAR EDIT
 function validaFamiliarEdit() {
     $("#familiar_edit").ajaxSubmit({
         beforeSubmit: function () {
             $('#familiar_edit').validate({
                 errorPlacement: function (label, element) {
                     label.insertAfter(element);
                 },
                 rules: {
                     nom_familiar: {
                         maxlength: 100,
                         required: true
                     },
                     nro_doc: {
                         maxlength: 8
                     },
                     cuil: {
                         maxlength: 11
                     },
                     direccion: {
                         maxlength: 50
                     },
                     telefono: {
                         maxlength: 20
                     },
                     fecha_alta: {
                         required: true,
                         date: true
                     },
                     fec_nacimiento: {
                         required: true,
                         date: true
                     },
                     obs: {
                         maxlength: 255
                     }
                 },
                 messages: {
                     nom_familiar: {
                         maxlength: "100 CARACTERES MÁXIMO",
                         required: "CAMPO OBLIGATORIO"
                     },
                     nro_doc: {
                         maxlength: "8 CARACTERES MÁXIMO"
                     },
                     cuil: {
                         maxlength: "11 CARACTERES MÁXIMO"
                     },
                     direccion: {
                         maxlength: "50 CARACTERES MÁXIMO"
                     },
                     telefono: {
                         maxlength: "20 CARACTERES MÁXIMO"
                     },
                     fec_alta: {
                         required: "CAMPO OBLIGATORIO",
                         date: "SÓLO FECHAS DD/MM/AAAA"
                     },
                     fec_nacimiento: {
                         required: "CAMPO OBLIGATORIO",
                         date: "SÓLO FECHAS DD/MM/AAAA"
                     },
                     obs: {
                         maxlength: "255 ES EL MÁXIMO PERMITIDO"
                     },
                 }
             });
             return $('#familiar_edit').valid();
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
