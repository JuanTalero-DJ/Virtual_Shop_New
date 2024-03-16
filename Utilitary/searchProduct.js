$(document).on("click", ".buttonSearch", function() {
    var parametro = $(".inputSearch").val();
    var xhr = new XMLHttpRequest();
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
            var respuesta = xhr.responseText;
            console.log(respuesta);
            $("#contenido").empty();
            $("#contenido").append(respuesta);
        }
    };
    var parametros = "parametro=" + parametro;
    xhr.send(parametros);
});