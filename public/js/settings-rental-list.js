 $(document).ready(function() {

    $(".activity").on('click', function(event) {

        var button = $(this);

        $.ajax({
            type: 'POST',
            url: '/activate',
            data: {rental_id: button.attr('id')},
            success: function (data, textStatus, jqXHR) {
                if(data.activated) {
                    button.attr('title', 'deactivate');
                    button.removeClass();
                    button.addClass('activity on');
                    button.html('Active');
                } else {
                    button.attr('title', 'activate');
                    button.removeClass();
                    button.addClass('activity off');
                    button.html('Inactive');
                }

                $('#activeRentalCount').html(data.activeRentalCount);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if(jqXHR.responseJSON.message) {
                    showModal(jqXHR.responseJSON.message);
                }
            }
        });

    });

});
