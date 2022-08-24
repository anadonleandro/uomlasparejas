function mensajeDialog(titulo,texto){

    swal({
        title: titulo,
        text: texto,
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((ok) => {
        if (ok) {
        return true
        } else {
            return false
        }
    });
}