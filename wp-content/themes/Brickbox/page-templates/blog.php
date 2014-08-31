<?php
/**
 * Template Name: Blog Page
 *
 * @package WordPress
 * @subpackage Brickbox
 * @since Brickbox 1.0
 */

get_header();?>

<div id="main" class="blog-page site-main">

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && brickbox_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_sidebar( 'blog' );
get_footer();
