function getPage(url) {
   var page = getParameterByName(url, 'page');
    return (page === null) ? 1 : page;
}

function getParameterByName (url, name)
{
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name.toLowerCase() + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(url.toLowerCase());
    if (results == null)
        return null;
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}



$(document).ready(function() {


    $('#spinner').hide();

    loadRentals();

    $(".selectmenu").selectmenu({
        change: function( event, ui ) {
                loadRentals();
            },
        appendTo:".filter",
        icons:{button:"ui-icon-arrowthick-1-s"}});


    $('#location').select2({
        placeholder: 'City',
        minimumInputLength: 3,
        ajax: {
            url: '/location-list',
            dataType: 'json',
            data: function (term, page) {
                return {
                    location: term
                };
            },
            processResults: function (data, page) {
                return {results: data};
            }
        }
    });

    $('#location').on("change", function(e) {
        loadRentals();
    });
});

function loadRentals(page) {

    $('#spinner').show();

    if(page === undefined) {
        page = 1;
    }

    var url = '/rentals?page=' + page;

    $.get(url, $('#search').serialize(), function(data){

        $('#spinner').hide();

        $('#list-canvas').fadeOut(100).html(data.rentals).fadeIn(500);

        $('.favourite').on('click', function(){
            if(isLoggedIn()) {
                var icon = $(this);
                var rental_id = $(this).attr('id');
                $.ajax({
                    type: 'POST',
                    url: 'favourite',
                    data: {rental_id: rental_id, _token: getToken()},
                    success: function (data, textStatus, jqXHR) {
                        if (data.favourite) {
                            icon.removeClass("fa-heart-o");
                            icon.addClass("fa-heart");
                        } else {
                            icon.removeClass("fa-heart");
                            icon.addClass("fa-heart-o");
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

        $('.pagination a').on('click', function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var page = getPage(url);
            loadRentals(page);

        });
    });
}