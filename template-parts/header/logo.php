<!-- // Logo \\ -->

<?php
	// Prevent direct access
	if (!defined('ABSPATH')) exit;
?>
<a class="navbar-brand d-block" href="<?php echo site_url(); ?>">
	<?php
		if(get_field('header_logo', 'option')) {
			echo "<img src='". get_field('header_logo', 'option')['url']."' alt='". get_field('header_logo', 'option')['alt'] ."' class='img-fluid'/>";
		} else {
			echo get_bloginfo('name');
		}
	?>
</a>

<!-- \\ Logo // -->