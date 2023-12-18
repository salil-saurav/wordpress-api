<?php

/**
* Add async or defer attributes to script enqueues
*/

if(!is_admin()) {
    function add_asyncdefer_attribute($tag, $handle) {
        if (strpos($handle, 'async') !== false) {
            return str_replace( '<script ', '<script async ', $tag );
        }
        else if (strpos($handle, 'defer') !== false) {
            return str_replace( '<script ', '<script defer ', $tag );
        }
        else {
            return $tag;
        }
    }
    add_filter('script_loader_tag', 'add_asyncdefer_attribute', 10, 2);
}