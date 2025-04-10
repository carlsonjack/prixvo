<section class="text-with-image-sec">	
	<?php $uat_right_image_left_content_title = get_sub_field( 'uat_right_image_left_content_title' ); ?>
	<?php if($uat_right_image_left_content_title){ ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
			  <h1 class="text-center"><?php the_sub_field( 'uat_right_image_left_content_title' ); ?></h1> 			
			</div>
		</div>	
	</div>
	<?php } ?>
	<div class="container">
		<div class=" row two-col-block align-items-center img-with-content">
			<div class="col-sm-6 col-xs-12 ">
				<?php the_sub_field( 'uat_right_image_left_content_content' ); ?>
			</div> 
			<div class="img-blocks col-sm-6 col-xs-12 pd-0" >
					<?php $uat_right_image_left_content_image = get_sub_field( 'uat_right_image_left_content_image' ); ?>
					<?php if ( $uat_right_image_left_content_image ) { ?>
					<img src="<?php echo $uat_right_image_left_content_image['url']; ?>" alt="<?php echo $uat_right_image_left_content_image['alt']; ?>" />
				<?php } ?>
			</div> 
			
		</div>
	</div>
	
</section>