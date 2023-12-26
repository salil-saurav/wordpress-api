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

            <select name="car" id="car">
                <option value="" selected>Car</option>
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
                <option value="highest">Highest Price</option>
                <option value="lowest">Lowest Price</option>
                <option value="oldest">Oldest</option>
                <option value="auction">Auction</option>
                <option value="auction">private Sale</option>
                <option value="auction">Off Market</option>
            </select>
        </div>

        <div id="fetched-result">
            <div id="all-result" style="display: flex;">
                <?php
                foreach ($custom_posts as $post) {
                    setup_postdata($post);
                    $image_cont = get_field("photos");
                ?>
                    <div class="result <?= '_' . strtolower(get_field("status")); ?>" style="display: block;">
                        <div class="image-div">
                            <a href="<?= get_permalink(); ?>" target="_blank">
                                <img class="result-image" src="<?= $image_cont[0]['url'] ?>" alt="result-image">
                                <span class="result-address">
                                    <?= get_field("address") ?>
                                </span>
                            </a>
                            <div class="props">
                                <span class="hidden">
                                    bedrooms: <span class="bedroom"> <?= get_field("bedrooms") ?></span>
                                </span>
                                <span class="hidden">
                                    bathrooms: <span class="bathroom"> <?= get_field("bathrooms") ?></span>
                                </span>
                                <span class="hidden">
                                    car: <span class="car"> <?= get_field("garages") ?></span>
                                </span>
                                <span class="hidden">
                                    <span class="date"> <?= get_field("approved"); ?></span>
                                    <span class="lower"> <?= get_field("price_from"); ?></span>
                                    <span class="higher"> <?= get_field("price_to"); ?></span>
                                </span>
                            </div>

                        </div>
                    </div>
                <?php }
                wp_reset_postdata();
                ?>
            </div>

            <hr>
            <div id="sold-result">
                <?php

                foreach ($custom_posts as $post) {
                    setup_postdata($post);
                    $image_cont = get_field("photos");

                    if (get_field("status") === "SOLD") {
                ?>

                        <div class="sold" style="display: block;">
                            <div class="image-div">
                                <a href="<?= get_permalink(); ?>" target="_blank">
                                    <img class="result-image" src="<?= $image_cont[0]['url'] ?>" alt="result-image">
                                    <span class="result-address">
                                        <?= get_field("address"); ?>
                                        <?= get_field("status"); ?>
                                    </span>

                                </a>
                                <div class="props">
                                    <span class="hidden">
                                        bedrooms: <span class="bedroom"> <?= get_field("bedrooms") ?></span>
                                    </span>
                                    <span class="hidden">
                                        bathrooms: <span class="bathroom"> <?= get_field("bathrooms") ?></span>
                                    </span>
                                    <span class="hidden">
                                        car: <span class="car"> <?= get_field("garages") ?></span>
                                    </span>
                                    <span class="hidden">
                                        <span class="date"> <?= get_field("approved"); ?></span>
                                        <span class="lower"> <?= get_field("price_from"); ?></span>
                                        <span class="higher"> <?= get_field("price_to"); ?></span>
                                    </span>
                                </div>

                            </div>
                        </div>
                <?php
                        wp_reset_postdata();
                    }
                }
                ?>
            </div>

            <div id="buy-result">
                <?php

                foreach ($custom_posts as $post) {
                    setup_postdata($post);
                    $image_cont = get_field("photos");

                    if (get_field("status") === "CURRENT") {
                ?>

                        <div class="buy" style="display: block;">
                            <div class="image-div">
                                <a href="<?= get_permalink(); ?>" target="_blank">
                                    <img class="result-image" src="<?= $image_cont[0]['url'] ?>" alt="result-image">
                                    <span class="result-address">
                                        <?= get_field("address"); ?>
                                        <?= get_field("status"); ?>
                                    </span>

                                </a>
                                <div class="props">
                                    <span class="hidden">
                                        bedrooms: <span class="bedroom"> <?= get_field("bedrooms") ?></span>
                                    </span>
                                    <span class="hidden">
                                        bathrooms: <span class="bathroom"> <?= get_field("bathrooms") ?></span>
                                    </span>
                                    <span class="hidden">
                                        car: <span class="car"> <?= get_field("garages") ?></span>
                                    </span>
                                    <span class="hidden">
                                        <span class="date"> <?= get_field("approved"); ?></span>
                                        <span class="lower"> <?= get_field("price_from"); ?></span>
                                        <span class="higher"> <?= get_field("price_to"); ?></span>
                                    </span>
                                </div>

                            </div>
                        </div>
                <?php
                        wp_reset_postdata();
                    }
                }
                ?>
            </div>
        </div>
    </div>

</div>


<style>
    #all-result,
    #sold-result,
    #buy-result {
        margin-top: 3rem;
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: space-between;
    }

    #sold-result,
    #buy-result {
        display: none;
    }


    .sold img,
    ._sold img {
        filter: grayscale(1);
    }

    .props {
        position: absolute;
        font-size: 18px;
        color: midnightblue;
    }

    .hidden {
        /* display: none; */
    }

    #all-result .result:not([style*="display: none"]):nth-child(6n),
    #buy-result .buy:not([style*="display: none"]):nth-child(6n),
    #sold-result .sold:not([style*="display: none"]):nth-child(6n),
    #all-result .result:not([style*="display: none"]):nth-child(6n+1),
    #sold-result .sold:not([style*="display: none"]):nth-child(6n+1),
    #buy-result .buy:not([style*="display: none"]):nth-child(6n+1) {
        width: calc(50% - 12px);
    }


    .image-div a:hover img {
        transform: scale(0.9);
        filter: brightness(0.5);
    }

    .result,
    .sold,
    .buy {
        width: calc(25% - 17px);
        position: relative;
        animation-fill-mode: both;
        animation-duration: 500ms;
        animation-delay: 0ms;
        animation-iteration-count: 1;
        opacity: 1;
        animation-name: revealAnimation;

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
        width: 1400px;
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

    @keyframes revealAnimation {
        0% {
            opacity: 0;
            transform: translate3d(0px, 50px, 0px);
        }

        100% {
            opacity: 1;
            transform: none;
        }
    }
</style>

<?php get_footer(); ?>