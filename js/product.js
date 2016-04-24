$(document).ready(function () {
    Category();
    Item();
   // $('#categoryID').html('');
    //$('#item').html('');
    $('#shopID').change(function () {
        Category();
        Item();
       
    });

    $('#categoryID').change(function () {
        Item();
    });


    function Category() {
        var shopID = $('#shopID').val();
        $.post("ajax", {shop_id: shopID}, function (data) {
            $('#categoryID').html(data);
            
        });

    }
   

    function Item() {
        var categoryID = $('#categoryID').val();
        $.post("ajax", {category_id: categoryID}, function (data) {
            $('#item').html(data);
        });

    }
   

});