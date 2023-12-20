<?php get_header(); ?>

<div class="product-main">
    <div class="owl-carousel-product owl-theme">
        <?php
        $image_container = get_field("photos");

        foreach ($image_container as $image) { ?>
            <div class="product-carousel-image">
                <img class="carousel-img" src="<?= $image["url"] ?>" alt="product-image">
            </div>
        <?php } ?>

    </div>
    <div class="detail-page-inner">
        <div class="id-sec">
            <div class="product-id"><span>ID#</span><?= get_field("id"); ?></div>
            <div class="button-grp">
                <button class="swich-btn">
                    gallery
                </button>
                <button class="swich-btn">
                    video
                </button>
                <button class="swich-btn">
                    floor plan
                </button>
            </div>
            <div class="share">
                <a>
                    share
                </a>
            </div>
        </div>
        <hr>
        <div class="inner-details">
            <div class="address">
                <h2><?= get_field("address"); ?></h2>
                <h2><?= get_field("status"); ?></h2>
            </div>
            <div class="cards">
                <div class="auction">
                    <h3>Auction</h3>
                    <span><?= time(); ?></span>
                </div>
                <div class="open-homes">
                    <h3>Open Homes</h3>
                    <span><?= time(); ?></span>
                </div>
            </div>

        </div>
    </div>

    <div class="property-details">
        <ul>
            <?php
            function findGCD($a, $b)
            {
                while ($b != 0) {
                    $remainder = $a % $b;
                    $a = $b;
                    $b = $remainder;
                }
                return $a;
            }

            function floatToMixedNumber($number)
            {
                $entered_num = +$number;
                if (!is_float($entered_num)) {
                    return $entered_num;
                }

                $wholePart = floor($entered_num);
                $fractionPart = $entered_num - $wholePart;

                $gcd = findGCD($fractionPart * 100, 100);

                $numerator = $fractionPart * 100 / $gcd;
                $denominator = 100 / $gcd;

                if ($wholePart == 0) {
                    return "{$numerator}/{$denominator}";
                } else {
                    return "{$wholePart} {$numerator}/{$denominator}";
                }
            }

            function square_to_feet($num)
            {
                $entered_num = +$num;
                return $entered_num * 10.764;
            }
            ?>
            <li><?= floatToMixedNumber(get_field("bedrooms")); ?> Bedrooms</li>
            <li><?= floatToMixedNumber(get_field("bathrooms")); ?> Bathrooms</li>
            <li><?= floatToMixedNumber(get_field("garages")); ?> Garages</li>
            <li><?= get_field("floor_size"); ?>m2 floor Area (<?= square_to_feet(get_field("floor_size")); ?> sq.ft.)</li>
            <li><?= get_field("lot_size"); ?>m2 Lot Size (<?= square_to_feet(get_field("lot_size")); ?> sq.ft.) </li>
        </ul>

        <div class="prop-desc">
            <h2><?= get_field("address"); ?></h2>
            <?= get_field("description"); ?>
        </div>
    </div>

    <div class="property-location">
        <div class="map">
            <span> latitude
                (<?= get_field("latitude"); ?>)
            </span> <br>
            <span> longitude -
                (<?= get_field("longitude"); ?>)
            </span>
        </div>
    </div>

    <div class="property-gallery">
        <?php
        $image_container_two = get_field("photos");

        if ($image_container_two) {
            foreach ($image_container_two as $image) { ?>
                <div class="product-gallery-image">
                    <img class="gallery-img" src="<?= $image["url"]; ?>" alt="product-image">
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="not-found">
                <h2><?= strtoupper(get_field_object("photos")["label"]); ?> Not found</h2>
            </div>
        <?php } ?>


    </div>
    <div class="property-video">
        <?php
        $video_container = get_field("videos");

        if ($video_container) {
            foreach ($video_container as $video) { ?>
                <h2> <?= strtoupper(get_field_object("videos")["label"]); ?></h2>
                <div class="product-gallery-image">
                    <video src="<?= $video['url']; ?>"></video>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="not-found">
                <h2> <?= strtoupper(get_field_object("videos")["label"]); ?> Not found</h2>
            </div>
        <?php } ?>
    </div>
    <div class="property-floorplan">
        <?php
        $property_floorplan = get_field("floorplans");

        if ($property_floorplan) {
            foreach ($property_floorplan as $floorplans) { ?>
                <div class="product-gallery-image">
                    <h2> <?= strtoupper(get_field_object("floorplans")["label"]); ?></h2>
                    <iframe id="inlineFrameExample" title="Inline Frame Example" src="<?= $floorplans['url']; ?>">
                    </iframe>
                </div>
            <?php } ?>
        <?php  } else { ?>
            <div class="not-found">
                <h2> <?= strtoupper(get_field_object("floorplans")["label"]); ?> Not found</h2>
            </div>
        <?php  } ?>
    </div>
</div>


<style>
    .product-main .owl-stage-outer {
        overflow-x: hidden;
        max-height: 700px;
    }

    .product-main .owl-stage {
        display: flex;
    }

    .product-main {
        width: 1440px;
        padding: 25px;
        margin: 0 auto;
    }

    .product-main .owl-carousel-product {
        width: 100%;
    }

    .product-main .carousel-img {
        width: 100%;
    }

    .button-grp,
    .id-sec {
        display: flex;
        justify-content: space-between;

    }

    .button-grp {
        gap: 10px;
    }

    .button-grp button {
        background-color: #525252;
    }

    .detail-page-inner {
        background-color: #f3f3f5;
        padding: 10px 15px;
    }


    .property-floorplan,
    .property-video,
    .property-gallery,
    .property-location,
    .property-details,
    .detail-page-inner {
        margin-top: 15px;
    }

    .cards {
        display: flex;
        gap: 20px;
    }

    .open-homes,
    .auction {
        background-color: #fff;
        width: 100%;

    }

    .address {
        display: flex;
        justify-content: space-between;
    }

    .property-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .gallery-img {
        width: 250px;
        height: -webkit-fill-available;
        object-fit: cover;
    }

    iframe {
        border: 0;
        width: 100%;
        height: 524px;
    }
</style>
<?php get_footer(); ?>