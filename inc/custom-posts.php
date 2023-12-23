<?php

// Our custom post type function
function create_posttype()
{

    register_post_type(
        'properties',
        array(
            'labels' => array(
                'name' => __('Properties'),
                'singular_name' => __('Property')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'properties'),
            'show_in_rest' => true,
            'supports' => array('title')

        )
    );
}
add_action('init', 'create_posttype');
