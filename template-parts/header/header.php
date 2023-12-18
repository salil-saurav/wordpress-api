<!-- // Header \\ -->
<header class="m-0">
	<!-- // Desktop Navbar \\ -->
	<nav class="navbar d-none d-xl-flex p-0">
		<div class="container-fluid">
			<div class="col-md-5">
				<div class="start-nav">
					<?php get_template_part('template-parts/header/navbar'); ?>
				</div>
			</div>
			<div class="col-md-2">
				<div class="text-center">
					<?php get_template_part('template-parts/header/logo'); ?>
				</div>
			</div>
			<div class="col-md-4 offset-md-1">
				<div class="end-nav d-flex align-items-center">
					<?php get_template_part('template-parts/header/navbar'); ?>
					<?php get_template_part('template-parts/header/social-media'); ?>
				</div>
			</div>
		</div>
	</nav>
	<!-- \\ Desktop Navbar // -->
	<!-- // Mobile Navbar \\ -->
	<div class="mobile-navbar d-flex align-items-center justify-content-between d-xl-none">
		<?php get_template_part('template-parts/header/logo'); ?>
		<div class="menu-trigger">
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>
	<!-- \\ Mobile Navbar // -->
</header>
<!-- \\ Header // -->