<?php

// Our custom post type function
function create_posttype() {
  
    register_post_type( 'treatments',
        array(
            'labels' => array(
                'name' => __( 'Treatments' ),
                'singular_name' => __( 'Treatment' )
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'treatments'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'thumbnail' )
        )
    );

    register_post_type( 'products',
        array(
            'labels' => array(
                'name' => __( 'Products' ),
                'singular_name' => __( 'Product' )
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'products'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'thumbnail' )
        )
    );

    register_post_type( 'testimonials',
        array(
            'labels' => array(
                'name' => __( 'Testimonials' ),
                'singular_name' => __( 'Testimonial' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'testimonials'),
            'show_in_rest' => true,
            'supports' => array( 'title', 'thumbnail' )
  
        )
    );

    register_post_type( 'galleries',
        array(
            'labels' => array(
                'name' => __( 'Galleries' ),
                'singular_name' => __( 'Gallery' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'galleries'),
            'show_in_rest' => true,
            'supports' => array( 'title' )
  
        )
    );
}
add_action( 'init', 'create_posttype' );