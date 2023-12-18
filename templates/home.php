<?php

/* Template Name: Home */

get_header();

$data = get_api_data(); ?>

<style>
    .main-container {
        width: 1400px;
        display: flex;
        flex-wrap: wrap;
    }

    .per-img img {
        width: 250px;
        margin: 4px;
    }
</style>


<?php get_footer(); ?>