<section class="full-width-text">
	<?php $uat_full_width_content_title = get_sub_field( 'uat_full_width_content_title' ); ?>
	<?php if($uat_full_width_content_title){ ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
			  <h1 class="text-center"><?php the_sub_field( 'uat_full_width_content_title' ); ?></h1> 			
			</div>
		</div>	
	</div>
	<?php } ?>	
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-xs-12">
					<?php the_sub_field( 'uat_full_width_content' ); ?>
				</div> 
			</div>	
		</div>	
</section>