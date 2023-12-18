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


// Add this code to your theme's functions.php file or a custom plugin

function remove_custom_post_types()
{
    $post_types_to_remove = array('treatments', 'products', 'testimonials', 'galleries');

    foreach ($post_types_to_remove as $post_type) {
        unregister_post_type($post_type);
    }
}

add_action('init', 'remove_custom_post_types');



// Api Fetch 


// function fetch_api_data()
// {
//     $curl = curl_init();
//     $username = 'di.balich';
//     $password = 'G$p%8S=es#Cx';
//     $apiEndpoint = "https://api.open2view.com/nz/properties.json?detail=full";

//     curl_setopt_array(
//         $curl,
//         array(
//             CURLOPT_URL => $apiEndpoint,
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_FOLLOWLOCATION => true,
//             CURLOPT_ENCODING => "",
//             CURLOPT_MAXREDIRS => 10,
//             CURLOPT_TIMEOUT => 30,
//             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//             CURLOPT_CUSTOMREQUEST => "GET",
//             CURLOPT_HTTPHEADER => array(
//                 "Authorization: Basic " . base64_encode("$username:$password"),
//             ),
//         )
//     );

//     $response = curl_exec($curl);
//     $apiDataArr = json_decode($response, true);
//     $error = curl_error($curl);

//     $data_to_return = $apiDataArr["properties"];

//     curl_close($curl);

//     $filename = esc_url(get_template_directory_uri()) . '/public/data.json';
//     file_put_contents($filename, json_encode($data_to_return));

//     if ($error) {
//         echo "cURL Error: " . $error;
//     } else {
//         return $data_to_return;
//     }
// }
// try {
//     $apiKey = getenv("API_KEY");

//     if ($apiKey === false) {
//         throw new Exception("API_KEY environment variable is not set.");
//     }
//     // Proceed with the rest of your code using $apiKey
//     echo "API_KEY: " . $apiKey;
// } catch (Exception $e) {
//     echo "Error: " . $e->getMessage();
// }

function fetch_api_data()
{
    $curl = curl_init();
    $username = 'di.balich';
    $password = 'G$p%8S=es#Cx';
    $apiEndpoint = 'https://api.open2view.com/nz/properties.json?detail=full';

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

    // Ensure 'properties' key exists in the response
    if (isset($apiDataArr["properties"])) {
        $data_to_return = $apiDataArr["properties"];

        // $filename = esc_url(get_template_directory_uri()) . '/public/data.json';
        // file_put_contents($filename, json_encode($data_to_return));

        return $data_to_return;
    } else {
        echo "Invalid API Response Format";
        return false;
    }
}
// fetch_api_data();
function get_api_data()
{
    $filename = esc_url(get_template_directory_uri()) . '/public/data.json';
    // $jsonData = json_decode(file_get_contents($filename), true);
    // $data = $jsonData["property"];
    // return $data;
}



function create_acf_fields_from_array($field_array, $parent_group_key = null)
{
    if (function_exists('acf_add_local_field_group')) {
        $fields = array();

        foreach ($field_array as $key => $value) {
            $field_key = 'field_' . uniqid();

            $field = array(
                'key' => $field_key,
                'label' => ucfirst($key),
                'name' => $key,
                'type' => is_array($value) ? 'group' : 'text',
                'instructions' => 'Enter ' . ucfirst($key) . ' field-id = ' . $field_key,
                'required' => false,
                'default_value' => $value,
            );

            // If it's a nested array, create subfields recursively
            if (is_array($value)) {
                $field['type'] = 'group';
                $field['sub_fields'] = create_acf_fields_from_array($value, $field_key);
            }

            $fields[] = $field;
        }

        if ($parent_group_key) {
            return $fields;
        } else {
            $field_group = array(
                'key' => 'group_' . uniqid(),
                'title' => 'Custom Fields',
                // Replace with your desired field group title
                'fields' => $fields,
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'post',
                        ),
                    ),
                ),
            );

            acf_add_local_field_group($field_group);
        }
    }
}
