function addToCart(id) {
    $.ajax({
        type: 'POST',
        url: 'action/php/AddToCart.php',
        data: {
            test: "test war erfolgreich",
            id: id
        },
        success: function (data) {
            alert(data);
        },
        error: function(a,b,c) {
            console.dir(a.responseText);
            console.dir(b);
            console.dir(c);
        }
    });
}