<?php
/* Template Name: Right Sidebar*/ 
get_header(); ?>
<div class="uat-defult-sec">
<?php echo uat_theme_breadcrumbs();?>
	<div class="container">
		<h1 class="page-title page-title"><?php the_title();?></h1>
		<div class="row">
			<div class="left-block">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<div class="col-sm-12">
				<?php if ( has_post_thumbnail() ) { ?>
				 <?php the_post_thumbnail("full"); ?>					 
				<?php  } ?>	
					<?php the_content(); ?>
				</div>
				</div>
			</div>
			<?php	endwhile; ?>
			<?php endif; ?>	
			<?php if ( have_rows( 'uat_flex_content_mgt' ) ): ?>
	<?php while ( have_rows( 'uat_flex_content_mgt' ) ) : the_row(); ?>
		<!--Heading Element-->	
		<?php if ( get_row_layout() == 'uat_heading' ) : ?>		
			<?php  get_template_part( 'acf-layout/layout', 'heading' ); ?>
		<!--Heading Element END-->			
		<!--Full Width Col Element-->		
		<?php elseif ( get_row_layout() == 'uat_full_width_content' ) : ?>
			<?php  get_template_part( 'acf-layout/layout', 'full-width-content' ); ?>	
		<!--Full Width Col Element End-->
		<!--Two Col Element-->	
		<?php elseif ( get_row_layout() == 'uat_two_column' ) : ?>
		<?php  get_template_part( 'acf-layout/layout', 'two-col' ); ?>	
		<!--Two Col Element End-->		
		<!--three Col Element-->	
		<?php elseif ( get_row_layout() == 'uat_three_column' ) : ?>
		<?php  get_template_part( 'acf-layout/layout', 'three-col' ); ?>	
		<!--three Col Element End-->		
		<!--four Col Element-->	
		<?php elseif ( get_row_layout() == 'uat_four_column' ) : ?>
		<?php  get_template_part( 'acf-layout/layout', 'four-col' ); ?>	
		<!--four Col Element End-->	
		<!--Full Width Image Element-->
		<?php elseif ( get_row_layout() == 'uat_full_width_image' ) : ?>
			<?php  get_template_part( 'acf-layout/layout', 'full-width-image' ); ?>		
		<!--Full Width Image Element End-->
		<!--Right Image Left Content Element-->	
		<?php elseif ( get_row_layout() == 'uat_right_image_left_content' ) : ?>
		<?php  get_template_part( 'acf-layout/layout', 'right-image-left-content' ); ?>
		<!--Right Image Left Content Element End-->		
		<!--Left Image Right Content Element-->
		<?php elseif ( get_row_layout() == 'uat_left_image_right_content' ) : ?>
			<?php  get_template_part( 'acf-layout/layout', 'left-image-right-content' ); ?>
		<!--Left Image Right Content Element End-->
		<!--Banner Slider Element-->
		<?php elseif( get_row_layout() == 'uat_content_banner_slider' ) : ?>	
			<?php  get_template_part( 'acf-layout/layout', 'banner-slider' ); ?>
		<!--Banner Slider Element End-->
		<!--Auctions Slider Element-->
		<?php elseif ( get_row_layout() == 'uat_content_auction_product_slider' ) : ?>
			<?php  get_template_part( 'acf-layout/layout', 'auction-slider' ); ?>
		<!--Auctions Slider Element End-->
		<?php elseif ( get_row_layout() == 'uat_content_featured_categories' ) : ?>
			<?php  get_template_part( 'acf-layout/layout', 'featured-categories' ); ?>
		<!--Active bid Element-->
		<?php elseif ( get_row_layout() == 'uat_content_active_bid' ) : ?>	
			<?php  get_template_part( 'acf-layout/layout', 'active-bid' ); ?>
		<!--Active bid Element End-->
		<!--Live and Upcoming Events Element-->
		<?php elseif ( get_row_layout() == 'uat_content_current_upcoming_auctions' ) : ?>
			<?php  get_template_part( 'acf-layout/layout', 'current-upcoming-events' ); ?>
		<!--Live and Upcoming Events Element End-->
		<!--Live Events Element-->
		<?php elseif ( get_row_layout() == 'uat_content_live_auction_events' ) : ?>
			<?php  get_template_part( 'acf-layout/layout', 'live-events' ); ?>
		<!--Live Events Element End-->
		<!--Future Events Element-->
		<?php elseif ( get_row_layout() == 'uat_content_future_auction_events' ) : ?>	
			<?php  get_template_part( 'acf-layout/layout', 'future-events' ); ?>
		<!--Future Events Element End-->
		<!--Past Events Element-->		
		<?php elseif ( get_row_layout() == 'uat_content_past_auction_events' ) : ?>	
			<?php  get_template_part( 'acf-layout/layout', 'past-events' ); ?>
		<!--Past Events Element End-->
		<!--Trending Items Element-->
		<?php elseif ( get_row_layout() == 'uat_content_trending_items' ) : ?>	
			<?php  get_template_part( 'acf-layout/layout', 'trending-items' ); ?>
		<!--Trending Items Element END-->
		<!--Blogs Element-->
		<?php elseif ( get_row_layout() == 'uat_content_blog_post' ) : ?>	
			<?php $blog_type = get_sub_field( 'uat_content_blog_post_type' ); ?>			
			<?php if( $blog_type == "latest_media"){ ?>			
					<?php  get_template_part( 'acf-layout/layout', 'blog-post' ); ?>
			<?php } else { ?>
				<?php  get_template_part( 'acf-layout/layout', 'blog-post-2' ); ?>
			<?php } ?>
		<!--Blogs Element End-->
		<!--Border Line Element-->
		<?php elseif ( get_row_layout() == 'uat_content_border_line' ) : ?>
			<?php  get_template_part( 'acf-layout/layout', 'hr-border' ); ?>
		<!--Border Line Element End-->
		<!--Empty Space Element-->		
		<?php elseif ( get_row_layout() == 'uat_content_empty_space' ) : ?>	
			<?php  get_template_part( 'acf-layout/layout', 'empty-space' ); ?>
		<!--Empty Space Element End-->
		<?php endif; ?>
	<?php endwhile; ?>
	<?php endif; ?>
			</div>
			<div class="right-block right-sidebar">
			<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer();