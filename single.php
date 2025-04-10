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
<div class="uat-defult-sec">
	<?php echo uat_theme_breadcrumbs();?>
	<div class="container">
	<div class="row">
		<?php if (have_posts()): while (have_posts()):the_post();  ?>
			<div class="left-block">
				<h1 class="page-title page-title"><?php the_title();?></h1>
				<div class="entry-meta">
					<?php echo uat_theme_posted_on();?> <?php echo ultimate_auction_theme_posted_by();?>                     
				</div>
				<?php /*
				<?php if ( has_post_thumbnail() ) { $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'blog-detail' ); ?>
					<div class="entry-image"><img src="<?php echo $thumbnail['0']; ?>" /></div>
				<?php  } ?>	*/ ?>

				<div class="blog-dtl-cap">
					<div class="entry-content"><?php the_content(); ?></div>
					<div class="tag-name"><?php echo uat_theme_categorized_blog();?></div>
				</div>
				<div class="single-navigation clearfix">
					<?php previous_post_link( '%link', esc_attr__( 'Previous', 'ultimate-auction-pro-software' ) ); ?>
					<?php next_post_link( '%link', esc_attr__( 'Next', 'ultimate-auction-pro-software' ) ); ?>
				</div>
					
				<?php edit_post_link('Edit this entry', '', '.'); ?>
				<?php 
					$comments = get_option('blog_default_page_comments',"on");
					if (!empty($comments) && $comments == 'on') :
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					endif; 
				?>
			</div>
		<?php  endwhile;  endif; ?>	
		<div class="right-block right-sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>
	</div>
</div>
<?php get_footer(); ?>