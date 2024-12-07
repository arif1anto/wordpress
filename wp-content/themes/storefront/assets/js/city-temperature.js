jQuery(document).ready(function($) {
    var city_id = city_temperature_vars.city_id;
    var latitude = city_temperature_vars.latitude;
    var longitude = city_temperature_vars.longitude;

    $.ajax({
        url: city_temperature_vars.ajaxurl,
        type: 'post',
        data: {
            action: 'get_city_temperature',
            latitude: latitude,
            longitude: longitude
        },
        success: function(response) {
            $('#temperature-' + city_id).html(response);
        }
    });
});