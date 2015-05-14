$('#favourite').on('click', function(){
    if(isLoggedIn()) {
        var icon = $(this);
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
            }
        });
    } else {
        login();
    }
});

$('#like').on('click', function() {
    if(isLoggedIn()) {
        var icon = $(this);
        var photo_id = icon.data('photo_id');
        $.ajax({
            type: 'POST',
            url: '/like',
            data: {photo_id: photo_id, rental_id: rental_id, _token: getToken()},
            success: function (data, textStatus, jqXHR) {
                if(data.like) {
                    icon.removeClass('fa-thumbs-o-up');
                    icon.addClass('fa-thumbs-up');
                } else {
                    icon.removeClass('fa-thumbs-up');
                    icon.addClass('fa-thumbs-o-up');
                }
                $('#' + data.photo_id).toggleClass('liked');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    } else {
        login();
    }
});


$('#phone-btn').on('click', function(e) {
    var button = $(this);
    if (button.hasClass('disabled')) {
        return false;
    } else {
        button.addClass('disabled');
        $.ajax({
            type: 'POST',
            url: '/rental/phone',
            data: {rental_id: rental_id, _token: getToken()},
            success: function (data, textStatus, jqXHR) {
                button.html(data.phone);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }
})

$('#email-manager-btn').on('click', function(e) {
    $('#email-manager').dialog({
        modal: true,
        dialogClass: "noTitle",
        draggable: false,
        resizable: false,
        show: "fade",
        hide: "fade"
    });
})

$('#email-manager-form').submit(function( event ) {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '/rental/email-manager',
        data: $(this).serialize(),
        success: function (data, textStatus, jqXHR) {
            $('#email-manager').html(data.message);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            var errors = jqXHR.responseJSON;
            var html = "<ul>";
            $.each(errors, function (key, value) {
                $("#email-manager-" + key).addClass("ui-state-error");
                html += "<li>" + value + "</li>";
            });

            html += "</ul>";
            $('#email-manager-form-errors').addClass("ui-state-error").html(html);
        }
    });
});
