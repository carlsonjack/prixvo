<?php
/* Template Name: Event List */
global $sitepress;
get_header();
$page_id =get_the_ID();
?>


   <div class="product-list-sec">
	<div class="container">
		<?php
		$list_page_layout = get_field('event_page_tmp_page_layout',$page_id);
		$page_type = isset($list_page_layout) ? $list_page_layout : "full-width";
		?>
		<div class="ua-product-list-sec <?php echo esc_attr($page_type); ?>">
			<div class="ua-filter-sidebar">
				<?php
				$resultbar_set = get_field('event_page_tmp_resultbar',$page_id);
				$resultbar = $resultbar_set ? $resultbar_set : "on";
				if ($resultbar == "on") { ?>
				<div class="ua-search-results">
				<h5><?php _e('Showing', 'ultimate-auction-pro-software'); ?>
				<span class="Result-Counts"></span> <?php _e('results', 'ultimate-auction-pro-software'); ?> </h5>
				</div>
				<?php }
				$sortbydate_set = get_field('event_page_tmp_sortbydate',$page_id);
				$sortbydate = $sortbydate_set ? $sortbydate_set : "on";
				if ($sortbydate == "on") { ?>
				<div class="ua-Filter-modual-box">
				<h4 class="ua-Filter-modual-heading"><?php _e('sort by', 'ultimate-auction-pro-software'); ?></h4>
				<ul class="ua-input-group ">
					<li>
						<input class="sortbyenddate" type="radio" id="sortbyenddate_ASC" value="ASC" name="sort-by-enddate" checked>
						<label for="sortbyenddate_ASC"><?php _e('End Date - Ascending', 'ultimate-auction-pro-software'); ?></label>
					</li>
					<li>
						<input class="sortbyenddate" type="radio" id="sortbyenddate_DESC" value="DESC" name="sort-by-enddate">
						<label for="sortbyenddate_DESC"><?php _e('End Date - Descending', 'ultimate-auction-pro-software'); ?></label>
					</li>
				</ul>
				</div>
				<?php }
				$reset_filter_set = get_field('event_page_tmp_reset_filter',$page_id);
				$reset_filter = $reset_filter_set ? $reset_filter_set : "on";
				if ($reset_filter == "on") { ?>
				<div class="ua-Filter-modual-box APPLIED_filter" id="APPLIED_filter" style="display:none;">
				<h4 class="ua-Filter-modual-heading"><?php _e('Applied Filters', 'ultimate-auction-pro-software'); ?></h4>
				<div class="APPLIED_filtered"></div>
				<div class="clear-all">
					<h5><a href="javascript:;" class="RemoveFilterall" ><?php _e('CLEAR ALL', 'ultimate-auction-pro-software'); ?></a></h5>
				</div>
				</div>
				<?php }
				$daterange_set = get_field('event_page_tmp_daterange',$page_id);
				$daterange = $daterange_set ? $daterange_set : "on";
				if ($daterange == "on") { ?>
				<div class="ua-Filter-modual-box">
				<h4 class="ua-Filter-modual-heading"><?php _e('Date', 'ultimate-auction-pro-software'); ?></h4>
				<ul class="ua-input-group">
					<li>
						<input type="text" class="from_date" placeholder="<?php _e('From', 'ultimate-auction-pro-software'); ?>" value="" name="from_date" id="from_dateD">
					</li>
					<li>
						<input type="text" class="to_date" placeholder="<?php _e('to', 'ultimate-auction-pro-software'); ?>" value="" name="to_date" id="to_dateD" >
					</li>
				</ul>
				</div>
				<?php }
				$location_set = get_field('event_page_tmp_location',$page_id);
			    $location = $location_set ? $location_set : "on";
				if ($location == "on") {
					$countries = get_events_countries_list();
				    $Countries_filter_Set = get_field('event_page_tmp_location_county',$page_id);
					$Countries_filter = $Countries_filter_Set ? $Countries_filter_Set : "off";
					if ($Countries_filter == "on") { ?>
				<!--country -->
				<div class="ua-Filter-modual-box">
					<h4 class="ua-Filter-modual-heading"><?php _e('Locations', 'ultimate-auction-pro-software'); ?></h4>

					<ul class="ua-input-group eCountriesList" id="eCountries">
				    <?php foreach ($countries as $val): ?>
						<?php if (!empty($val)) { ?>
						<li style="display:none;">
						<input type="checkbox" data-lname="<?php echo esc_attr($val); ?>" name="eCountries[]" id="eCountries_<?php echo str_replace(' ', '', $val); ?>" class="vh eCountries"  value="<?php echo $val; ?>">
						<label class="checkbox" for="eCountries_<?php echo str_replace(' ', '', $val); ?>"><?php echo esc_attr($val); ?></label>
							<?php
							$States_filter_Set = get_field('event_page_tmp_location_state',$page_id);
							$States_filter = $States_filter_Set ? $States_filter_Set : "off";
							if ($States_filter == "on") { ?>
							<div class="expandableCollapsibleDiv">
							<i class="Uat_Expand fas fa-plus"></i>
							<ul class="ua-input-group estateUL eStatesList" id="eStates">
							 <?php $states = get_events_state_list_by_country($val);
									foreach ($states as $state): ?>
									<?php if (!empty($state)) { ?>
									<li style="display:none;">
									<input type="checkbox" data-lname="<?php echo esc_attr($state); ?>" name="eStates[]" id="eStates_<?php echo str_replace(' ', '', $state); ?>" class="vh eStates"  value="<?php echo esc_attr($state); ?>">
									<label class="checkbox" for="eStates_<?php echo str_replace(' ', '', $state); ?>"><?php echo esc_attr($state); ?></label>

									<?php
                            $Cities_filter_Set = get_field('event_page_tmp_location_city',$page_id);
                            $Cities_filter = $Cities_filter_Set ? $Cities_filter_Set : "on";
                            if ($Cities_filter == "on") { ?>
									<div class="expandableCollapsibleDivCity">
							         <i class="Uat_Expand_city fas fa-plus"></i>
									 <ul class="ua-input-group eCitiesList" id="eCities">
										<?php $cities = get_events_city_list_by_state($state);
                                foreach ($cities as $city): ?>
											<?php if (!empty($city)) { ?>
											<li style="display:none;">
											<input type="checkbox" data-lname="<?php echo $city; ?>" name="eCities[]" id="eCities_<?php echo str_replace(' ', '', $city); ?>" class="vh eCities"  value="<?php echo $city; ?>">
											<label class="checkbox" for="eCities_<?php echo str_replace(' ', '', $city); ?>"><?php echo $city; ?></label>
										</li>

											<?php
                                    } ?>
										<?php
                                endforeach; ?>
										</ul>
										</div>
										<?php
                            } ?>


									</li>

									<?php
                        } ?>
								<?php
                    endforeach; ?>
							</ul>
							</div>

							<?php
                } ?>

						</li>

						<?php
            } ?>
					<?php
        endforeach; ?>
					</ul>

					<div class="clear-all see_all_eCountries_div">
						<h5><a  class="see_all_eCountries_btn" id="see_all_eCountries" href="javascript:;"><?php _e('See ALL', 'ultimate-auction-pro-software'); ?></a></h5>
					</div>
				</div>

				<?php
    } ?>

				<?php
}
 ?>


				<?php
		$category_set = get_field('event_page_tmp_category',$page_id);
		if ($category_set == "on") { ?>
				<div class="ua-Filter-modual-box">
				<h4 class="ua-Filter-modual-heading"><?php _e('CATEGORY', 'ultimate-auction-pro-software'); ?></h4>
				<ul class="ua-input-group eCategoryList" id="ecategory">
					<?php
			$terms = get_terms('uat-event-cat', array('hide_empty' => false, 'orderby' => 'title', 'order' => 'ASC'));
			foreach ($terms as $term) { ?>
					<li style="display:none;">
						<input type="checkbox" data-lname="<?php echo $term->name; ?>" name="chk_cat_ids[]" id="cat_<?php echo $term->term_id; ?>" class="vh p_cats"  value="<?php echo $term->term_id; ?>">
						<label class="checkbox" for="cat_<?php echo $term->term_id; ?>"><?php echo $term->name; ?></label>
					</li>
					<?php
    } ?>
				</ul>
				<div class="clear-all see_all_cats_div">
					<h5><a class="see_all_cats_btn"  id="see_all_cats" href="javascript:;"><?php _e('See ALL', 'ultimate-auction-pro-software'); ?></a></h5>
				</div>
				</div>
				<?php
} ?>
			</div>
			<?php
$default_view_set = get_field('event_page_tmp_default_view',$page_id);
$default_view = $default_view_set ? $default_view_set : "grid-view";
?>
			<!--Event Grid List view Start-->
			<div class="ua-product-listing  prod <?php echo $default_view; ?>">
				<div class="ua-live-search-list">
				<!--Search box Start-->
				<div class="ua-live-search">
					<?php
$searchbar_set = get_field('event_page_tmp_searchbar',$page_id);
$searchbar = $searchbar_set ? $searchbar_set : "on";
if ($searchbar == "on") { ?>
					<div class="search-input">
						<input name="ajax_search_str" class="ajax_search_str" type="text" autocomplete="off" placeholder="<?php _e('Search by name.', 'ultimate-auction-pro-software'); ?>" value="" style="padding-right: 34px;">
					</div>
					<div class="search-button ajax_search_btn">
						<button type="submit" class="" cursor="pointer" >
							<svg viewBox="0 0 18 18" fill="black100" height="18px" width="18px" class="search-icon">
							<title><?php _e('Search', 'ultimate-auction-pro-software'); ?></title>
							<path d="M11.5 3a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7zm0-1A4.5 4.5 0 1 0 16 6.5 4.49 4.49 0 0 0 11.5 2zM9.442 9.525l-.88-.88L2.06 15.06l.88.88 6.502-6.415z" fill-rule="nonzero"></path>
							</svg>
						</button>
					</div>
					<?php
} ?>
				</div>
				<!--Search box End-->


				<!--Mobile Filter start-->
				<?php
$viewbar_set = get_field('event_page_tmp_viewbar',$page_id);
$viewbar = $viewbar_set ? $viewbar_set : "on";
if ($viewbar == "on") { ?>
				<!--View type Start-->
				<div class="list-and-grid-icon">
					<div class ="view">
					<div class="table_center" style="display:none">
						<div class="drop-down">
							<div id="dropDown" class="drop-down__button">
						 		<span class="drop-down__name"> <?php _e('Sort by', 'ultimate-auction-pro-software'); ?></span>
								 <i class="fas fa-sort-amount-down-alt"></i>
							</div>

							<div class="drop-down__menu-box" style="display: none;">
								<div class="drop-down__menu">
								<div class="ua-filter-sidebar">


				<?php
    $resultbar_set = get_field('event_page_tmp_resultbar',$page_id);
    $resultbar = $resultbar_set ? $resultbar_set : "on";
    if ($resultbar == "on") { ?>
				<div class="ua-search-results">
				<h5> <?php _e('Showing', 'ultimate-auction-pro-software'); ?><span class="Result-Counts"></span> <?php _e('results', 'ultimate-auction-pro-software'); ?></h5>
				</div>
				<?php
    } ?>


				<?php
    $sortbydate_set = get_field('event_page_tmp_sortbydate',$page_id);
    $sortbydate = $sortbydate_set ? $sortbydate_set : "on";
    if ($sortbydate == "on") { ?>
				<div class="ua-Filter-modual-box">
				<h4 class="ua-Filter-modual-heading"><?php _e('sort by ', 'ultimate-auction-pro-software'); ?></h4>
				<ul class="ua-input-group ">
					<li>
						<input class="sortbyenddate" type="radio"  id="sortbyenddate_ASC_m" value="ASC" name="sort-by-enddate" checked>
						<label for="sortbyenddate_ASC_m"> <?php _e('End Date - Ascending ', 'ultimate-auction-pro-software'); ?></label>
					</li>
					<li>
						<input class="sortbyenddate" type="radio" id="sortbyenddate_DESC_m" value="DESC" name="sort-by-enddate">
						<label for="sortbyenddate_DESC_m"> <?php _e('End Date - Descending', 'ultimate-auction-pro-software'); ?></label>
					</li>
				</ul>
				</div>
				<?php
    } ?>


				<?php
    $reset_filter_set = get_field('event_page_tmp_reset_filter',$page_id);
    $reset_filter = $reset_filter_set ? $reset_filter_set : "on";
    if ($reset_filter == "on") { ?>
				<div class="ua-Filter-modual-box APPLIED_filter" id="APPLIED_filter" style="display:none;">
				<h4 class="ua-Filter-modual-heading"> <?php _e('Applied Filters', 'ultimate-auction-pro-software'); ?></h4>
				<div class="APPLIED_filtered"></div>
				<div class="clear-all">
					<h5><a href="javascript:;" class="RemoveFilterall" ><?php _e('CLEAR ALL', 'ultimate-auction-pro-software'); ?></a></h5>
				</div>
				</div>
				<?php
    } ?>


				<?php
    $daterange_set = get_field('event_page_tmp_daterange',$page_id);
    $daterange = $daterange_set ? $daterange_set : "on";
    if ($daterange == "on") { ?>
				<div class="ua-Filter-modual-box">
				<h4 class="ua-Filter-modual-heading"><?php _e('Date', 'ultimate-auction-pro-software'); ?></h4>
				<ul class="ua-input-group">
					<li>
						<input type="text" class="from_date" placeholder="<?php _e('From', 'ultimate-auction-pro-software'); ?>" value="" name="from_date" id="from_dateM">
					</li>
					<li>
						<input type="text" class="to_date" placeholder="<?php _e('to', 'ultimate-auction-pro-software'); ?>" value="" name="to_date" id="to_dateM" >
					</li>
				</ul>
				</div>
				<?php
    } ?>
				<?php
    $location_set = get_field('event_page_tmp_location',$page_id);
   $location = $location_set ? $location_set : "on";
   if ($location == "on") {
        $countries = get_events_countries_list();
        $Countries_filter_Set = get_field('event_page_tmp_location_county',$page_id);
        $Countries_filter = $Countries_filter_Set ? $Countries_filter_Set : "off";
        if ($Countries_filter == "on") { ?>

				<!--//country -->
				<div class="ua-Filter-modual-box">
					<h4 class="ua-Filter-modual-heading"><?php _e('Locations', 'ultimate-auction-pro-software'); ?></h4>

					<ul class="ua-input-group eCountriesList" id="eCountries">
				    <?php
            foreach ($countries as $val): ?>
						<?php if (!empty($val)) { ?>
						<li style="display:none;">
						<input type="checkbox" data-lname="<?php echo $val; ?>" name="eCountries[]" id="eCountriesM_<?php echo str_replace(' ', '', $val); ?>" class="vh eCountries"  value="<?php echo $val; ?>">
						<label class="checkbox" for="eCountriesM_<?php echo str_replace(' ', '', $val); ?>"><?php echo $val; ?></label>

							<?php
                    $States_filter_Set = get_field('event_page_tmp_location_state',$page_id);
                    $States_filter = $States_filter_Set ? $States_filter_Set : "off";
                    if ($States_filter == "on") { ?>

							<div class="expandableCollapsibleDiv">
							<i class="Uat_Expand fas fa-plus"></i>
							<ul class="ua-input-group estateUL eStatesList" id="eStatesMobile">
							 <?php $states = get_events_state_list_by_country($val);
                        foreach ($states as $state): ?>
									<?php if (!empty($state)) { ?>
									<li style="display:none;">
									<input type="checkbox" data-lname="<?php echo $state; ?>" name="eStatesMobile[]" id="eStatesMobileM_<?php echo str_replace(' ', '', $state); ?>" class="vh eStates"  value="<?php echo $state; ?>">
									<label class="checkbox" for="eStatesMobileM_<?php echo str_replace(' ', '', $state); ?>"><?php echo $state; ?></label>

									<?php
                                $Cities_filter_Set = get_field('event_page_tmp_location_city',$page_id);
                                $Cities_filter = $Cities_filter_Set ? $Cities_filter_Set : "on";
                                if ($Cities_filter == "on") { ?>
									<div class="expandableCollapsibleDivCity">
							         <i class="Uat_Expand_city fas fa-plus"></i>
									 <ul class="ua-input-group" id="eCitiesMobile">
										<?php $cities = get_events_city_list_by_state($state);
                                    foreach ($cities as $city): ?>
											<?php if (!empty($city)) { ?>
											<li style="display:none;">
											<input type="checkbox" data-lname="<?php echo $city; ?>" name="eCitiesMobile[]" id="eCitiesMobileM_<?php echo str_replace(' ', '', $city); ?>" class="vh eCities"  value="<?php echo $city; ?>">
											<label class="checkbox" for="eCitiesMobileM_<?php echo str_replace(' ', '', $city); ?>"><?php echo $city; ?></label>
										</li>

											<?php
                                        } ?>
										<?php
                                    endforeach; ?>
										</ul>
										</div>
										<?php
                                } ?>


									</li>

									<?php
                            } ?>
								<?php
                        endforeach; ?>
							</ul>
							</div>

							<?php
                    } ?>

						</li>

						<?php
                } ?>
					<?php
            endforeach; ?>
					</ul>

					<div class="clear-all see_all_eCountries_div">
						<h5><a  class="see_all_eCountries_btn" id="see_all_eCountries" href="javascript:;"><?php _e('See ALL', 'ultimate-auction-pro-software'); ?></a></h5>
					</div>
				</div>

				<?php
        } ?>

				<?php
    }
     ?>

				<?php
    $category_set = get_field('event_page_tmp_category',$page_id);
    if ($category_set == "on") { ?>
				<div class="ua-Filter-modual-box">
				<h4 class="ua-Filter-modual-heading"><?php _e('CATEGORY', 'ultimate-auction-pro-software'); ?></h4>
				<ul class="ua-input-group eCategoryList" id="ecategory">
					<?php
        $terms = get_terms('uat-event-cat', array('hide_empty' => false, 'orderby' => 'title', 'order' => 'ASC'));
        foreach ($terms as $term) { ?>
					<li style="display:none;">
						<input type="checkbox" data-lname="<?php echo $term->name; ?>" name="chk_cat_ids[]" id="catM_<?php echo $term->term_id; ?>" class="vh p_cats"  value="<?php echo $term->term_id; ?>">
						<label class="checkbox" for="catM_<?php echo $term->term_id; ?>"><?php echo $term->name; ?></label>
					</li>
					<?php
        } ?>
				</ul>
				<div class="clear-all see_all_cats_div">
					<h5><a class="see_all_cats_btn"  id="see_all_cats" href="javascript:;"><?php _e('See ALL', 'ultimate-auction-pro-software'); ?></a></h5>
				</div>
				</div>
				<?php
    } ?>
			</div>
								</div>
							</div>
       </div>
</div>
						<i class= "fa fa-list " data-view ="list-view"></i>
						<i class="selected fa fa-th" data-view ="grid-view"></i>
					</div>
				</div>
				<!--View type End-->
				<?php
} ?>
				</div>
				<!--Event list start-->
				<div class="product-list-columns EventSearch-results" id="EventSearch-results">
				</div>
				<div class="show-more-link full-section">
				<div class="container">
					<div class="blog_loader" id="loader_ajax" style="display:none; height:80px; width:80px; ">
						<img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
					</div>
					<?php
$pagination_type = get_field('event_page_tmp_pagination_type',$page_id);
if ($pagination_type == "load-more") { ?>
					<a href="Javascript:void(0);" style="display:none;" class="show-more ua-button-black" onclick="load_events_serach_result('');"><?php _e('Load more', 'ultimate-auction-pro-software'); ?></a>
					<?php
} ?>
				</div>
				</div>
				<input type="hidden" name="max_page" value="" id="max_page"/>
				<input type="hidden" name="ajax_loading_stat" value="" id="ajax_loading_stat"/>
				<?php $perpage = get_field('event_page_tmp_perpage',$page_id);
			$tmp_perpage = $perpage ? $perpage : 12;  ?>	
			<?php $p_type = get_field('event_page_tmp_pagination_type',$page_id);
			$tmp_p_type = $p_type ? $p_type : "load-more";  ?>
				<input type="hidden" name="event_tmp_perpage" value="<?php echo $tmp_perpage;?>" id="event_tmp_perpage"/>
				<input type="hidden" name="event_tmp_p_type" value="<?php echo $tmp_p_type;?>" id="event_tmp_p_type"/>
				<!--Event list END -->
			</div>
			<!--Event Grid List view END-->
		</div>
   </div>
</div>
<script>
				var wpml_lang_code = "";
				<?php 	if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) { ?>
					wpml_lang_code = '<?php echo ICL_LANGUAGE_CODE; ?>';
				<?php } ?>
			</script>
			<?php

$daterange_set = get_field('event_page_tmp_daterange',$page_id);
$daterange = $daterange_set ? $daterange_set : "on";
if ($daterange == "on") {
    wp_enqueue_script('jquery-ui-datepicker');
    wp_register_style('jquery-ui', UAT_THEME_PRO_CSS_URI . 'jquery-ui.css', array(), UAT_THEME_PRO_VERSION);
    wp_enqueue_style('jquery-ui');
?>
				<script type="text/javascript">
				jQuery(document).ready(function () {
					jQuery( function() {
						var dateFormat = "yy-mm-dd",
						from = jQuery( ".from_date" ).datepicker({
							defaultDate: "+1w",
							numberOfMonths: 2,
							dateFormat : "yy-mm-dd",
						})
						.on( "change", function() {
							to.datepicker( "option", "minDate", getDate( this ) );
						}),

						to = jQuery( ".to_date" ).datepicker({
							defaultDate: "+1w",
							numberOfMonths: 2,
							dateFormat : "yy-mm-dd",
						})

						.on( "change", function() {
							from.datepicker( "option", "maxDate", getDate( this ) );
							if(jQuery(".from_date").val()==""){
								jQuery( ".from_date" ).datepicker({dateFormat:"yy-mm-dd"}).datepicker("setDate",new Date());
							}

							if(jQuery(".from_date").val()!="" && jQuery(".to_date").val()!="" ){
								load_events_serach_result(1);
							}
						});

						function getDate( element ) {
						var date;
							try {
							date = jQuery.datepicker.parseDate( dateFormat, element.value );
							} catch( error ) {
							date = null;
							}
						return date;
						}
					});
				});
				</script>
				<?php
} ?>
<input type="hidden" name="event_page_id" id="event_page_id" value="<?php echo $page_id;?>" />
<?php get_footer();
