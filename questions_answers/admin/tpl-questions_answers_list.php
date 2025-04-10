<div class="container scroll-data">
      
        <div class="div-table">
            <div class="table"  >
			<div class="tr">
				<div class="table-td Event-Name"><?php echo _e('Event Name', 'ultimate-auction-pro-software'); ?></div>
				<div class="table-td Product-Name"><?php echo _e('Product Name', 'ultimate-auction-pro-software'); ?></div>
				<div class="table-td Who-Asked"><?php echo _e('Who Asked?', 'ultimate-auction-pro-software'); ?></div>
				<div class="table-td Question-details"><?php echo _e('Question', 'ultimate-auction-pro-software'); ?></div>
				<div class="table-td Is-it-Approved"><?php echo _e('Is it Approved?', 'ultimate-auction-pro-software'); ?></div>
				<div class="table-td Submitted-On"><?php echo _e('Submitted On', 'ultimate-auction-pro-software'); ?></div>
				<div class="table-td Actions-details"><?php echo _e('Actions', 'ultimate-auction-pro-software'); ?></div>
			</div>
			
            </div>
			
			<div class="table" id="qv_list_result" >
		
			
            </div>
          </div>
          
     </div>
 





	

 
 
 
 





<div id="qa_list_loadmore">
<div id="qa_list_loader"></div>
<a href="javascript:;" id="qa_list_loadmore_btn"><?php echo _e('Load More', 'ultimate-auction-pro-software'); ?></a></div>
		
<script type="text/javascript">
var setpage=1;
qa_pagination(setpage); 
jQuery( document ).ready(function() {  
  jQuery( '#qa_list_loadmore_btn' ).click(function(){
	  setpage++;
	  qa_pagination(setpage);
  });  
});
function qa_pagination(setpage){
	 
jQuery("#qa_list_loader").html('Loading...');
 jQuery.ajax({
	url:'<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
	type: "post",
	data: {
		action: 'qa_pagination_fun',
		setpage: setpage,
		filter_flt: '<?php echo $filter; ?>',
		 
	 },
	success: function(data){
		jQuery("#qa_list_loader").html('');
		jQuery("#qv_list_result").append(data);		 
		
	 },
	error:function(){
		 console.log('failure!');  
	}                
	
 });   
}
</script>	
