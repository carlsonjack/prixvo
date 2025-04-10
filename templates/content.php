<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ultimate-auction-pro-software
 * 
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="item-post">
			<?php if (has_post_thumbnail()) : ?>
				<div class="post-image col-md-3">
					<?php ultimate_auction_theme_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
			<div class="post-text col-md-<?php echo has_post_thumbnail() ? 9 : 12; ?>">
					
					<?php if (!is_single()) : the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); endif; ?>

					<div class="entry-meta">
						<?php
						if ('post' == get_post_type()): 
							uat_theme_posted_on();
						endif; ?>
					</div>
					<?php if (in_array('category', get_object_taxonomies(get_post_type())) && uat_theme_categorized_blog()) : endif; ?>
				<?php if (!is_single()) : ?>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->
				<?php else : ?>
					<div class="entry-content">
						<?php
						the_content(wp_kses(__('Continue reading <span class="meta-nav">&rarr;</span>', 'ultimate-auction-pro-software'), array('span' => array('class' => array()))));
						wp_link_pages(array(
							'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__('Pages:', 'ultimate-auction-pro-software') . '</span>',
							'after' => '</div>',
							'link_before' => '<span>',
							'link_after' => '</span>',
						));
						?>
					</div><!-- .entry-content -->
				<?php endif; ?>
			</div>
		</div>
	</div>
</article><!-- #post-## -->
