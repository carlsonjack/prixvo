<div id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class(); ?>>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<div class="col-sm-12">
				<?php if ( has_post_thumbnail() ) { ?>
				 <?php the_post_thumbnail("full"); ?>
				<?php  } ?>
					<?php the_content(); ?>
				</div>
			</div>
</div>
