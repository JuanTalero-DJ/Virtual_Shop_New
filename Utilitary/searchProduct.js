$(document).on("click", ".buttonSearch", function() {
    let parametro = $(".inputSearch").val();
    let xhr = new XMLHttpRequest();
    xhr.open(
        "GET",
        "../ProductList/getProduct.php?parametro=" + parametro,
        true
    );
    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let respuesta = xhr.responseText;
            console.log(respuesta);
            $("#contenido").empty();    
            $("#contenido").append(respuesta);
            sendSaveSearch(parametro, null)
        }
    };
    let parametros = "parametro=" + parametro;
    xhr.send(parametros);
});
