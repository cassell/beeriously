let $ = require('jquery');
window.$ = $;
window.jQuery = $;
require('popper.js');
require('bootstrap');

// menu
$(document).ready(function () {

    const navButton = $('nav button');

    navButton.on('click',function () {
        let button = $(this);
        let menu = $('#beeriously-nav-menu');

        if(menu.hasClass('beeriously-nav-menu-hidden')) {
            menu.removeClass('beeriously-nav-menu-hidden');
            button.html('<i class="fa fa-times"></i> ' + navButton.data('menu-close-text'));
        } else {
            menu.addClass('beeriously-nav-menu-hidden');
            button.html('<i class="fa fa-bars"></i> ' + navButton.data('menu-text'));
        }
    })
});

let Beeriously = {};

Beeriously.FormUtil = {};




// require('jquery-ui');
