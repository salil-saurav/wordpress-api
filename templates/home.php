<?php

/* Template Name: Home */

get_header();

$custom_posts = get_posts(array(
    'post_type' => 'properties',
    'posts_per_page' => -1, // Retrieve all posts
));

$custom_fields = array("bedrooms", "bathrooms", "garages", "status");

$value_arrays = array();
$occurrence_arrays = array();

foreach ($custom_fields as $field) {
    $field_values = array();
    $field_occurrences = array();

    // Loop through custom posts
    foreach ($custom_posts as $post) {
        $custom_val = get_field($field, $post->ID);

        if ($custom_val) {
            $field_values[] = $custom_val;
        }
    }

    // Count occurrences and store in the associative arrays
    $field_occurrences = array_count_values($field_values);
    arsort($field_occurrences);

    $value_arrays[$field] = $field_occurrences;

    // Collect maximum values
    $max_values[$field] = array_keys($field_occurrences);
}

?>

<div class="main">

    <div class="search-bar">
        <div class="search-input">
            <select name="status" id="property-status">
                <option value="all" selected>All</option>
                <?php
                foreach ($max_values["status"] as $options) { ?>
                    <option value="<?= $options ?>"> <?= $options ?></option>
                <?php  }
                ?>
            </select>
            <input type="text" id="property-input">
            <select name="bed" id="bedroom">
                <option value="" selected>Bed</option>
                <?php
                foreach ($max_values["bedrooms"] as $options) { ?>
                    <option value="<?= $options ?>"> <?= $options ?></option>
                <?php  }
                ?>
            </select>
            <select name="bath" id="bathroom">
                <option value="" selected>Bath</option>
                <?php
                foreach ($max_values["bathrooms"] as $options) { ?>
                    <option value="<?= $options ?>"> <?= $options ?></option>
                <?php  }
                ?>
            </select>

            <select name="car" id="garage">
                <option value="" selected>Garage</option>
                <?php
                foreach ($max_values["garages"] as $options) { ?>
                    <option value="<?= $options ?>"> <?= $options ?></option>
                <?php  }
                ?>
            </select>
        </div>
    </div>

    <div class="result-container">
        <div class="filter">
            <select name="order" id="date-filter">
                <option value="newest" selected>Newest</option>
                <option value="highest-price">Highest Price</option>
                <option value="lowest-price">Lowest Price</option>
                <option value="oldest">Oldest</option>
                <option value="auction">Auction</option>
            </select>
        </div>

        <div id="fetched-result">
            <?php
            foreach ($custom_posts as $post) {
                setup_postdata($post);
                $image_cont = get_field("photos");
            ?>
                <div class="result <?= '_' . strtolower(get_field("status")) . '_' ?>">
                    <div class="image-div">
                        <a href="<?= get_permalink(); ?>" target="_blank">
                            <img class="result-image" src="<?= $image_cont[0]['url'] ?>" alt="result-image">
                            <span class="result-address">
                                <?= get_field("address") ?>
                            </span>
                        </a>
                    </div>
                </div>
            <?php }
            wp_reset_postdata();
            ?>
        </div>
    </div>

</div>


<style>
    #fetched-result {
        margin-top: 3rem;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: space-between;
    }

    .result._sold_ img {
        filter: grayscale(1);
    }

    #fetched-result .result:nth-child(6n),
    #fetched-result .result:nth-child(6n+1) {
        width: calc(50% - 12px);
    }

    .image-div a:hover img {
        transform: scale(0.9);
        filter: brightness(0.5);
    }

    .result {
        width: calc(25% - 17px);
        position: relative;
    }

    .result-address {
        position: absolute;
        left: 0;
        top: 50%;
        right: 0;
        color: #fff;
        text-align: center;
        font-size: 20px;
    }

    .image-div {
        position: relative;
        padding-bottom: 40%;
        height: 100%;
    }

    .result-image {
        display: block;
        height: 100%;
        object-fit: cover;
        object-position: center;
        position: absolute;
        transition: .3s;
        width: 100%;
    }

    .main {
        width: 1000px;
        padding: 0 15px;
        margin: 0 auto;
    }

    .search-input {
        display: flex;
        align-items: center;
        gap: 15px;
        justify-content: center;
    }

    .search-bar {
        margin: 3rem 0;
    }

    .filter {
        display: flex;
        justify-content: end;
    }

    .search-bar .search-input select,
    .search-bar .search-input input {
        height: 46px;
    }

    .search-bar .search-input select {
        width: 132px;
    }

    .search-bar .search-input input {
        width: 533px;
    }
</style>

<?php get_footer(); ?>