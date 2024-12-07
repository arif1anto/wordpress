<?php


class City_Temperature_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'city_temperature_widget',
            'City Temperature',
            array( 'description' => 'Displays the current temperature of a selected city.' )
        );
    }

    public function widget( $args, $instance ) {
        $city_id = $instance['city'];
        $city = get_post( $city_id );
        $latitude = get_post_meta( $city->ID, 'latitude', true );
        $longitude = get_post_meta( $city->ID, 'longitude', true );

        echo $args['before_widget'];
        echo $args['before_title'];
        echo esc_html( $city->post_title );
        echo $args['after_title'];

        // Output the temperature using JavaScript and AJAX
        // $meta = get_post_meta( $city_id);
        // print_r($city->ID);
        echo '<div id="temperature-' . $city_id . '"></div>';

        echo $args['after_widget'];

        wp_enqueue_script( 'city-temperature-script', get_stylesheet_directory_uri() . '/assets/js/city-temperature.js', array( 'jquery' ), false, true );
        wp_localize_script( 'city-temperature-script', 'city_temperature_vars', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'city_id' => $city_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ) );
    }

    public function form( $instance ) {
        $city_id = ! empty( $instance['city'] ) ? $instance['city'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'city' ); ?>">Select City:</label>
            <?php wp_dropdown_pages( array(
                'post_type' => 'cities',
                'name' => $this->get_field_name( 'city' ),
                'selected' => $city_id
            ) ); ?>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['city'] = (int) $new_instance['city'];
        return $instance;
    }
}
add_action( 'widgets_init', function() {
    register_widget( 'City_Temperature_Widget' );
} );

function get_city_temperature() {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $api_url = 'https://api.openweathermap.org/data/2.5/weather?lat=' . $latitude . '&lon=' . $longitude . '&appid=9fc5e3e3cb0c55bb9c5e8bea4dcb89ce&units=metric';

    $response = wp_remote_get( $api_url );
    if ( is_array( $response ) && ! is_wp_error( $response ) ) {
        $body = json_decode( wp_remote_retrieve_body( $response ) );
        $temperature = $body->main->temp;
        echo 'Current Temperature: ' . $temperature . '°C';
    } else {
        echo 'Error fetching temperature data.';
    }

    wp_die();
}
add_action( 'wp_ajax_get_city_temperature', 'get_city_temperature' );
add_action( 'wp_ajax_nopriv_get_city_temperature', 'get_city_temperature' );