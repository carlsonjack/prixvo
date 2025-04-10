<?php
 $pixel = get_sub_field( 'uat_content_spacer_pixel' );  
 if(empty($pixel)){
	$pixel = 10; 	
 } 
 ?>
<?php
if ( wp_is_mobile() ) { ?>
<div class="uat-empty-space" style="height:<?php echo $pixel/2;?>px;">
</div>
<?php } else { ?>
<div class="uat-empty-space" style="height:<?php echo $pixel;?>px;">
</div>
<?php } ?>