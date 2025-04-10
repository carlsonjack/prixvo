<?php $uat_full_width_image = get_sub_field( 'uat_full_width_image' ); ?>
<?php if ( $uat_full_width_image ) { ?>
<section class="full-width-img">
	<?php $uat_full_width_image_container = get_sub_field( 'uat_full_width_image_container' ); ?>
	<?php if($uat_full_width_image_container=="yes"){ ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
			<img src="<?php echo $uat_full_width_image['url']; ?>" alt="<?php echo $uat_full_width_image['alt']; ?>" />
			</div> 
		</div>	
	</div>
	<?php }else { ?>
		   <img src="<?php echo $uat_full_width_image['url']; ?>" alt="<?php echo $uat_full_width_image['alt']; ?>" />
	<?php } ?>
</section>
<?php } ?>