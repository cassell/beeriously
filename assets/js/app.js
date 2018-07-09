let $ = require('jquery');
window.$ = $;
window.jQuery = $;
require('popper.js');
require('bootstrap');

// menu
$(document).ready(function () {
    $('nav button').on('click',function () {
        let button = $(this);
        let menu = $('#beeriously-nav-menu');

        if(menu.hasClass('beeriously-nav-menu-hidden')) {
            menu.removeClass('beeriously-nav-menu-hidden');
            button.html('<i class="fa fa-times"></i> Close');
        } else {
            menu.addClass('beeriously-nav-menu-hidden');
            button.html('<i class="fa fa-bars"></i> Menu');
        }
    })
});

let Beeriously = {};

Beeriously.FormUtil = {};




// require('jquery-ui');
