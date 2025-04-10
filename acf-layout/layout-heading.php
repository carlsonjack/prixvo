<?php $uat_heading_title = get_sub_field( 'uat_heading_title' ); ?>
<?php if($uat_heading_title){ ?>
<section class="heading-full-width container">	 
		<div class="row">
			<div class=" col-sm-12 col-xs-12 text-center">
				<h1><?php the_sub_field( 'uat_heading_title' ); ?></h1>	
			</div> 
		</div>		 
</section>
<?php } ?>