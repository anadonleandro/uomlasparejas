function cargarPrecio() {

    var id = $('#descripcionmedica').val();

    $.ajax({
        type: 'get',
        url: 'getPrecioPmo',
        data: {
            'id': id
        },
        dataType: 'json',
        success: function (response) {
            $("#importe").val(response.precioFinal);

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}
