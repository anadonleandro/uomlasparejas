//  VALIDAR NRO DE NOTA DE SECUESTRO: SOLO NUMEROS Y BARRA
function validarNota(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    tecla = String.fromCharCode(tecla)
    return /^[0-9\/]+$/.test(tecla);
}

// VALIDAR CUIJ: SOLO NUMEROS, GUIONES Y ESPACIOS
function validarCuij(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    tecla = String.fromCharCode(tecla)
    return /^[0-9\-" "]+$/.test(tecla);
}

