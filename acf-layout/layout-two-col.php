<section class="two-col-sec">
	<?php $uat_two_column_title = get_sub_field( 'uat_two_column_title' ); ?>
	<?php if($uat_two_column_title){ ?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
			  <h1 class="text-center"><?php the_sub_field( 'uat_two_column_title' ); ?></h1> 			
			</div>
		</div>	
	</div>
	<?php } ?>	
	<div class="container">		
		<div class="row">			
			<div class="col-sm-6 col-xs-12">
				<?php the_sub_field( 'two_col_content_1' ); ?>			   
			</div> 
			<div class="col-sm-6 col-xs-12">
				<?php the_sub_field( 'two_col_content_2' ); ?>
			</div> 			 
		</div>	
	</div>
</section>


