$(document).ready(function () {

    $('#shopID').change(function () {
        Category();

    });

    function Category() {
        var shopID = $('#shopID').val();
        $.post("ajax", {shop_id: shopID}, function (data) {
            $('#groupID').html(data);

        });

    }


});