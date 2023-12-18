<?php
function seed_test_posts()
{

    function get_random_values($input_array)
    {
        $random_values = array_rand($input_array, 5); // Get 5 random keys from the array
        $result = array();

        // Retrieve the values corresponding to the random keys
        foreach ($random_values as $key) {
            $result[] = $input_array[$key];
        }

        return $result;
    }


    $all_IDs_array = get_api_data_ID_array();

    $returned_5_random_ID = get_random_values($all_IDs_array);

    for ($i = 1; $i <= count($returned_5_random_ID); $i++) {
        $post_id = wp_insert_post(
            array(
                'post_title' => 'Post ' . $returned_5_random_ID[$i],
                'post_content' => 'Content for Post ' . $i,
                'post_type' => 'post',
                // Change to your custom post type if needed
                'post_status' => 'publish',
            )
        );

        // Define different arrays for each post
        $field_data = array(
            'custom_field_' . $i . '_1' => 'value_' . $i . '_1',
            'custom_field_' . $i . '_2' => array(
                'nested_field_' . $i . '_1' => 'nested_value_' . $i . '_1',
                'nested_field_' . $i . '_2' => 'nested_value_' . $i . '_2',
            ),
            'custom_field_' . $i . '_3' => 'value_' . $i . '_3',
            // Add more key-value pairs as needed
        );
        $random_array = get_all_data_with_passed_ID($returned_5_random_ID[$i]);
        // Run the function to create ACF fields for the current post
        create_acf_fields_from_array($random_array);
    }
}

seed_test_posts();