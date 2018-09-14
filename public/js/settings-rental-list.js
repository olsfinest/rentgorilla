 $(document).ready(function() {

    $(".activity").on('click', function(event) {

        var button = $(this);

        $.ajax({
            type: 'POST',
            url: '/activate',
            data: {rental_id: button.attr('id')},
            success: function (data, textStatus, jqXHR) {
                if(data.activated) {
                    button.prop('checked', true);
                } else {
                    button.prop('checked', false);
                }

                $('#activeRentalCount').html(data.activeRentalCount);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                if(jqXHR.responseJSON.message) {
                    button.prop('checked', false);
                    showModal(jqXHR.responseJSON.message, '/admin/subscription/plan', 'Manage Subscription');
                }
            }
        });

    });

});
