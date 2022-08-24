function filtrar() {
    token = getMeta('csrf-token'); // recuperamos el token de session
    if ($.fn.DataTable.isDataTable('#tablaFamiliar')) {
        $('#tablaFamiliar').DataTable().clear();
        $('#tablaFamiliar').DataTable().destroy();
    }
    $("#cantidadEncontrada").empty(); // hacemos un clear del campo texto contador
    var parametro;
    var opcion;
    var valor = $("#opcion").val();
    switch (valor) {
        case '1': // buscamos por  apellido y nombre
            parametro = $('#paramTexto').val();
            opcion = 1;
            break;
        case '2': // buscamos por  DNI
            parametro = $('#paramNumero').val();
            opcion = 2;
            break;
    }

    $(".mostrarTabla").css('visibility', 'visible');
    $.ajax({
        method: 'GET',
        url: './familiar/resultado',
        data: {
            'parametro': parametro,
            'opcion': opcion,
        },
        dataType: 'json', // a JSON object to send back
        success: function (response) { // What to do if we succeed
            $("#cantidadEncontrada").append(Object.keys(response.resultados).length + " FAMILIARES ENCONTRADOS");
            var data = response.resultados;
            $('#tablaFamiliar').dataTable({
                initComplete: function () {
                    $('.buttons-pdf').html('<button class="btn btn-danger" title="EXPORTAR A PDF"><i class="fa fa-file-pdf-o"></i></button>')
                    $('.buttons-excel').html('<button class="btn btn-success" title="EXPORTAR A EXCEL"><i class="fa fa-file-excel-o"></i></button>')
                },
                // stateSave:true, 
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'pdfHtml5',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        title: ' RESULTADO BUSQUEDA DE FAMILIAR ',

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
                                        'Area Desarrollo de Software',
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
                                        'Sistema de Legajos - v 1.0',

                                        {
                                            // This is the right column
                                            alignment: 'center',
                                            image: 'data:image/jpeg;base64,/9j/4QBWRXhpZgAATU0AKgAAAAgABAESAAMAAAABAAEAAAEaAAUAAAABAAAAPgEbAAUAAAABAAAARgEoAAMAAAABAAIAAAAAAAAAAAEsAAAAAQAAASwAAAAB/+AAEEpGSUYAAQEAAAEAAQAA/9sAQwABAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEB/9sAQwEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEB/8AAEQgAKAApAwERAAIRAQMRAf/EABkAAAMBAQEAAAAAAAAAAAAAAAYJCggFB//EACYQAAIDAQEAAgICAgMBAAAAAAQFAgMGBwEICRMUABUWFxJWltb/xAAbAQACAgMBAAAAAAAAAAAAAAAGBwIEAAMFAf/EADQRAAICAAUDAgMGBQUAAAAAAAECAxEABAUSIQYTMSJBI1FhBxQVMnGhFiUzQpFSgbHB4v/aAAwDAQACEQMRAD8AvbcPkedFqO0DhWjBuPWq6TGxwy8W1m5PHVqF1d5VlVUzmrMsVcuEjL2804kcQaFpF1VcoPIkYt2VBxyxoc8AWeLJ8D3xmOJ70HEe5u3XjazPmZqpXJ1F6C0EOV3rPKvLoHCmC22UGD3Q9j6PYLZbEj32MKPZzlGPsWmjCsQ6ekEmyABXm/09/wB684z5D3Pge5+n6/TCOtn9scUneqGQefuccsSulmZDtWM/PPWWP31yb0jQDhD6K/N6vTeOMGyqwjW8tMvGzW7WRK/r/wAz4xguJetssvUEMG8vkwmYhdgVMaSq+XXvIwIGxR3dzHcBa0eaJDDoM8mmSZxmjWUPHJGhJDtCBJujA5tnDRk/VeK5w67/AHByqCNXpSejYgJE5EpOVtjtOnCXniXqjXtRIhRRdVV9E0q1i4jbXL2HqsAxh774KNdbBhR5uB40lMsarIAyW68qfHv5J4+vtgeo2Vo2CQRXII5Ir6DnBUj1OZ0/9t5mtEk0HqFrNE88StA2f9O7rAXtJqGn6d136DOCxsrYyBK/EV4CyAL9q/XLHss3rJG5IR1cr5CsGrx5omvIx6VK1YIvkWK+mO7/ACePMYu+wqoufxB7PYHMGuwTPUnWTPmlqrhQCzCKtsHJ0S1snDY1Rr/MsLJDqIpPrHkrcZlv+hp03D6gDNpmcRV3kwOyoeRuRWINfMcUR6uOD4xvyhC5qBmNKJEuhZB3DmjX/OJbOf8AOdH3Bq6Ci9WqsaBAF3rdXqHL23MJRJUanSD0xCGNpIeXsFhesYrshfYnHMzRJjJ2au5wFqVOLTfTun6/rjduLP5tIYjszOYlklZbY7XhCklXkYW1kk0CzsJG3sY6nPp2lhS2WjkkIBVFRFf8tl3NWIy9i6O75ccce/cfXWpnscXovlI20erY6WtBLeAqNBfz41qqJIDTtRDFnPWOMFXEhFjuBbAezk5YZZDy4naKxgfyTNh9mWRLRqc5KZFilvZJlx8Muiv8I/EBLKKUoxoVuvA03WM+54khhSDllBSVo6YsSDNe3gV+VhY8KPBKN5xtvg1eX1tegF6NyvZjw8xfTElnjNSx8KXlvhVDQNEycCoNa2zBg+5jWna/qa1Y/DLy7zXacW7SY8H6q0XV+nViKZzMT5NZDHC4aRFhQAlUey4UrtYqCe2Re0L6wxNpGeyOqIdsUUUg2Ex7VJmJYBjEa3FAtEkkNfBJFYpP+sQFeP8AEPANAjYnXak3RaJhbVobtGJIuTSab8i0uxFm6aF1gigSdQqxKGkjbOwlJ+dWWJfa3elY1j0jKBZlmLx96RwbbfMFf1GrYnk+okj5mySK6kw++TqqgBJXUV8geKA4r9K/fDBf4S4oYmZ+1DrvYdT0KfI+jZdur5okH8f0Isfa4LRNq5C+jeMHL/SJcXDRD30mWQnPKKGAiSFrjNs9JbVe6Vlp/r7V9by4XLRMMvknL/GAdZnoG1Y8ARsKFHyf7hwME+hZHLStJmHbutGFAjKgBSTRY2zcrwboGq8cWtj55PDsr9aPE0+GC9V0dp7e6b9JIpCU3Mr7Im7UH/GSTv1jWGaCYZnG8mIKohQpWt6FQUaZuRLNILA5+z7KL+BQmEESSQSy2VaQtmNj0xCKzGwgPI4PquyCRvq+VlzkqMXESyQwsRf9NtgNt/ajMSDzVki6NYzqVzHIw+O9gvkr7MPLmZBkDS8sV+OyU85Bt4f75dX7VSLZ5Gl1Wzqr/wCVjymllM6egqjbJKR6xrUnWyRfFGc/FUiKCRzeWBk3WpUEA2GZWFC7IHGDltN03+GjcUSZc5JqdvzNODXpYIfJ2qeR5qzycHP1w6bob34XfKDF7OBcebc/c5nS851DOh+dWi2d2zxjHTZvIekOAUC7y1pdlSLQoJoFU19H10lhaeez0VjF9ddZaCTptjmQpkfINJmEUBd86E9kGvne3kG6LeOMLbpWXM/isaQ3tXM7ITQYdpSocKPFAbwaJF0LtcMU+AOz7Nke5KDOF4np2hSaa39rcYqU2SLmk/G3hAy9/pCF9GktR1UMiCPQnV2dYoh7C2ZF1YZ99zodQ9B53qBZ1ghhkzWSEjK/x1EUe0UrM+xioUKGCU280l2bB/1DDp6pI4Cx5oue2UXb3F9RJcBvJb32nwOcVJf2+/8A+mZ//wBoX/8AJ/x2d2X/AE/v/wCMBuMp/YlDHCfFPpzfTL8+QeOvpFyRTlSuakha5xZ6hUmpKDjlXnjuiDQn9YiLCqAosjCDqTVVbEArmdQDLHTc22ahikjXLyAGSPuU7I4QCgWHPuBx5vFnKd37xF2mdW3pe1iLUMLBAIDA/I+cTlcb6nzBGh2vGu785j1vgfQBS1uhxallFXoMwyvKWB+aDMnWHIl/jObJGoVA0v2amSo3IYcRG+W6rOv1sVF0h1nJ0/LLlc2JXyLSCRZgx7kRPpKqp4MYjPrU0ws0pF4Mdf0JNUBZQizdoKUdbjlB+IvK7iJBa0XC0RR5AwDW/Xv8BWj3xKN89/kmLxcaNLo3jLrnOvlrgrSa4k21UaH/AF/TzyB82BEL4n/4lavleRI2MCLK4FyYa9X9ELmhqaS6auoNwcwVK5gJs2CNajokruDKQWsC3Fg4EBomtCH7j/MeybRowylOH3H1MxoBj6TtBI8KSKwSbbR8rUpVnFvjzlSsDwJXZTNcs0RKgna7JlC6FZ3m5eqBiCSAC9TYwHhX441i1z4dEUl/E7N8txmbAutOtZ9bjfKaUs/3b80ryBl7jx0YgikAGNlo0Td0aUBsFegaAmm1NKkYlACIin+jHZd2JYC3LAWVJBBIAYkVQ99YVae/4rZpiLnaEz319oQ9Kw/SVAH6ZkIVXUHo2Yi96/JEOOQ/1FMhmNqyVNA1FaRQLj/MzZey+kFRdFyjLHHGZIwZO2oUGRQoPIsnkmySbI9jxgY1Iuc1MHd2Pcc+s2VG40BYBAr29v8AGGIfwpxQwB9G5nius5+rJ9ATQ0Wag5TPSERJJdSpoagPpaqqXYI99Q7tUOzGEOtSNay1BpAg3pwRMKYQ8r5jLR5lCko3IatWFqSDakj5g8jElZkIZGKsPBUkEf7jGZb/AK8viJJI/TD8eRVS0CBogualXnOXItTREiz1rIJpor3JFTyoHMpp0vLfCGUTK2Z1l9pWj01jnmfgGm+ofdoAH3B6hSzu3EkWD6ixu+OebvG9c3mVZXE8u5CGW3Yi18A88iuK8f8ASfnH1kdjJ6q74lnGZ1eNAxy6yjsT6f4RCVRsySBAaqFHvt9ZZblKXlS1n5rtCizPoT2bJkRMQxktG+zkfxBJKkrZfIMwnAO0b96yK0QHFrvAYgceoeSMEy9RlMgbIfOsrKUPKA2uySieCAW9vPyvDm1vwU+LQ2BTYBhx/IuAFuVGypbVglUUaRyHBQYpKJbuUi9RZNkbFgaaQWuqXRpaTFYLqQblSb1c0YtG0+PLplxlIAEREDdsM3o2sDuYXe9b4/XyTgXfNZh3aQzSBnJY1I9Amxx6vAHA8Vj37nHMsXyXPXZTAqfUOctctntKWo04lauOeFzYM6koRZFwyNXefcQbBKnqCTilFFXCA0TJu9nbyuVTKIIolVIlvaijaLYgk0OATXPzxqZ2c7nZmY+7Ek/5OD7+WsRx/9k='
                                        }
                                    ],
                                    margin: [10, 0]
                                }
                            });
                        },
                    },
                    {
                        extend: 'excelHtml5',
                        orientation: 'portrait',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        title: ' RESULTADO BUSQUEDA DE FAMILIAR '
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        autoPrint: false,
                        title: ' RESULTADO BUSQUEDA DE FAMILIAR '
                    }
                ],

                "data": data,
                "paging": true,
                "scrollY": 300,
                "language": {
                    "url": "./datatables/Spanish.json"
                },

                columns: [{
                        data: "id_familiar"
                    },
                    {
                        "data": "nom_familiar"
                    },
                    {
                        "data": "nro_doc"
                    },
                    {
                        "data": "nom_titular"
                    },
                    {
                        "data": "nom_vinculo"
                    },
                    {
                        // btn edit familiar
                    }
                ],
                "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": 5,
                        "data": "id_familiar",
                        "width": "5%",
                        "orderable": false,
                        "className": 'dt-body-center',
                        "render": function (data, type, row, meta) {
                            return '<form action= "familiar/show" method="post"> <input hidden name="id_familiar" id="id_familiar" value="' + data + '" type="text"><input hidden name="_token" value="' + token + '" type="text"> <button type="submit" title="MOSTRAR FAMILIAR" class="btn btn-outline-primary"><i class="fas fa-eye"></i></button></form>'
                        }
                    },
                    {
                        "targets": 6,
                        "data": "id_familiar",
                        "width": "5%",
                        "orderable": false,
                        "className": 'dt-body-center',
                        "render": function (data, type, row, meta) {
                            return '<form action= "familiar/edit" method="post"><input hidden name="id_familiar" id="id_familiar" value="' + data + '" type="text"><input hidden name="_token" value="' + token + '" type="text"><button type="submit" title="MODIFICAR FAMILIAR" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></button></form>';
                        }
                    }
                ]
            });
            
        },
        error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
            /*  console.log(JSON.stringify(jqXHR)); */
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
}

function getDataCell() {
    var table = $('#tablaFamiliar').DataTable();
    $('#tablaFamiliar tbody').on('click', 'tr', function () {
        var indice = table.row(this).index();
        var legajo = table.cell({
            row: indice,
            column: 1
        }).data();
    });
}

$(document).on('init.dt', function (e, settings) {
    var api = new $.fn.dataTable.Api(settings);
    var state = api.state.loaded();
    // ... use `state` to restore information
});

function getMeta(metaName) { //// metodo que devuelve el valor  
    const metas = document.getElementsByTagName('meta');
    for (let i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute('name') === metaName) {
            return metas[i].getAttribute('content');
        }
    }
    return '';
}

function opcionChange() {
    $("#paramTexto").val(''); ///  limpiamos los input
    $("#paramNumero").val('');
    var valor = $("#opcion").children("option:selected").val();
    switch (valor) {
        case '1': // APELLIDO
            $("#paramNumero").css("display", "none");
            $("#paramTexto").css("display", "block");
            break;
        case '2': // DNI
            $("#paramNumero").css("display", "block");
            $("#paramTexto").css("display", "none");
            break;
    }
}

$(document).ready(function () {
    $("#paramTexto").keypress(function (e) { /// Metodo para Capturar el Enter  presionar un boton
        var p = e.which;
        if (p == 13) {
            $('#buscar').click();
        }
    });
    $("#paramNumero").keypress(function (e) { /// Metodo para Capturar el Enter  presionar un boton
        var p = e.which;
        if (p == 13) {
            $('#buscar').click();
        }
    });
    opcionChange();
});

$(window).on("load", function () { /// escuchamos cuando volvemos a la pagina que yahabia estado previamente cargada
    opcionChange(); // cuando se vuelva a ver la pagina se vuelve a ejucar el metodo
});
