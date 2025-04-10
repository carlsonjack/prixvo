<section class="three-col-sec">
	<?php $uat_four_column_title = get_sub_field( 'uat_four_column_title' ); ?>
	<?php if($uat_four_column_title){ ?>
	<div class="container">
		<div class="d-flex align-items-center">
			<div class="col-sm-12 col-xs-12">
			  <h1 class="text-center"><?php the_sub_field( 'uat_four_column_title' ); ?></h1> 			
			</div>
		</div>	
	</div>
	<?php } ?>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-xd-12">
				<?php the_sub_field( 'four_col_content_1' ); ?>
			</div> 
			<div class="col-sm-3 col-xd-12">
				<?php the_sub_field( 'four_col_content_2' ); ?>
			</div> 
			<div class="col-sm-3 col-xd-12">
				<?php the_sub_field( 'four_col_content_3' ); ?>
			</div> 
			<div class="col-sm-3 col-xd-12">
				<?php the_sub_field( 'four_col_content_4' ); ?>
			</div> 
		</div>	
	</div>
</section>