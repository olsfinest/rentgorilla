var timer1;

function startInterval() {

        timer1 = setTimeout(function () {
            $('.fadeMe').fadeOut('slow');
        }, 3000);

}

$(document).ready(function() {

    // allow user to close manually at any tome
    $('.toast, .toastError, .toastWarning').click(function(){
        $(this).hide('fast');
        clearTimeout(timer1);
    });

    // ... but cancel the fade out on hover ...
    $('.toast').mouseover(function() {
        clearTimeout(timer1)
    });

    // ... and resume if they mouse out
    $('.toast').mouseleave(function() {
        startInterval();
    });

    // auto fade out after 10 seconds ...
    startInterval();
});