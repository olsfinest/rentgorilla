$(document).ready(function() {
    $('.favourite').on('click', function () {
        if (isLoggedIn()) {
            var icon = $(this);
            var rental_id = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: '/favourite',
                data: {rental_id: rental_id, _token: getToken()},
                success: function (data, textStatus, jqXHR) {
                    if ( ! data.favourite) {
                        icon.closest( 'li').remove();
                    }
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


    $(".cycle-slideshow").cycle();
    $(".cycle-slideshow").cycle("pause"),$(".cycle-slideshow").hover(function(){$(this).cycle("resume")},function(){$(this).cycle("pause")});

    $(".listings > ul > li").mouseenter(function(){
        var e=$(".progress",this),i=$(".cycle-slideshow",this);
        i.on("cycle-initialized cycle-before",this,function(){e.stop(!0).css("width",0)});
        i.on("cycle-initialized cycle-after",this,function(t,o){i.is(".cycle-paused",this)||e.animate({width:"100%"},o.timeout,"linear")});
        i.on("cycle-paused",this,function(){e.stop()});
        i.on("cycle-resumed",this,function(i,t,o){e.animate({width:"100%"},o,"linear")})});

});