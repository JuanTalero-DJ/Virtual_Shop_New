function sendSaveSearch(palabraClave, categoria){
    let xhr = new XMLHttpRequest();
    xhr.open(
        "POST",
        "../User/saveSearch/saveSearch.php",
        true
    );
    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
           return true;
        }
    };
    let params = 'palabraClave=' + encodeURIComponent(palabraClave) + '&idCategoria=' + encodeURIComponent(categoria);

    xhr.send(params);
}