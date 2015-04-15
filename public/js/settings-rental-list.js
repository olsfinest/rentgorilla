 $(document).ready(function() {

    $(".rental-active").on('click', function(event) {

        var button = $(this);

        $.ajax({
            type: 'POST',
            url: 'activate',
            data: {rental_id: button.attr('id')},
            success: function (data, textStatus, jqXHR) {
                if(data.activated) {
                    button.attr('title', 'deactivate');
                    button.removeClass();
                    button.addClass('rental-active btn btn-success');
                    button.html('Active');
                } else {
                    button.attr('title', 'activate');
                    button.removeClass();
                    button.addClass('rental-active btn btn-danger');
                    button.html('Inactive');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if(jqXHR.responseJSON.message) {
                    alert(jqXHR.responseJSON.message);
                } else {
                    alert(errorThrown);
                }
            }
        });

    });

});
