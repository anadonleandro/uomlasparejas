    $(document).ready(function () {      
        
        $.ajax({ //////////////////////////////// ETIQUETA TOTAL EMPRESAS ///////////////
            type: 'get',
            url: 'total_general_empresas',
            dataType: 'json',
            success: function (response) {
                $("#total_empresas").text(response.totalEmpresas);

                /////// color de texto (para probar despues)
                if (response.totalEmpresas < 1) {
                    $("#total_empresas").css('color', 'steelblue');
                } else {
                    $("#total_empresas").css('font-weight', 'bold');
                }
            },
            error: function ( errorThrown) {
                console.log(errorThrown);
            }
        });

        $.ajax({ //////////////////////////////// ETIQUETA TOTAL TITULARES ///////////////
            type: 'get',
            url: 'total_titulares',
            dataType: 'json',
            success: function (response) {
                $("#total_titulares").text(response.total_titulares);

                /////// color de texto (para probar despues)
                if (response.elementos_deposito_propio < 1) {
                    $("#total_titulares").css('color', 'steelblue');
                } else {
                    $("#total_titulares").css('font-weight', 'bold');
                }
            },
            error: function ( errorThrown) {
                console.log(errorThrown);
            }
        }); 
    })

