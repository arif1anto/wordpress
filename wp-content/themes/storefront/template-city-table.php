<?php
/*
Template Name: City Temperature Table
*/

get_header();
?>

<div class="container">
    <h1>City Temperature Table</h1>
    <input type="text" id="city-search" placeholder="Search City">
    <table id="city-table">
        <thead>
            <tr>
                <th>Country</th>
                <th>City</th>
                <th>Temperature</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<?php
// Hook for actions before the table
do_action('before_city_table');

// Query to retrieve city data
global $wpdb;

$sql = "SELECT c.post_title AS city_name, c.ID AS city_id, tm.name AS country, m.meta_value AS latitude, m2.meta_value AS longitude
        FROM $wpdb->posts AS c
        INNER JOIN $wpdb->term_relationships AS tr ON c.ID = tr.object_id
        INNER JOIN $wpdb->term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        INNER JOIN $wpdb->terms AS tm ON tt.term_id = tm.term_id
        LEFT JOIN $wpdb->postmeta AS m ON (c.ID = m.post_id AND m.meta_key = 'latitude')
        LEFT JOIN $wpdb->postmeta AS m2 ON (c.ID = m2.post_id AND m2.meta_key = 'longitude')
        WHERE c.post_type = 'city'
        GROUP BY c.ID
        ORDER BY city_name ASC";

$results = $wpdb->get_results($sql);

// Populate the table rows dynamically using JavaScript

?>

<script>
  jQuery(document).ready(function($) {
    var cities = <?php echo json_encode($results); ?>;

    function populateTable(filteredCities) {
      var tableBody = $('#city-table tbody');
      tableBody.empty();

      filteredCities.forEach(function(city) {
        var html = '<tr>';
        html += '<td>' + city.country + '</td>';
        html += '<td>' + city.city_name + '</td>';
        html += '<td><div class="temperature" id="temperature-' + city.city_id + '"></div></td>';
        html += '</tr>';
        tableBody.append(html);
      });

      // Fetch temperature data using AJAX
      fetchTemperatures(cities);
    }

    function fetchTemperatures(cities) {
        $('.temperature').each(function() {
        var cityId = $(this).attr('id').split('-')[1];
        var cityData = cities.find(function(city) { return city.city_id == cityId; });
        if (cityData.latitude && cityData.longitude) {
            $.ajax({
            url: 'http://api.openweathermap.org/data/2.5/weather',
            type: 'get',
            data: {
                lat: cityData.latitude,
                lon: cityData.longitude,
                appid: '9fc5e3e3cb0c55bb9c5e8bea4dcb89ce',
                units: 'metric'
            },
            success: function(response) {
                $('#temperature-' + cityId).html(response.main.temp + ' °C');
            }
            });
        } else {
            $('#temperature-' + cityId).html('No location data available');
        }
        });
    }

    populateTable(cities);

    $('#city-search').on('keyup', function() {
      var searchTerm = $(this).val().toLowerCase();
      var filteredCities = cities.filter(function(city) {
        return city.city_name.toLowerCase().indexOf(searchTerm) !== -1;
      });
      populateTable(filteredCities);
    });
  });
</script>

<?php
// Populate the table with initial data (optional)
// ... (if you want to display the data initially without searching)

// Hook for actions after the table

do_action('after_city_table');

get_footer();
?>