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
    var btn = $(this);
    if (!btn.hasClass('opened')) {

        //button.addClass('disabled');
		if (!btn.hasClass('disabled')) {
			$.ajax({
				type: 'POST',
				url: '/rental/phone',
				data: {rental_id: rental_id, _token: getToken()},
				success: function (data, textStatus, jqXHR) {
					if(data.phone != "No phone number provided"){
						btn.html(data.phone).attr('href','tel:'+data.phone);
						btn.addClass('opened');
					}else{
						btn.html(data.phone);
						btn.addClass('disabled');
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(errorThrown);
					alert("Error Here");
				}
			});
		}
    }
});

$('.email-manager-btn').on('click', function(e) {
    $('.modalLogin').dialog({
        resizable: 'false',
        dialogClass: 'modalLogin',
        width: '100%',
        height: '100%',
        position: 'fixed',
        top: '0',
        left: '0'
    });
});

$('#email-manager-form').submit(function( event ) {
    event.preventDefault();
    var form = $(this);
    $.ajax({
        type: 'POST',
        url: '/rental/email-manager',
        data: $(this).serialize(),
        success: function (data, textStatus, jqXHR) {
            //alert(data.message);
            var $dialog = form.parents('.ui-dialog-content');
            $dialog.dialog('close');
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


$('#show_video').on('click', function() {

    var showVideoModal = $('<div id="showVideoModal"></div>');

    showVideoModal.dialog({
        modal: true,
        dialogClass: "noTitle",
        draggable: false,
        resizable: false,
        show: "fade",
        hide: "fade",
        close: function( event, ui ) {
            showVideoModal.remove();
        }
    });

    $.ajax({
        type: 'POST',
        url: '/rental/show-video',
        data: {rental_id: rental_id},
        success: function (data, textStatus, jqXHR) {
            showVideoModal.html(data.html);

            $('#toggleVideoLike').on('click', function() {

                var icon = $(this);

                if(isLoggedIn()) {

                    $.ajax({
                        type: 'POST',
                        url: '/rental/like-video',
                        data: {rental_id: rental_id},
                        success: function (data, textStatus, jqXHR) {
                            if (data.like) {
                                $('#toggleVideoLike').removeClass('fa-thumbs-o-up');
                                $('#toggleVideoLike').addClass('fa-thumbs-up');
                            } else {
                                $('#toggleVideoLike').removeClass('fa-thumbs-up');
                                $('#toggleVideoLike').addClass('fa-thumbs-o-up');
                            }

                            icon.html(data.likeCount);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                } else {
                    login();
                }

            });

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
});