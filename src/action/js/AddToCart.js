function addToCart() {
    var preis = $('.preis').html();
    preis = parseFloat(preis);
    $.ajax({
        type: 'POST',
        url: 'action/php/AddToCart.php',
        data: {
            test: "test war erfolgreich",
            preis: preis
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