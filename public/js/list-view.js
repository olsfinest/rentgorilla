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

function addURLSearchParams(params) {
    if (history.replaceState) {
        var filtered = params.filter(function (el) {
            return el.name !== "_token" && el.name !== "location" && el.value;
        });
        var query = $.param(filtered);
        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" + query;
        window.history.replaceState({path:newurl},'',newurl);
    }
}

function resizeLocale() {
    vpw = $(window).width();
    vph = $(window).height() - 111;
    $('.locale').css({'height': vph + 'px'});
}


$(document).ready(function() {


    resizeLocale();

    window.onresize = function(event) {
        resizeLocale();
    };

    $(".locale").show();

    $('#spinner').hide();

    loadRentals(0);

    $(".selectmenu").selectmenu({
        change: function( event, ui ) {
                loadRentals();
            },
        appendTo:".filter",
        icons:{button:"ui-icon-arrowthick-1-s"}});

    $('.options').selectmenu({
        change: function (event, ui) {
            window.location.href = ui.item.value;
        }
    });


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
        //loadRentals(0, 1);
        window.location.href = '/list/' + $(this).val();
    });

    /*
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            if(currentPage < totalPages) {
                loadRentals(1, currentPage + 1);
            }
        }
    });

    */


    $('#nextPageBtn').on('click', function() {
        loadRentals(1, currentPage + 1);
    });

    // toggle the filter on mobile
    $('.filter_toggle').click(function(){
        $('.filter').slideToggle('fast', function(){

        });
    });
});

function disableNextPageBtn() {
    var $btn = $('#nextPageBtn');

    $btn.prop('disabled', true);
    $btn.html('Loading...');
}

function enableNextPageBtn() {
    var $btn = $('#nextPageBtn');

    if(currentPage == totalPages) {
        $btn.hide();
    } else {
        $btn.html('Load page ' + (currentPage + 1) + ' of ' + totalPages);
        $btn.prop('disabled', false);
        $btn.show();
    }
}

var count, currentPage, totalPages;

function loadRentals(paginate, page) {

    disableNextPageBtn();

    $('#spinner').show();

    if(page === undefined) {
        page = getPage(window.location.href);
    }

    var url = '/rentals';

    var data = $('#search').serializeArray();
    var searchFormArray = $('#search').serializeArray();
    data.push({name: 'page', value: page});
    data.push({name: 'paginate', value: paginate});
 //   data.push({name: 'sort', value: $("#sort-widget").val()});
  //  searchFormArray.sort = $("#sort-widget").val();

    $.get(url, data, function(data){

        $('#spinner').hide();

        if(paginate) {
            $('#rental-list').append(data.rentals);
        } else {
            $('#list-canvas').html(data.rentals);
        }

        $(".sort").selectmenu({
            change: function( event, ui ) {
               $("#sortField").val($(this).val());
               loadRentals();
        }});

        count = data.count;
        currentPage = data.page;
        totalPages = data.totalPages;

        searchFormArray.push({name:'page', value: currentPage});
        addURLSearchParams(searchFormArray);

        $('.favourite').on('click', function(){
            if(isLoggedIn()) {
                var icon = $(this);
                var rental_id = $(this).attr('id');
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
        $("#rental-list .cycle-slideshow").cycle("pause"),$("#rental-list .cycle-slideshow").hover(function(){$(this).cycle("resume")},function(){$(this).cycle("pause")});

            $(".listings > ul > li").mouseenter(function(){
            var e=$(".progress",this),i=$(".cycle-slideshow",this);
            i.on("cycle-initialized cycle-before",this,function(){e.stop(!0).css("width",0)});
                i.on("cycle-initialized cycle-after",this,function(t,o){i.is(".cycle-paused",this)||e.animate({width:"100%"},o.timeout,"linear")});
                i.on("cycle-paused",this,function(){e.stop()});
                i.on("cycle-resumed",this,function(i,t,o){e.animate({width:"100%"},o,"linear")})});
        enableNextPageBtn();
    });
}