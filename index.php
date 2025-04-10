<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Ultimate Auction Pro Software
 * @since Ultimate Auction Pro Software 1.0
 */
get_header();
$page_for_posts = get_option( 'page_for_posts' );
$blog_page_title = "Blogs";
if(!empty($page_for_posts)){
	$blog_page_title = get_the_title($page_for_posts);
}
?>
<div id="primary" class="content-area">
    <div class="container">
		<h1 class="page-title page-title"><?php echo esc_attr($blog_page_title);?></h1>
		<div class="row">
			<div class="left-block">
			<?php
			if ( have_posts() ) :
				if ( is_home() && ! is_front_page() ) : ?>
				<?php endif;
				/* Start the Loop */
				while ( have_posts() ) :	the_post();
				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'templates/content', get_post_type() );
				endwhile;
				the_posts_pagination();
				else :
					get_template_part( 'templates/content', 'none' );
				endif;
				?>
			</div>
			
			<div class="right-block right-sidebar">
			 <?php get_sidebar(); ?>
			</div>
		
		</div>
	</div>
</div>
<?php get_footer(); ?>