<?php
/**
 * Theme functions and definitions
 *
 * @package WordPress
 * @subpackage Defaulut Theme
 * @author caldwell, Inc.
 *
 */
get_header(); ?>

<div id="primary" class="content-area">
<?php echo uat_theme_breadcrumbs();?>
    <div class="container">	
	
	<?php if (have_posts()) : ?>

<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

<?php /* If this is a category archive */ if (is_category()) { ?>
 <h1 class="page-title page-title"><?php single_cat_title(); ?></h1>


<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>

<h1 class="page-title page-title"><?php single_tag_title(); ?></h1>

<?php /* If this is a daily archive */ } elseif (is_day()) { ?>

<h1 class="page-title page-title"><?php _e('Archive for', 'ultimate-auction-pro-software'); ?> <?php the_time('F jS, Y'); ?></h1>

<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>

<h1 class="page-title page-title"><?php _e('Archive for', 'ultimate-auction-pro-software'); ?> <?php the_time('F, Y'); ?></h1>

<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>

<h1 class="page-title page-title"><?php _e('Archive for', 'ultimate-auction-pro-software'); ?> <?php //the_time('Y'); ?></h1>

<?php /* If this is an author archive */ } elseif (is_author()) { ?>

<h1 class="page-title page-title"><?php _e('Author Archive', 'ultimate-auction-pro-software'); ?></h1>

<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>

<h1 class="page-title page-title"><?php _e('Blog Archives', 'ultimate-auction-pro-software'); ?></h1>

<?php } ?>
	
		<div class="row">
			<div class="left-block">
			<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'templates/content', get_post_type() );?>
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