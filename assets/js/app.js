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

Beeriously.remoteModalFollow = function(event) {
    event.preventDefault();

    let button = $(this);
    let url = button.attr('data-beeriously-modal-url');

    if (typeof url !== 'string' || url === "") {
        throw "modal url not defined"
    }

    let getData = $.extend(true, {}, button.data());
    delete getData.url;

    $('#beeriously-full-screen-loading-overlay').show();
    $('#beeriously-loading-indicator').show();

    $.get(url, getData,function (response) {
        $('#beeriously-full-screen-loading-overlay').hide();
        $('#beeriously-loading-indicator').hide();
        let div = $('<div></div>');
        $(document.body).append(div);
        div.html(response);
        div.find('div.modal').modal('show');
    },'html');
};

window.Beeriously = Beeriously;
