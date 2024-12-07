<?php

function create_city_post_type() {
    register_post_type( 'city',
        array(
            'labels' => array(
                'name' => __( 'Cities' ),
                'singular_name' => __( 'City' ),
                'add_new' => __( 'Add New City' ),
                'add_new_item' => __( 'Add New City' ),
                'edit_item' => __( 'Edit City' ),
                'new_item' => __( 'New City' ),
                'view_item' => __( 'View City' ),
                'search_items' => __( 'Search Cities' ),
                'not_found' => __( 'No cities found' ),
                'not_found_in_trash' => __( 'No cities found in Trash' ),
                'parent_item_colon' => __( 'Parent City:' ),
                'menu_name' => __( 'Cities' )
            ),
            'public' => true,
            'has_archive' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        )
    );
}
add_action( 'init', 'create_city_post_type' );

function add_city_meta_box() {
    add_meta_box(
        'city_location_meta_box',
        'City Location',
        'city_location_meta_box_callback',
        'city',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'add_city_meta_box' );

function city_location_meta_box_callback( $post ) {
    // Add nonce field to verify data
    wp_nonce_field( 'city_location_meta_box', 'city_location_meta_box_nonce' );

    // Get saved values
    $latitude = get_post_meta( $post->ID, 'latitude', true );
    $longitude = get_post_meta( $post->ID, 'longitude', true );

    ?>
    <label for="latitude">Latitude:</label>
    <input type="text" id="latitude" name="latitude" value="<?php echo esc_attr( $latitude ); ?>" size="30" />
    <br>
    <label for="longitude">Longitude:</label>
    <input type="text" id="longitude" name="longitude" value="<?php echo esc_attr( $longitude ); ?>" size="30" />
    <?php
}

function save_city_meta_box( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['city_location_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['city_location_meta_box_nonce'], 'city_location_meta_box' ) ) {
        return;
    }

    // Check user permissions
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( isset( $_POST['post_type'] ) && 'city' == $_POST['post_type'] ) {
        update_post_meta( $post_id, 'latitude', sanitize_text_field( $_POST['latitude'] ) );
        update_post_meta( $post_id, 'longitude', sanitize_text_field( $_POST['longitude'] ) );
    }
}
add_action( 'save_post', 'save_city_meta_box' );

//taxonomy
function create_country_taxonomy() {
	register_taxonomy(
	  'country',
	  'city',
	  array(
		'label' => __( 'Countries' ),
		'singular_label' => __( 'Country' ),
		'hierarchical' => true,
		'show_admin_column' => true,
	  )
	);
  }
  add_action( 'init', 'create_country_taxonomy' );

  function custom_taxonomy_labels( $labels ) {
    if ( 'country' === $labels->name ) {
        $labels->add_new_item = 'Add New Country';
    }
    return $labels;
}
add_filter( 'taxonomy_labels', 'custom_taxonomy_labels' );