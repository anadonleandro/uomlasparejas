/*function mostrar() {*/
$(document).ready(function () {

    token = getMeta('csrf-token'); // recuperamos el token de session

    $(".loader").css('visibility', 'visible');
    $.ajax({
        method: 'GET',
        url: 'archivos/resultado',

        dataType: 'json', // a JSON object to send back
        success: function (response) { // What to do if we succeed
            var data = response.resultados;
            $('#tablaArchivosExcel').dataTable({
                initComplete: function () {
                    $('.buttons-pdf').html('<button class="btn btn-danger" title="EXPORTAR A PDF"><i class="far fa-file-pdf"></i></button>')
                    $('.buttons-excel').html('<button class="btn btn-success" title="EXPORTAR A EXCEL"><i class="far fa-file-excel"></i></button>')
                    $('.buttons-print').html('<button class="btn btn-info" title="IMPRIMIR EN PANTALLA"><i class="fas fa-print"></i></button>')
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        },

                        title: ' LISTADO GENERAL DE ARCHIVOS ',

                        customize: function (doc) {
                            doc.pageMargins = [30, 30, 30, 30];
                            doc.defaultStyle.fontSize = 10;
                            doc.styles.tableHeader.fontSize = 12;
                            doc.styles.title.fontSize = 12;
                            // Remove spaces around page title
                            doc.content[0].text = doc.content[0].text.trim();
                            // Create a footer
                            doc['footer'] = (function (page, pages) {
                                return {
                                    columns: [
                                        'Desarrollo de Software',
                                        {
                                            // This is the right column
                                            alignment: 'right',
                                            text: ['Página ', {
                                                text: page.toString()
                                            }, ' de ', {
                                                text: pages.toString()
                                            }]
                                        }
                                    ],
                                    margin: [10, 0]
                                }
                            });
                            doc['header'] = (function (page, pages) {
                                return {
                                    columns: [
                                        'test - v 1.0',

                                        {
                                            // This is the right column
                                            alignment: 'center',
                                            image: 'data:image/jpeg;base64,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'
                                        }
                                    ],
                                    margin: [10, 0]
                                }
                            });
                        },
                    },
                    {
                        extend: 'excelHtml5',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        },

                        pageSize: 'LEGAL',
                        title: ' LISTADO GENERAL DE ARCHIVOS'
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6]
                        },
                        autoPrint: false,
                        title: ' LISTADO GENERAL DE ARCHIVOS'
                    }
                ],

                "data": data,
                "paging": true,
                "scrollY": 380,
                "order": [2, "ASC"],

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

                columns: [{
                        data: "id"
                    },
                    {
                        "data": "nombre_archivo"
                    },
                    {
                        "data": "fecha_proceso"
                    },
                    {
                        "data": "cantidad"
                    },
                    {
                        "data": "generada"
                    },
                    {
                        "data": "extras"
                    },
                    {
                        "data": "no_generada"
                    },
                    {
                        "data": "convenio"
                    },
                    {
                        "data": "id_usr"
                    }
                ],
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [1],
                    },
                    {
                        "targets": [2],
                    },
                    {
                        "targets": [3],
                        className: 'columnaConNumero'
                    },
                    {
                        "targets": [4],
                        className: 'columnaConNumero'
                    },
                    {
                        "targets": [5],
                        className: 'columnaConNumero'
                    },
                    {
                        "targets": [6],
                        className: 'columnaConNumero'
                    },
                    {
                        "targets": [7],
                        className: 'columnaConNumero'
                    },
                ]
            });

            $(".loader").css('visibility', 'hidden');
        },

        error: function (_jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
})

function getDataCell() {
    var table = $('#tablaSec').DataTable();
    $('#tablaSec tbody').on('click', 'tr', function () {
        var indice = table.row(this).index();
        var clave = table.cell({
            row: indice,
            column: 1
        }).data();
    });
}

function getMeta(metaName) { //// metodo que devuelve el valor  
    const metas = document.getElementsByTagName('meta');
    for (let i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute('name') === metaName) {
            return metas[i].getAttribute('content');
        }
    }
    return '';
}
