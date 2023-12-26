<?php

define("WP_ROOT", __DIR__);
define('WP_USE_THEMES', false);
define("DS", DIRECTORY_SEPARATOR);
// require_once WP_ROOT . DS . "functions.php";
require_once('../../../wp-load.php');




// function get_api_data()
// {
//     $filename = 'C:/wamp64/www/dibalich/wp-content/themes/blank-canvas/public/data.json';
//     $jsonData = json_decode(file_get_contents($filename), true);
//     $data = $jsonData["property"];
//     return $data;
// }

// $data_ID = [];
// function get_api_data_ID_array()
// {
//     $data = get_api_data();
//     foreach ($data as $new) {
//         $data_ID[] = $new["id"];
//     }
//     return $data_ID;
// }

// print_r(get_api_data_ID_array());

// get all data 
// function get_all_data_with_passed_ID(int $ID)
// {
//     $raw_data = get_api_data();

//     foreach ($raw_data as $subArray) {
//         if (isset($subArray['id']) && $subArray['id'] === $ID) {
//             $resultArray = $subArray;
//             break;
//         }
//     }
//     if (isset($resultArray)) {
//         return $resultArray;
//     }
// }
gsdd

// get image URL
function get_image_url(int $ID)
{
    $raw_data = get_api_data();

    foreach ($raw_data as $subArray) {
        if (isset($subArray['id']) && $subArray['id'] === $ID) {
            $resultArray = $subArray["photos"]["photo"][0]["url"];
            break;
        }
    }
    if (isset($resultArray)) {
        return $resultArray;
    }
}
// Get address data
function get_address_data(int $ID)
{
    $raw_data = get_api_data();

    foreach ($raw_data as $subArray) {
        if (isset($subArray['address']) && $subArray['id'] === $ID) {
            $resultArray = $subArray["address"]["address"];
            break;
        }
    }
    if (isset($resultArray)) {
        return $resultArray;
    }
}

// Get

function get_price_data(int $ID)
{
    $raw_data = get_api_data();

    foreach ($raw_data as $subArray) {
        if (isset($subArray['price']) && $subArray['id'] === $ID) {
            $resultArray = $subArray["price"];
            break;
        }
    }
    if (isset($resultArray)) {
        return $resultArray;
    }
}

// 

function get_status_data(int $ID)
{
    $raw_data = get_api_data();

    foreach ($raw_data as $subArray) {
        if (isset($subArray['status']) && $subArray['id'] === $ID) {
            $resultArray = $subArray["status"];
            break;
        }
    }
    if (isset($resultArray)) {
        return $resultArray;
    }
}

function get_property_type_data(int $ID)
{
    $raw_data = get_api_data();

    foreach ($raw_data as $subArray) {
        if (isset($subArray['property_type']) && $subArray['id'] === $ID) {
            $resultArray = $subArray["property_type"];
            break;
        }
    }
    if (isset($resultArray)) {
        return $resultArray;
    }
}

function get_lot_size_data(int $ID)
{
    $raw_data = get_api_data();

    foreach ($raw_data as $subArray) {
        if (isset($subArray['lot_size']) && $subArray['id'] === $ID) {
            $resultArray = $subArray["lot_size"];
            break;
        }
    }
    if (isset($resultArray)) {
        return $resultArray;
    }
}



function seed_test_posts()
{
    function get_random_values($input_array)
    {
        $random_keys = array_rand($input_array, 5); // Get 5 random keys from the array
        $result = array();

        // Retrieve the values corresponding to the random keys
        foreach ($random_keys as $key) {
            $result[] = $input_array[$key];
        }

        return $result;
    }

    $all_IDs_array = get_api_data_ID_array();
    $returned_5_random_ID = get_random_values($all_IDs_array);

    for ($i = 0; $i < count($returned_5_random_ID); $i++) {
        $post_id = wp_insert_post(
            array(
                'post_title' => 'Post ' . ($returned_5_random_ID[$i]),
                'post_content' => 'Content for Post ' . ($i + 1),
                'post_type' => 'post',
                'post_status' => 'publish',
            )
        );

        // Assuming get_all_data_with_passed_ID returns an array
        $random_array = get_all_data_with_passed_ID($returned_5_random_ID[$i]);

        // Pass $post_id to associate ACF fields with the correct post
        create_acf_fields_from_array($random_array);
    }
}
// seed_test_posts();

// $returned_array_with_ID = get_all_data_with_passed_ID(554122);
// var_dump($returned_array_with_ID);

// var_dump(create_acf_fields_from_array($returned_array_with_ID));

// create_acf_fields_from_array($returned_array_with_ID);
