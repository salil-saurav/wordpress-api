<!-- // Social Media \\ -->
<?php if( get_field( 'show_social_media_icons_in_header','option' ) == 'yes' ) { ?>
    <?php if( have_rows('social_media','option') ) { ?>
        <div class="social-icons d-flex align-items-center justify-content-center">
            <?php while( have_rows('social_media','option') ) {
                the_row();
                $icon = get_sub_field('social_media_icon');
                $helperText = get_sub_field('helper_text');
                $link = get_sub_field('social_media_link');
            ?>
                <a href="<?php echo esc_url($link); ?>" target="_blank" title="<?php echo esc_html($helperText) ?>" class="d-flex align-items-center justify-content-center">
                    <i class="fa fa-<?php echo esc_html($icon) ?>" aria-hidden="true"></i>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
<?php } ?>
<!-- \\ Social Media // -->