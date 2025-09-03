// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * GovBR-DS Cookies and Contrast
 *
 * @package    theme_govbrds
 * @copyright  2018 Fábio Santos {@link https://www.ifrr.edu.br}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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
    }
}

$(document).ready(function () {

    contraste("");

    // Alto contrast
    $('a.toggle-contraste').click(function () {
        contraste("click")
    });

});