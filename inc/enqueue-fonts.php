<?php

function dmc_google_font_loader_tag_filter( $html, $handle ) {
	if ( $handle === 'preload-fonts' ) {
		$rel_preconnect = "rel='preconnect'";

		return str_replace(
			"rel='stylesheet'",
			$rel_preconnect,
			$html
		);
	}
	return $html;
}
add_filter( 'style_loader_tag', 'dmc_google_font_loader_tag_filter', 10, 2 );