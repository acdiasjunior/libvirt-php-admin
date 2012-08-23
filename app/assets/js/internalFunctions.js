$(document).ready(function(){
    
    // Captura os links com a classe link-ajax e busca via ajax para exibir no main-content
    $('.link-ajax').on('click', function(event) {

        event.preventDefault();

        var request = $.ajax({
            url: this.href
        });

        request.done(function(response) {
            $('.notification').each(function() {
                if($(this).css('display') != 'none') {
                    $(this).find('.close').click();
                }
            });
            $('#main-content-ajax').html(response);
        });

        request.fail(function() {
            $('.notification, .error').find('div').html(arguments[0].responseText);
            $('.notification, .error').slideDown(400).fadeTo(400, 100, function () {});
        });

    });

});
