<section class="text-with-image-sec">
	<?php $uat_left_image_right_content_title = get_sub_field( 'uat_left_image_right_content_title' ); ?>
	<?php if($uat_left_image_right_content_title){ ?>
	<div class="container">
		<div class="d-flex align-items-center">
			<div class="col-sm-12">
			  <h1 class="text-center"><?php the_sub_field( 'uat_left_image_right_content_title' ); ?></h1> 			
			</div>
		</div>	
	</div>
	<?php } ?>		
	<div class="container">
		<div class="row two-col-block align-items-center img-with-content">
			<div class="img-blocks col-sm-6 pd-0 col-xs-12">
			<?php $uat_left_image_right_content_image = get_sub_field( 'uat_left_image_right_content_image' ); ?>
				<?php if ( $uat_left_image_right_content_image ) { ?>
					<img src="<?php echo $uat_left_image_right_content_image['url']; ?>" alt="<?php echo $uat_left_image_right_content_image['alt']; ?>" />
				<?php } ?>
			</div> 
			
			<div class="col-sm-6 col-xs-12">
			<?php the_sub_field( 'uat_left_image_right_content_content' ); ?>
			</div>		
		</div>	
	</div>	
</section>