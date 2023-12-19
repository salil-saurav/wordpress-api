<?php

require_once __DIR__ . '/inc/remove-bloats.php';
require_once __DIR__ . '/inc/async-defer.php';
require_once __DIR__ . '/inc/async-defer.php';
require_once __DIR__ . '/inc/custom-posts.php';

/* Add Scripts & Styles */

function add_scripts()
{
    wp_register_style('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('bootstrap');

    wp_register_style('font-awesome',  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), null);
    wp_enqueue_style('font-awesome');

    wp_register_style('style', get_stylesheet_directory_uri() . '/style.css', array(), null);
    wp_enqueue_style('style');
    wp_register_style('responsive', get_stylesheet_directory_uri() . '/responsive.css', array(), null);
    wp_enqueue_style('responsive');

    wp_register_script('custom-jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('custom-jquery');

    wp_register_script('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.bundle.min.js', array(), null, true);
    wp_enqueue_script('bootstrap');

    wp_register_script('script', get_stylesheet_directory_uri() . '/app.js', array(), null, true);
    wp_enqueue_script('script');
}

add_action('wp_enqueue_scripts', 'add_scripts', 999);

/* Register Menu */

// register_nav_menus(array(
//     'primary' => __('Primary Menu', 'Wonder Thai Massage'),
// ));

function remove_custom_post_types()
{
    $post_types_to_remove = array('treatments', 'products', 'testimonials', 'galleries');

    foreach ($post_types_to_remove as $post_type) {
        unregister_post_type($post_type);
    }
}

add_action('init', 'remove_custom_post_types');



// Api Fetch 


function fetch_api_data($ID = null)
{
    $curl = curl_init();
    $apiEndpoint = 'https://api.open2view.com/nz/properties.json?detail=full';
    $username = trim(get_field('api_user', 'option'));
    $password = trim(get_field('api_key', 'option'));

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => $apiEndpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . base64_encode("$username:$password"),
                "Content-Type: application/json", // Specify Content-Type
            ),
        )
    );

    $response = curl_exec($curl);

    // Check for cURL errors
    if (curl_errno($curl)) {
        echo "cURL Error: " . curl_error($curl);
        curl_close($curl);
        return false;
    }

    // Check HTTP status code
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        echo "HTTP Error: " . $httpCode;
        curl_close($curl);
        return false;
    }

    curl_close($curl);

    $apiDataArr = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "JSON Decoding Error: " . json_last_error_msg();
        return false;
    }

    //  if there is a passed ID in the function

    if ($ID !== null && is_int($ID)) {
        if (isset($apiDataArr["properties"])) {

            $raw_data = $apiDataArr["properties"]["property"];

            foreach ($raw_data as $subArray) {
                if (isset($subArray['id']) && $subArray['id'] === $ID) {
                    $resultArray = $subArray;
                    break;
                }
            }
            if (isset($resultArray)) {
                return $resultArray;
            }
        }
    }

    // Ensure 'properties' key exists in the response
    if (isset($apiDataArr["properties"])) {
        $data_to_return = $apiDataArr["properties"]["property"];

        return $data_to_return;
    } else {
        echo "Invalid API Response Format";
        return false;
    }
}

// Get Properties ID Array 

function get_api_data_ID_array()
{
    $data = fetch_api_data();
    foreach ($data as $new) {
        $data_ID[] = $new["id"];
    }
    return $data_ID;
}


// fetch_api_data();
function get_api_data()
{
    $filename = esc_url(get_template_directory_uri()) . '/public/data.json';
    // $jsonData = json_decode(file_get_contents($filename), true);
    // $data = $jsonData["property"];
    // return $data;
}

// Adding custom post type 'Property'

add_action('init', 'register_property_cpt');

function register_property_cpt()
{
    register_post_type('properties', [
        'label' => "Properties",
        'public' => true,
        'capability_type' => 'post'
    ]);
}


// Add an option Page 

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Theme Options',
        'menu_title'    => 'Theme Options',
        'menu_slug'     => 'theme-options',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}


// Cron 

if (!wp_next_scheduled('get_properties_from_api')) {
    wp_schedule_event(time(), 'twicedaily', 'get_properties_from_api');
}

add_action('wp_ajax_nopriv_get_properties_from_api', 'get_properties_from_api');
add_action('wp_ajax_get_properties_from_api', 'get_properties_from_api');


// function get_properties_from_api()
// {
//     // $file = get_stylesheet_directory() . '/report.txt';
//     $properties = fetch_api_data();
//     if (!is_array($properties) || empty($properties)) {
//         return false;
//     }
//     foreach ($properties as $property) {
//         $property_slug = sanitize_title($property['address']['address'] . '-' . $property['id']);

//         // Inserting post for each property

//         $inserted_property =  wp_insert_post([
//             'post_name' => $property_slug,
//             'post_title' => $property_slug,
//             'post_type' => 'properties',
//             'post_status' => 'publish'
//         ]);

//         if (is_wp_error($inserted_property)) {
//             continue;
//         }

//         $fields_to_insert = [
//             'field_658147d726ae9' => 'id',
//             'field_6581460f26acd' => 'address["address"]',
//             'field_6581462926ace' => 'agency_id',
//             'field_6581463626acf' => 'status',
//             'field_6581464226ad0' => 'latitude',
//             'field_6581464626ad1' => 'longitude',
//             'field_6581464e26ad2' => 'price',
//             'field_6581468826ad3' => 'price_from',
//             'field_6581469026ad4' => 'price_to',
//             'field_6581469b26ad5' => 'category',
//             'field_658146a126ad6' => 'property_type',
//             'field_658146a826ad7' => 'suburb',
//             'field_658146ad26ad8' => 'area',
//             'field_658146b426ad9' => 'region',
//             'field_658146c626ada' => 'bedrooms',
//             'field_658146d326adb' => 'bathrooms',
//             'field_658146dd26adc' => 'garages',
//             'field_658146e326add' => 'floor_size',
//             'field_658146ec26ade' => 'lot_size',
//             'field_6581470026adf' => 'built_in',
//             'field_6581470826ae0' => 'description',
//             'field_658147e526aea' => 'last_updated',
//             'field_658147ec26aeb' => 'approved'
//         ];

//         foreach ($fields_to_insert as $key => $name) {
//             $field_value = isset($property[$name]) ? $property[$name] : null;
//             update_field($key, $field_value, $inserted_property);
//         }
//     }
// }


function get_properties_from_api()
{
    $properties = fetch_api_data();

    if (!is_array($properties) || empty($properties)) {
        wp_send_json_error('Unable to fetch properties from the API.');
    }

    foreach ($properties as $property) {
        $property_slug = sanitize_title($property['address']['address'] . '-' . $property['id']);

        $existing_post_id = get_post_id_by_slug($property_slug);

        if (!$existing_post_id) {
            $inserted_property = wp_insert_post([
                'post_name'   => $property_slug,
                'post_title'  => $property_slug,
                'post_type'   => 'properties',
                'post_status' => 'publish',
            ]);

            if (is_wp_error($inserted_property)) {
                continue;
            }
        } else {
            $inserted_property = $existing_post_id;
        }
        update_acf_fields($property, $inserted_property);

        // $existing_property_timestamp = get_field("last_updated", $existing_post_id);
    }
}

function update_acf_fields($property_data, $post_id)
{
    $fields_to_insert = [
        'field_658147d726ae9' => 'id',
        'field_6581462926ace' => 'agency_id',
        'field_6581463626acf' => 'status',
        'field_6581464226ad0' => 'latitude',
        'field_6581464626ad1' => 'longitude',
        'field_6581464e26ad2' => 'price',
        'field_6581468826ad3' => 'price_from',
        'field_6581469026ad4' => 'price_to',
        'field_6581469b26ad5' => 'category',
        'field_658146a126ad6' => 'property_type',
        'field_658146a826ad7' => 'suburb',
        'field_658146ad26ad8' => 'area',
        'field_658146b426ad9' => 'region',
        'field_658146c626ada' => 'bedrooms',
        'field_658146d326adb' => 'bathrooms',
        'field_658146dd26adc' => 'garages',
        'field_658146e326add' => 'floor_size',
        'field_658146ec26ade' => 'lot_size',
        'field_6581470026adf' => 'built_in',
        'field_6581470826ae0' => 'description',
        'field_658147e526aea' => 'last_updated',
        'field_658147ec26aeb' => 'approved'
    ];

    $address = isset($property_data['address']['address']) ? $property_data['address']['address'] : null;
    update_field('field_6581460f26acd', $address, $post_id);

    $photos = isset($property_data['photos']['photo']) ? $property_data['photos']['photo'] : [];
    update_field('field_6581472526ae2', $photos, $post_id);

    // updating video repeater

    $videos = isset($property_data['videos']['video']) ? $property_data['videos']['video'] : [];
    update_field('field_6581474026ae3', $videos, $post_id);

    // updating home view repeater 

    $homeview = isset($property_data['homeviews']['homeviews']) ? $property_data['homeviews']['homeviews'] : [];
    update_field('field_6581475b26ae4', $homeview, $post_id);

    $virtualtours = isset($property_data['virtualtours']) ? $property_data['virtualtours'] : [];
    update_field('field_6581476926ae5', $virtualtours, $post_id);

    $floorplans = isset($property_data['floorplans']['floorplan']) ? $property_data['floorplans']['floorplan'] : [];
    update_field('field_658147b826ae6', $floorplans, $post_id);

    foreach ($fields_to_insert as $key => $name) {
        $field_value = isset($property_data[$name]) ? $property_data[$name] : null;
        update_field($key, $field_value, $post_id);
    }
}

function get_post_id_by_slug($slug)
{
    $post = get_page_by_path($slug, OBJECT, 'properties');
    return $post ? $post->ID : 0;
}
