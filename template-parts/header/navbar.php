<?php
    // Prevent direct access
    if (!defined('ABSPATH')) exit;
?>
<?php
    wp_nav_menu( array(
        'theme_location'    => 'primary',
        'container'         => null,
        'depth'             => 2,
        // 'menu_class'        => 'navbar-nav',
        // 'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
        // 'walker'            => new WP_Bootstrap_Navwalker(),
    ) );
?>