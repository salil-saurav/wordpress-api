<?php

/* Template Name: Home */

get_header();
?>

<div class="main">


    <div class="search-bar">
        <div class="search-input">
            <select name="status" id="property-status">
                <option value="all" selected>All</option>
                <option value="current">Open</option>
                <option value="sold">Sold</option>
            </select>
            <input type="text" id="property-input">
            <select name="bed" id="bedroom">
                <option value="1" selected>Bed</option>
            </select>
            <select name="bath" id="bathroom">
                <option value="1" selected>Bath</option>
            </select>
            <select name="garage" id="garage">
                <option value="1" selected>Car</option>
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
            // Replace 'your_post_type' with the actual post type slug
            $custom_posts = get_posts(array(
                'post_type'      => 'properties',
                'posts_per_page' => -1, // Retrieve all posts
            ));

            foreach ($custom_posts as $post) {
                setup_postdata($post);
                $image_cont = get_field("photos");
            ?>
                <div class="result">
                    <div class="image-div">
                        <a href="<?= get_permalink(); ?>" target="_blank">
                            <img class="result-image" src="<?= $image_cont[0]['url'] ?>" alt="result-image">
                            <span class="result-address"><?= get_field("address") ?></span>
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
        width: 1440px;
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