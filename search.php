<?php
/**
* Theme functions and definitions
*
* @package WordPress
* @subpackage Defaulut Theme
* @author Defaulut Theme, Inc.
*
*/
get_header(); ?>

<div id="primary" class="content-area">
    <div class="container">
		<h1 class="page-title page-title"><?php esc_html_e( 'Search Results', 'ultimate-auction-pro-software' ); ?></h1>
		<div class="row">
			<div class="left-block">
			<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post(); ?>
			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<a href=<?php echo esc_url(get_permalink());?>><h2><?php the_title(); ?></h2></a>
				<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
			</div>
			<?php endwhile; ?>
			<?php else: ?>
			<?php get_template_part( 'templates/content', 'none' ); ?>
			<?php endif; ?>
			</div>
			
			<div class="right-block right-sidebar">
			 <?php get_sidebar(); ?>
			</div>
		
		</div>
	</div>
</div>
<?php get_footer(); ?>