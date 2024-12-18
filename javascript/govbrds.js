function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function contraste(evento){
    var contraste = getCookie("contraste");

    if (contraste!="") {
        if(evento=="click") {
            setCookie("contraste", "", 365);
            $('div.layout').removeClass('contraste');
            $('body').removeClass('contraste');
            $('#menu-nav').addClass('navbar-light bg-faded');
            $('#menu-nav').removeClass('navbar-dark bg-dark');
        } else {
            $('div.layout').addClass('contraste');
            $('body').addClass('contraste');
            $('#menu-nav').addClass('navbar-dark bg-dark');
        }
        /* layout_classes = $.cookie('layout_classes');
        layout_classes = layout_classes.replace('contraste', ''); */
        // $.cookie('layout_classes', layout_classes );

    } else {
        if (evento == "click") {
            setCookie("contraste", "ligado", 365);
            $('div.layout').addClass('contraste');
            $('body').addClass('contraste');
            $('#menu-nav').removeClass('navbar-light bg-faded');
            $('#menu-nav').addClass('navbar-dark bg-dark');
        } else {
            $('div.layout').removeClass('contraste');
            $('body').removeClass('contraste');
            $('#menu-nav').removeClass('navbar-dark bg-dark');
        }
        // layout_classes = $.cookie('layout_classes');
        // if( layout_classes != 'undefined' )
        //     layout_classes = layout_classes + ' contraste';
        // else
        //    layout_classes = 'contraste';
        // $.cookie('layout_classes', layout_classes );

    }
}

$(document).ready(function () {

    contraste("");

    // Alto contrast
    $('a.toggle-contraste').click(function () {
        contraste("click")
    });

});