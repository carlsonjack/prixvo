 
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<div class="mh-grid-alternative__col-1">
<div class="custom-fileds-header">

	<h2><?php _e('Custom Fields For Auction Products', 'ultimate-auction-pro-software') ?></h2>	
	<button class="add_new_field mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent " style="display: block;" data-upgraded=",MaterialButton,MaterialRipple">
		<?php _e('Add new field', 'ultimate-auction-pro-software') ?>
		<span class="mdl-button__ripple-container">
			<span class="mdl-ripple"></span>
		</span>
	</button>		
</div>	
			<div class="mh-attributes-wrapper">
					<div class="mh-single-attribute mh-single-attribute--header">
						<div class="mh-single-attribute__id"><?php _e('Order', 'ultimate-auction-pro-software') ?></div> 
						<div class="mh-single-attribute__name"><?php _e('Name', 'ultimate-auction-pro-software') ?></div> 
						<div class="mh-single-attribute__type"><?php _e('Type', 'ultimate-auction-pro-software') ?></div> 
						<div class="mh-single-attribute__edit-button"><?php _e('Edit', 'ultimate-auction-pro-software') ?></div> 
						<div class="mh-single-attribute__delete-button"><?php _e('Remove', 'ultimate-auction-pro-software') ?> </div>
					</div>
					<div class="cf-tbody sortable"></div>
			</div>			
</div>

<div class="mh-grid-alternative__col-2" >
	<h2 class="new-field-msg" style="display: block;"><?php _e('Create New Custom Field', 'ultimate-auction-pro-software') ?></h2>
	<h2 class="update-field-msg" style="display: none;"><?php _e('Updtae Custom Field', 'ultimate-auction-pro-software') ?></h2>
	<div>
		<div class="mh-new-field">
			<form name="frm_add_field" id="frm_add_field">
					<div class="mh-new-field__input-wrapper">
					<label for="field-name"><?php _e('Field name', 'ultimate-auction-pro-software') ?></label>
					<input id="field-name" type="text">
					<input id="edit-id" type="hidden">
					</div>
					<div class="mh-new-field__input-wrapper">
						<label for="field-type"><?php _e('Field type', 'ultimate-auction-pro-software') ?></label>
						<select id="field-type">
							<option value="text"><?php _e('Text', 'ultimate-auction-pro-software') ?></option>
							<option value="number"><?php _e('Number', 'ultimate-auction-pro-software') ?></option>
							<option value="select"><?php _e('Dropdown', 'ultimate-auction-pro-software') ?></option>
						</select>
					</div>
					<div class="mh-new-field__input-wrapper dropdown-options " style="display: none;">
						<label for="field-type-options">
							<?php _e('Add your options', 'ultimate-auction-pro-software') ?> 
							<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent" id="add-option-button" type="button"><?php _e('Add new option', 'ultimate-auction-pro-software') ?></button>
						</label>
						<div class="options-box-demo" style="display: none;">
							<input type="text" placeholder="<?php _e('Enter option value', 'ultimate-auction-pro-software') ?>" />
							<button type="button" class="removeOption"><?php _e('Remove', 'ultimate-auction-pro-software') ?></button>
						</div>
						<div class="options-containter"></div>
					</div>
					<button class="btn_add_field mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent new-field-btn" style="display: block;" data-upgraded=",MaterialButton,MaterialRipple">
						<?php _e('Create new field', 'ultimate-auction-pro-software') ?>
						<span class="mdl-button__ripple-container">
							<span class="mdl-ripple"></span>
						</span>
					</button>
					<button data-id="" class="btn_add_field mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent update-field-btn" style="display: none;" data-upgraded=",MaterialButton,MaterialRipple">
						<?php _e('Update', 'ultimate-auction-pro-software') ?>
						<span class="mdl-button__ripple-container">
							<span class="mdl-ripple"></span>
						</span>
					</button>
			</form>			
		    <div class="message"></div>
		</div>		
	</div>
								
</div>

	
<script>
	function addNewOptionBox(val){
		var optionsBox = jQuery(".options-box-demo").clone();
		optionsBox.find("input").attr("name", 'options[]');
		if(val){
			optionsBox.find("input").val(val);
		}else{
			optionsBox.find("input").val("");
		}
		optionsBox.attr("class", 'options-box');
		optionsBox.show();
		jQuery(".options-containter").append(optionsBox);
	}
		function setOptionsForm(id){
			if(id){
				jQuery.ajax({
							type : "post",
							url : ajaxurl,
							dataType : "json",
							data : {action: "uat_auctions_custom_fields_get", "edit_id":id },
							success: function(response) {
								if(response.data){
									let field_data = response.data;
									jQuery("#field-name").val(field_data.attribute_name);
									jQuery("#field-type").val(field_data.attribute_type);
									jQuery('select#field-type').trigger('change');
									jQuery(".options-containter").html("");
									if(field_data.attribute_type == 'select'){
										let filed_options = field_data.options;

										jQuery.each(filed_options, function(i, item) {
											addNewOptionBox(item)
										});
										jQuery(".dropdown-options").show();
									}
									jQuery(".update-field-btn").attr('data-id', field_data.id);
									jQuery(".new-field-msg").hide();
									jQuery(".new-field-btn").hide();
									jQuery(".update-field-msg").show();
									jQuery(".update-field-btn").show();
									jQuery(".add_new_field").show();
								}
							}
						});
			}else{
				jQuery("#field-name").val("");
				jQuery("#field-type").val("text");
				jQuery(".options-containter").html("");
				addNewOptionBox();
				jQuery(".dropdown-options").hide();
				jQuery(".new-field-msg").show();
				jQuery(".new-field-btn").show();
				jQuery(".update-field-msg").hide();
				jQuery(".update-field-btn").hide();
				jQuery(".add_new_field").hide();
			}	
		}
		function updateCustomFieldsData(ids = null){
					jQuery.ajax({
						type : "post",
						url : ajaxurl,
						dataType : "json",
						data : {action: "uat_auctions_custom_fields_get", "ordered_ids":ids },
						success: function(response) {
							jQuery(".cf-tbody").html("");
							if(response.data){
								
								jQuery.each(response.data, function(i, item) {
									var tableHtml = "<div class='draggable' data-id='"+item.id+"'>";
											tableHtml += "<div class='mh-single-attribute datatr1'>";
											tableHtml += "<div class='mh-single-attribute__id'>"+item.form_order+"</div>";
											tableHtml += "<div class='mh-single-attribute__name'>"+item.attribute_name+"</div>";
											tableHtml += "<div class='mh-single-attribute__type'>"+item.attribute_type+"</div>";
											tableHtml += "<div class='mh-single-attribute__type mh-single-attribute__edit-button'><button class='btn_edit_field mdl-button mdl-js-button mdl-button--primary' data-upgraded=',MaterialButton' data-id='"+item.id+"'><?php _e('Edit', 'ultimate-auction-pro-software') ?></button></div>";
											tableHtml += "<div class='mh-single-attribute__delete-button'><button class='btn_remove_field mdl-button mdl-js-button mdl-button--primary' data-id='"+item.id+"'><?php _e('Remove', 'ultimate-auction-pro-software') ?></button></div>";
											tableHtml += "</div>";
											tableHtml += "<div class='datatr2' style='display:none' id='edit_"+item.id+"'>";
											tableHtml += "";
											tableHtml += "</div>";
											
										tableHtml += "</div>";
										jQuery(".cf-tbody").append(tableHtml);
								});
								
							}else{
								var tableHtml = "<div>";
									tableHtml += "<div colspan='5'>"+response.message+"</div>";
									tableHtml += "</div>";
								jQuery(".cf-tbody").append(tableHtml);
							}
						}
					});
		}
jQuery(document).ready(function ($) {
	
	var button = $("#add-option-button");
	var optionErrroMsg  = '<?php echo __('Please ensure that you provide at least one option with a value.', 'ultimate-auction-pro-software') ?>';
	var fieldErrroMsg  = '<?php echo __('Kindly provide all the required details.', 'ultimate-auction-pro-software') ?>';
	button.click(function(e) {
		e.preventDefault();
		addNewOptionBox();
	});
	
	jQuery(document).on('click','.add_new_field',function(e){
		e.preventDefault();
		setOptionsForm();
	});
	jQuery(document).on('click','.removeOption',function(e){
		e.preventDefault();
		var l = $(".options-box").length;
		if(l == 1){
			jQuery(".message").html(optionErrroMsg);
		}else{
			jQuery(this).parent(".options-box").remove();	 
		}
	});
	jQuery(document).on('change','select#field-type',function(e){
		var val = $(this).val();
		if(val == 'select'){
			$(".dropdown-options").show();
		}else{
			$(".dropdown-options").hide();
		}
	});
	jQuery( ".sortable" ).sortable({update: function( event, ui ) {
		var newOrder = [];
		jQuery.each(jQuery(".sortable .draggable"), function(i, item) {
			newOrder.push(jQuery(item).attr("data-id"));
		});
		updateCustomFieldsData(newOrder);
	}});
	setOptionsForm();
	updateCustomFieldsData();

	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	jQuery(document).on('click','.btn_edit_field',function(e){
		e.preventDefault();
		var cf_id = jQuery(this).attr("data-id");		
		jQuery(".message").html(""); 
		setOptionsForm(cf_id);
	});
	
	jQuery(document).on('click','.btn_add_field',function(e){
		e.preventDefault();
		jQuery(".message").html("");
		
		var cf_options = jQuery("input[name='options[]']").map(function() {
						return this.value;
					 }).get();
		var cf_name = jQuery("#field-name").val();
		var cf_type = jQuery("#field-type").val();
		if(cf_type == 'select'){
			if($(".options-box").length < 1){
				jQuery(".message").html(optionErrroMsg);
				return false;
			}
			if($(".options-box:nth-child(1) input").val().length < 1){
				jQuery(".message").html(optionErrroMsg);
				return false;
			}
		}
		if(cf_name == ''){
			jQuery(".message").html(fieldErrroMsg);
			return false;
		}
		var cf_edit_id = jQuery(this).attr('data-id');
		var action = "uat_auctions_custom_fields_add";
		if(cf_edit_id)
		{
			action = "update_custom_field";
		}
		jQuery.ajax({
					type : "post",
					url : ajaxurl,
					dataType : "json",
					data : {action: action, 
							cf_name: cf_name, 
							cf_type: cf_type, 
							cf_options: cf_options, 
							cf_edit_id: cf_edit_id },
					success: function(response) {
						jQuery(".message").html(response.message);
						if(response.status){
							updateCustomFieldsData();
							setOptionsForm();
						}
					}
				});
	});
	jQuery(document).on('click','.btn_remove_field',function(e){
		e.preventDefault();

		jQuery(".message").html("");
		var cf_id = jQuery(this).attr("data-id");
		jQuery.ajax({
					type : "post",
					url : ajaxurl,
					dataType : "json",
					data : {action: "uat_auctions_custom_fields_remove", "cf_id": cf_id },
					success: function(response) {
						jQuery(".message").html(response.message);
						if(response.status){
							updateCustomFieldsData();
						}
					}
				});
	});

});
</script>