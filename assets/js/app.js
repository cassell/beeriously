let $ = require('jquery');
window.$ = $;
window.jQuery = $;
import 'popper.js';
import 'bootstrap';
import Turbolinks from 'turbolinks';

Turbolinks.start();

let Beeriously = {};

Beeriously.messages = {
    'beeriously.ajax.default_error_message' : "Sorry, you are not currently logged in or an unknown error has occurred. Please refresh the page to continue."
};

Beeriously.menu = {
    open : function() {
        let navButton = $('nav button');
        let button = $(this);
        let menu = $('#beeriously-nav-menu');
        menu.removeClass('beeriously-nav-menu-hidden');
        button.html('<i class="fa fa-times"></i> ' + navButton.data('menu-close-text'));
    },
    close : function() {
        let navButton = $('nav button');
        let button = $(this);
        let menu = $('#beeriously-nav-menu');
        menu.addClass('beeriously-nav-menu-hidden');
        button.html('<i class="fa fa-bars"></i> ' + navButton.data('menu-text'));
    },
    toggle: function () {
        {
            let menu = $('#beeriously-nav-menu');
            if(menu.hasClass('beeriously-nav-menu-hidden')) {
                Beeriously.menu.open();
            } else {
                Beeriously.menu.close();
            }
        }
    },
    init: function() {
        const navButton = $('nav button');
        navButton.on('click',function () {
            Beeriously.menu.toggle();
        })
    }
};

document.addEventListener("turbolinks:load", function(event) {
    Beeriously.menu.init();
});

document.addEventListener("turbolinks:click", function(event) {
    Beeriously.menu.close();
});

Beeriously.alertError = function (errors) {
    let arr = Object.keys(errors).map((k) => errors[k]);
    if(arr.length === 0) {
        arr.push(Beeriously.messages['beeriously.ajax.default_error_message']);
    }
    alert(arr.join("\n"));
};

Beeriously.getJSON = function (url, data, successCallback) {
    return $.getJSON(url,data).then(function(response) {
        return $.Deferred(function (deferred) {
            if(response.error !== undefined && response.error === 0) {
                deferred.resolve(response.data);
            } else if(response.errors !== undefined && response.errors.length > 0) {
                return deferred.reject(response.errors);
            } else {
                return deferred.reject([]);
            }
        }).promise();
    }).done(function(data){
        successCallback(data);
    }).fail(function(errors) {
        if (Object.prototype.toString.call(errors) === "[object Array]") {
            Beeriously.alertError(errors);
        } else {
            Beeriously.alertError([]);
        }
    });
};

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

    Beeriously.getJSON(url, getData, function (data) {
        if(data.content === undefined) {
            throw "undefined content";
        }
        $('#beeriously-full-screen-loading-overlay').hide();
        $('#beeriously-loading-indicator').hide();
        let div = $('<div></div>');
        $(document.body).append(div);
        div.html(data.content);
        div.find('div.modal').modal('show');
    });

};

window.Beeriously = Beeriously;
