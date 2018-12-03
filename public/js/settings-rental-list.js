 $(document).ready(function() {

    $(".activity").on('click', function(event) {

        var button = $(this);
        var rental_id = button.attr('id');
        var slider_text = button.closest('li').find('.slider-text');

        $.ajax({
            type: 'POST',
            url: '/activate',
            data: {rental_id: rental_id},
            success: function (data, textStatus, jqXHR) {
                if(data.activated) {
                    button.prop('checked', true);
                    slider_text.text('ACTIVE');
                    slider_text.removeClass('slider-text-inactive');
                    slider_text.addClass('slider-text-active');
                } else {
                    button.prop('checked', false);
                    slider_text.text('INACTIVE');
                    slider_text.removeClass('slider-text-active');
                    slider_text.addClass('slider-text-inactive');

                    if(data.activeRentalCount === 0) {
                        showModal('Please note that deactivating all of your listings does not prevent future billing.</p><p>To avoid future billing, you may adjust your subscription.',
                            '/admin/subscription/plan',
                            'Manage Subscription');
                    }
                }

                $('#activeRentalCount').html(data.activeRentalCount);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                if(jqXHR.responseJSON.message) {
                    button.prop('checked', false);
                    slider_text.text('INACTIVE');
                    slider_text.removeClass('slider-text-active');
                    slider_text.addClass('slider-text-inactive');
                    showModal(jqXHR.responseJSON.message, '/admin/subscription/plan', 'Manage Subscription');
                }
            }
        });

    });

});
