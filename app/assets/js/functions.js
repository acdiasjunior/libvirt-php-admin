
$(document).ready(function(){

    function classCurrent(currentItem) {
        $('.current').removeClass('current');
        $(currentItem).addClass('current');
        if($(currentItem).data('pai') != undefined) {
            $('#' + $(currentItem).data('pai')).addClass('current');
        }
    }

    // Captura os links com a classe nav-ajax e busca via ajax para exibir no main-content
    $('.nav-ajax').on('click', function(event) {

        event.preventDefault();

        var request = $.ajax({
            url: this.href
        });

        request.done(function(response) {
            $('#main-content-ajax').html(response);
            classCurrent(event.target);
        });

        request.fail(function() {
            $('.notification, .error').find('div').html(arguments[0].responseText);
            $('.notification, .error').slideDown(400).fadeTo(400, 100, function () {});
        });

    });

});
