<div class="newUcFilter_main">
   <div class="filterCard clearfix collapseAllFilter">
      <div class="collapseTitle">
         <div class="filter-count">0</div>
         <span><?php echo __("Collapse all filters", 'ultimate-auction-pro-software'); ?> </span>
      </div>
      <div class="clear-all"><a href="" onClick="window.location.reload();"><?php echo __("Clear all", 'ultimate-auction-pro-software'); ?></a></div>
   </div>
</div>



<?php
if( function_exists('acf_add_local_field_group') ){
generate_sidebar_filters();
}

function generate_sidebar_filters()
{
   // get a list of unique values for each field
   $page_id = get_the_ID();

   $all_filters = get_car_list_filers($page_id);  
   $models = "";
   $final_sidebar = "";  
   if (!empty($all_filters)) {
      foreach ($all_filters as $one_filter) {
         $show = $one_filter['show'];
         $name = $one_filter['name'];
         $title = $one_filter['title'];
         $type = $one_filter['type'];
         $input_type = $one_filter['input_type'];
         $input_filter_type = $one_filter['input_filter_type'];
         if ( $show == 'yes' ){
            $values = [];
            if ($type == 'term' && $name=="car_models" ) {
               $values = get_term_filters($one_filter);
			}else if($type == 'term' && $name=="car_makes"){
				 $values = get_make_term_filters($one_filter); 
			}else{
               $values = get_unique_field_values_with_count($one_filter);
            }
            if ($input_filter_type == 'range_slider' ) {
               $values = get_unique_meta_number_field_values($one_filter);
            //   echo $name;
            //    // print_r($one_filter);
            //    print_r($values);
               $final_sidebar .= filter_range_slider($one_filter,$values);
            }else{
               $final_sidebar .= filter_checkbox($title,$name, $type, $values);
            }
         }
      }
   }
   echo "<form id='uatFilterForm' onsubmit='return false;'>";
   echo $final_sidebar;
   echo "</form>";
}
/**
* Returns an html for checkbox with multilavel.
*
* @param  title  Title for filter
* @param  type  meta,term
* @param  data the location of the image, relative to the url argument
* @return the html for checkbox filter
*/
function filter_range_slider($one_filter = [], $values = [])
{
   $html = "";
   if(empty($one_filter) && count($one_filter) <= 0){
      return $html;
   }
	if(!isset($values['values']) || empty($values['values'])){
		return $html;
	}
	$range_slider_text = get_woocommerce_currency_symbol();

   $values['values'] = array_unique($values['values']);
   $values['values'] = array_values($values['values']);
   $title = $one_filter['title'];
   $name = $one_filter['name'];
   $type = $one_filter['type'];
   $help_text = $one_filter['slider_help_text']??$range_slider_text;
   $min = $values['min']??1;
   $max = $values['max']??1000;
   $values = [$min,$max];
   $values = json_encode($values);
   $default_open = "open";
   $html_main = "<div class='newUcFilter_main'>
                  <div class='filterCard clearfix false'>";
   $html_accordian    = "<div class='borderBottom filter-accordian'>"; 
   $html_accordian_title    = "<h3 class='accordian-title'>$title<span class='u-arrow'> &nbsp; </span>&nbsp;</h3>";
   $html_accordian_content  = "<div class='content ".$default_open."'>";

   $html_accordian_content  .= " <div class='range-slider'>
                                    <div class='price-range-slider'>
                                       <p class='range-value'>
                                          <input type='text' class='filterInput range-slider-input filterChanged' id='amount' data-step='1' data-id='".$name."' data-values='".$values."'  data-min='".$min."' data-max='".$max."' data-help-text='".$help_text."'  readonly>
                                       </p>
                                       <div id='".$name."' class='range-bar'></div>
                                    </div>
                                 </div>";
   $html_accordian_content  .= "  </div>"; 
   $html_accordian_end= "</div>"; 
   $html_main_end = "</div></div>";  

  
   $html .= $html_main . $html_accordian . $html_accordian_title . $html_accordian_content . $html_accordian_end . $html_main_end;

   return $html;
}
/**
* Returns an html for checkbox with multilavel.
*
* @param  title  Title for filter
* @param  type  meta,term
* @param  data the location of the image, relative to the url argument
* @return the html for checkbox filter
*/
function filter_checkbox($title = "Filter",$name = "",$type = "",$data = [])
{
   $html = "";
   if(empty($data) && count($data) <= 0){
      return $html;
   }
      $default_open = "open";
      $html_main = "<div class='newUcFilter_main'>
                     <div class='filterCard clearfix false'>";
      $html_accordian    = "<div class='borderBottom filter-accordian'>"; 
      $html_accordian_title    = "<h3 class='accordian-title'>$title<span class='u-arrow'> &nbsp; </span>&nbsp;</h3>";
      $html_accordian_content  = "<div class='content ".$default_open."'>
                                    <div class='outBox fuelby'>
                                       ";
            foreach($data as $o_data){
               
               $data_name = $o_data['name']??"";
               $data_title = $o_data['title']??"";
               $data_count = $o_data['count']??"";
               $data_id = $o_data['id']??"";
               $o_data_children = [];
               if(empty($data_name)){
                  continue;
               }
               $multiple_arrow = "";
               if($type == "term"){
                  $o_data_children = $o_data['children']??[];
                  if(count($o_data_children) > 0)
                  {
                    // $multiple_arrow = "<span class='u-arrow-down'></span>";
                     //$data_count = $data_count;
                  }
               }else{
                  $data_id = $data_name;
               }
            $html_accordian_content  .= " <ul class='checkBoxWrap'> <li class='checkBoxList' data-filter-name='$name' data-id='$data_id'>
                                             <div title='$data_name' class='gs_control gs_checkbox searchcheck innerlistmain'>
                                                <div class='container-checkbox'>
                                                   <input name='".$name."[]' class='filterInput filterCheckbox filterChanged'  data-filter-name='$name' data-id='$data_id' data-ftype='$type' data-lable='$data_name' id='$data_name' type='checkbox' value='$data_id'>
                                                   <label for='$data_name' class='checkLabel'>
                                                      <span>$data_name</span>
                                                   </label>
                                                </div>
                                                <span class='count'>$data_count</span>
                                                $multiple_arrow
                                             </div>";
                                                
                                                  /* if(count($o_data_children) > 0)
                                                   {
                                                      $html_accordian_content  .= " <ul class='checkBoxWrap innerlistdata'>";
                                                      foreach($o_data_children as $c_data){
                                                
                                                         $data_c_name = $c_data['name'];
                                                         $data_c_count = $c_data['count'];
                                                         $data_c_id = $c_data['id'];
                                                         
                                                         $html_accordian_content  .= " <li class='checkBoxList children'  data-filter-name='$name' data-id='$data_c_id'>
                                                                                             <div title='$data_c_name' class='gs_control gs_checkbox searchcheck '>
                                                                                                <div class='container-checkbox'>
                                                                                                   <input name='".$name."[]' class='filterInput filterCheckbox filterChanged'  data-filter-name='$name' data-id='$data_c_id' data-ftype='$type'  data-lable='$data_c_name' id='$data_c_name' type='checkbox' value='$data_c_id'>
                                                                                                   <label for='$data_c_name' class='checkLabel'><span>$data_c_name</span></label>
                                                                                                </div>
                                                                                                <span class='count'>$data_c_count</span>
                                                                                             </div>
                                                                                       </li>";
                                                      }
                                                      $html_accordian_content  .= " </ul> ";
                                                   }*/

                                                                                              
               $html_accordian_content  .= "  
                                          </li></ul>";
            }
         $html_accordian_content  .= "  
                                    </div>
                                 </div>"; 
      $html_accordian_end= "</div>"; 
      $html_main_end = "</div></div>";  

     
      $html .= $html_main . $html_accordian . $html_accordian_title . $html_accordian_content . $html_accordian_end . $html_main_end;

   return $html;
}
