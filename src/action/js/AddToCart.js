function addToCart(id) {
    console.log(id);
    $.ajax({
        type: 'POST',
        url: 'action/php/AddToCart.php',
        data: {
            test: "test war erfolgreich",
            id: id,
        },
        success: function (data) {
            console.log(data);
            alert(data);
        },
        error: function(a,b,c) {
            console.dir(a.responseText);
            console.dir(b);
            console.dir(c);
        }
    });
}