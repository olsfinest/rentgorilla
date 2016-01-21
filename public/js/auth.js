$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
    }
});


function getToken() {
    return $("meta[name='token']").attr('content');
}

function isLoggedIn()
{
    return $("meta[name='loggedin']").attr('content') === '1';
}

function showModal(message, link, text){

    if(link !== undefined) {
        $('<section id="alert"><p>' + message + '</p><p><a class="button" href="' + link + '">' + text + '</a></p></section>').dialog({
            modal: true,
            dialogClass: "noTitle",
            draggable: false,
            resizable: false,
            show: "fade",
            hide: "fade",
            open: function(event, ui ) {
                $('.ui-dialog').css("top","200px");
            }
        });

        return;
    }


    $('<section id="alert"><p>' + message + '</p></section>').dialog({
        modal: true,
        dialogClass: "noTitle",
        draggable: false,
        resizable: false,
        show: "fade",
        hide: "fade",
        open: function(event, ui ) {
            $('.ui-dialog').css("top","200px");
        }
    });
}

//put this handler in global js
$( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
    if (jqxhr.status == 403) {
        alert('Your session has expired. Reloading page.');
        window.location.reload();
    }
});


$(document).ready(function() {

    $(".login").click(function () {
        login();
    });

    $(".sign_up").click(function () {

        if ($("#login").hasClass('ui-dialog-content')) {
            $("#login").dialog('close');
        }

        return $("#signupmodal").dialog({
            modal: true,
            dialogClass: "noTitle",
            draggable: false,
            resizable: false,
            show: "fade",
            hide: "fade"
        });
    });
});


function login() {

    if ($("#signupmodal").hasClass('ui-dialog-content')) {
        $("#signupmodal").dialog('close');
    }

    if ($("#showVideoModal").hasClass('ui-dialog-content')) {
        $("#showVideoModal").dialog('close');
    }

    return $("#login").dialog({
        modal: true,
        dialogClass: "noTitle",
        draggable: false,
        resizable: false,
        show: "fade",
        hide: "fade"
    });
}


$('#login_form').submit(function( event ) {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '/login',
        data: $(this).serialize(),
        success: function (data, textStatus, jqXHR) {
            window.location.href = '/rental';
            return;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            var errors = jqXHR.responseJSON;
            var html = "<ul>";

            if(errors.hasOwnProperty('redirect_url')) {
                window.location.href = errors.redirect_url;
                return;
            }

            if(errors.message === 'unconfirmed') {
                $('#login').html(errors.html);
                $('#unconfirmed_account_form').submit(function( event ) {
                    event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: '/reconfirm',
                        data: $(this).serialize(),
                        success: function (data, textStatus, jqXHR) {
                            $('#login').html(data.message);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            var errors = jqXHR.responseJSON;
                            var html = "<ul>";

                            $.each(errors, function (key, value) {
                                html += "<li>" + value + "</li>";
                            });

                            html += "</ul>";

                            $('#unconfirmed_account_errors').addClass("ui-state-error").html(html);
                        }
                    });
                });
                return;
            }

            $.each(errors, function (key, value) {
                $("#login_" + key).addClass("ui-state-error");
                html += "<li>" + value + "</li>";
            });

            html += "</ul>";

            $('#login_errors').addClass("ui-state-error").html(html);
        }
    });
});

$('#signup_form').submit(function( event ) {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '/register',
        data: $(this).serialize(),
        success: function (data, textStatus, jqXHR) {
            $('#signupmodal').html(data.message);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            var errors = jqXHR.responseJSON;
            var html = "<ul>";

            $.each(errors, function (key, value) {
                $("#signup_" + key).addClass("ui-state-error");
                html += "<li>" + value + "</li>";
            });

            html += "</ul>";

            $('#signup_errors').addClass("ui-state-error").html(html);
        }
    });
});


