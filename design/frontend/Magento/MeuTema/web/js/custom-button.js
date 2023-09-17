require(['jquery'], function($) {
    $(document).ready(function() {
        var baseUrl = window.BASE_URL;
        $.ajax({
            url: baseUrl + 'changecolor/ajax/buttoncolor',
            type: 'GET', 
            success: function(data) {
                var addToCartButtons = $('.action.primary');
                addToCartButtons.css('background-color', data.button_color);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});