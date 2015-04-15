$('.favourite').on('click', function(){
    if(isLoggedIn()) {
        var icon = $(this);
        var rental_id = icon.attr('id');
        $.ajax({
            type: 'POST',
            url: '/favourite',
            data: {rental_id: rental_id, _token: getToken()},
            success: function (data, textStatus, jqXHR) {
                if (data.favourite) {
                    icon.removeClass("fa-heart-o");
                    icon.addClass("fa-heart");

                } else {
                    icon.removeClass("fa-heart");
                    icon.addClass("fa-heart-o");
                }

                icon.html(data.favouriteCount);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            complete: function (jqXHR, textStatus) {
            }
        });
    } else {
        login();
    }
});