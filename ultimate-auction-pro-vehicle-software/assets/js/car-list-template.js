var filtersCount = 0;
var setpage = 1;
var perpage = car_list_js_vars.perpage;
var pagination_type = car_list_js_vars.pagination_type;
var filters_default = car_list_js_vars.filters;
var total_text_show = car_list_js_vars.total_text_show;
var total_text = car_list_js_vars.total_text;
var show_expired = car_list_js_vars.show_expired;
var current_filters_show = car_list_js_vars.current_filters_show;
var close_svg_icon = car_list_js_vars.close_svg_icon;
var collaps_text = car_list_js_vars.collaps_text;
var expand_text = car_list_js_vars.expand_text;
var filtersData = {};
var is_ajax_running = false;
var have_pages = false;
const container = document.querySelector(".product-list-row");

jQuery(document).ready(function($){
    jQuery('.accordian-title').on('click', function () {
        jQuery(this).closest('.filter-accordian').find('.content').toggleClass('open');
        jQuery(this).closest('.accordian-title').find('.u-arrow').toggleClass('open');
      });
      
      jQuery('.innerlistmain').on('click', function () {
        jQuery(this).closest('.checkBoxList').find('.innerlistdata').toggleClass('open');
        jQuery(this).closest('.innerlistmain').find('.u-arrow-down').toggleClass('open');
      });
      
      jQuery('.collapseAllFilter').on('click', function () {
        var contents = jQuery('.filter-accordian .content');
        if (contents.hasClass('open')) {
          contents.removeClass('open');
          jQuery('.accordian-title .u-arrow').removeClass('open');
          jQuery('.collapseTitle span').text(expand_text);
        } else {
          contents.addClass('open');
          jQuery('.accordian-title .u-arrow').addClass('open');
          jQuery('.collapseTitle span').text(collaps_text);
        }
      });
      

    //-----JS for Price Range slider-----
    initializeRangeSlider();
    function initializeRangeSlider(){
        var rangeSliders = jQuery( ".range-slider-input" );
        $.each(rangeSliders, function(index, rangeSlider){
            var sid = $(rangeSlider).attr('data-id');
            var min = $(rangeSlider).attr('data-min');
            var max = $(rangeSlider).attr('data-max');
            var values = $(rangeSlider).attr('data-values');
            var helpText = $(rangeSlider).attr('data-help-text');
            var hasChanged = $(rangeSlider).attr('data-changed');
            if(hasChanged){
                return true;
            }
            values = JSON.parse(values)
            var step = $(rangeSlider).attr('data-step');
        let sl = jQuery( "#"+sid ).slider({
                range: true,
                min:  Number(min),
                max: Number(max),
                values: values,
                step: Number(step), // add step of 1
                stop: function( event, ui ) {
                    jQuery( rangeSlider ).attr('data-changed', true);
                    jQuery( rangeSlider ).val( helpText + ui.values[ 0 ] + " - " + helpText + ui.values[ 1 ] );
                    if(!is_ajax_running){
                     
                        rangeChanged(sid,ui.values[ 0 ],ui.values[ 1 ]);
                    }
                }
            });
            jQuery( rangeSlider ).val( helpText + jQuery( "#"+sid ).slider( "values", 0 ) + " - " + helpText + jQuery( "#"+sid ).slider( "values", 1 ) );
        });
    }

    //-----JS for Price Range slider end-----
    
    getFilteredData();
    jQuery(document).on('change', '.filterChanged', function(e) {
        e.preventDefault();
      
        filterChanged();
        getFilteredData();
    });             

    $( document ).ajaxStart(function() {
        jQuery("#loader_ajax").show();
        $('.filterInput').prop("disabled", true);
        is_ajax_running = true;
    });
    $( document ).ajaxStop(function() {
        jQuery("#loader_ajax").hide();
        
        is_ajax_running = false;
        showFilters();
        $('.filterInput').prop("disabled", false);

    });
    jQuery(document).on('click', '.show-more', function(e) {
        getFilteredData(true);
    });
    jQuery(document).on('click', '.remove-filter', function(e) {
        let keyToRemove = $(this).attr("data-key");
        let valueToRemove = $(this).attr("data-value");
        if (keyToRemove in filtersData) {
            let index = filtersData[keyToRemove].indexOf(valueToRemove);
            if (index !== -1) {
              filtersData[keyToRemove].splice(index, 1);
              if (filtersData[keyToRemove].length === 0) {
                delete filtersData[keyToRemove];
              }
            }
        }

        let checkbox =  $('input[value="'+valueToRemove+'"]');
        if(checkbox.length > 0){
            checkbox.prop("checked", false);
        }else{
            valueToRemove = valueToRemove.replace(/\s/g, "");
            let number = $('input[data-id="'+keyToRemove+'"]');
            if(number.length > 0){
                number.removeAttr('data-changed');
                 initializeRangeSlider();
            }
        }
     
        getFilteredData();

    });
    jQuery(document).on('scroll', function() {
		if (jQuery('#tabs-content').length < 1) {
			return false;
		} else {
			if (pagination_type == "infinite-scroll") {
				if (jQuery(this).scrollTop() >= jQuery('.show-more-link').position().top - 500 && have_pages && !is_ajax_running) {
					getFilteredData(true);
				}
			}
		}
	});

    function rangeChanged(name,min,max) { 
        if (is_ajax_running) {
            return false;
         }
        var filterValues = $(`input[name="${name}"]`).attr('data-values');
        var filtersHtml = "";
        if(filterValues){
            filtersHtml = filtersHtml + getOneCurrentFilterHtml(filterValues);
            jQuery(".carsCurFilterDiv .applied-filters").append(filtersHtml);
        }
        filtersData[name] = [min,max];
        getFilteredData()
    }
   function filterChanged() { 
        
        if (is_ajax_running) {
            return false;
        }
       
        // filtersData = {};
        var formData = $( "#uatFilterForm" ).serializeArray();
        console.log(formData.length);
        if(formData.length){
           
            var fKey = "";
            var values = [];
            $.each(formData, function(index, field){
                fKey = field.name.replace('[]', ''); // remove the [] from the name
               
                var cInput = $("input[name='"+field.name+"'")
                var type = cInput.attr('type');
                if(type == 'checkbox')
                {   
                    if(cInput.is(':checked')){
                        
                        values.push(field.value)
                    }
                    
                }
            });
            filtersData[fKey] = values;
            if (fKey in filtersData) {
                if (filtersData[fKey].length === 0) {
                    delete filtersData[fKey];
                }
            }
        }else{
            filtersData = {};
        }
    } 
    $('.sort-select').change(function() {
        getFilteredData()
      });
    function getFilteredData(pagination=false){
        if (is_ajax_running) {
           return false;
        }
        let selectedOption = $('.sort-select option:selected');
        let sorting_key = selectedOption.attr('data-sort-key');
        let sorting_order = selectedOption.attr('data-sort-order');
        if(pagination){
            setpage++;
        }
        console.log(filtersData)
        var  data= {
            action: 'get_car_list_results_data',
            perpage: perpage,
            setpage: setpage,
            page_id: car_list_js_vars.page_id,
            all_filters: car_list_js_vars.all_filters,
            filters: filtersData,
            show_expired: show_expired,
            sorting_key: sorting_key,
            sorting_order: sorting_order
         };
         
         // Add the checked checkboxes to the filter object
        data.filters = filtersData;
        if (setpage == 1) {
			jQuery(".show-more").hide();
		}
        jQuery.ajax({
            url: ajaxurl, // replace with your own AJAX endpoint
            type: 'POST',
            data: data,
            beforeSend: function() {
            },
            success: function(response) {
                if(response.status){

                    if (setpage == 1) {
                        jQuery("#tabs-content").html(response.data);
                        jQuery("#tabs-content").show();
                        /*jQuery('body,html').animate({
                            scrollTop: jQuery('#tabs-content').offset().top - 240
                        });*/
                    } else {
                        jQuery("#tabs-content").append(response.data);
                    }
                    if(parseInt(response.count) == parseInt(perpage)){
                        jQuery('#max_page').val('show');
                        jQuery(".show-more").show();
                        have_pages = true;
                    }else{
                        jQuery('#max_page').val('hide');
                        jQuery(".show-more").hide();
                        have_pages = false;
                    }
                    if (timer_type != 'timer_jquery') {
                        intclock();
                    } else {
                        jquery_clock_rebind();
                    }
                }else{
                    if(response.data.length){
                        jQuery("#tabs-content").html(response.data);
                    }
                    jQuery(".show-more").hide();
                }
                if(total_text_show && response.total_products > 0){
                    jQuery(".carsTotalText").html(`${response.total_products} ${total_text}`);
                    jQuery(".carsTotalDiv").show();
                }else{
                    jQuery(".carsTotalDiv").hide();
                }
                
            },
            error: function(xhr, status, error) {
            }
        });
    }
    function getOneCurrentFilterHtml(filter = []) { 
        var cf_html = "";
        var key = filter['key'];
        if(key != ""){

            var label = filter['label'];
            var value = filter['value'];
            

            cf_html = `<div class="chipsMain undefined null filtered-blocks" data-filter="${key}">
            <div class="chipsButton active ">
            <span class="buttonLabel">${label}</span>
            <span class="close-icon remove-filter" data-key="${key}" data-value="${value}">${close_svg_icon}</span>
                                    <span class="chipDownSecArrow" style="display: none; visibility: hidden;"></span>
                                </div>
                                </div>`;
                            }
       return cf_html;
    }
    function showFilters(){
        var total = 0;
        var filtersHtml = "";
        total = total + Object.keys(filtersData).length;
		for (const property in filtersData) {
            filtersData[property].forEach(element => {
                if(typeof  element == 'string'){
                    total = total + 1; 
                }
            });
        }
        if(total == 0){
            $(`.filtered-blocks`).remove();
        }else{
            var labels = [];
            $('.filterInput').each(function() {
                var label = [];
                if($(this).attr('type') == 'checkbox') {
                    if($(this).prop('checked')){
                        var label_ = [];
                        var value =  $(this).attr('id');
                        if($(this).attr('data-ftype') == 'term'){
                            value =  $(this).attr('data-id');
                        }
                        label_['key'] = $(this).attr('data-filter-name');
                        label_['label'] = $(this).attr('id');
                        label_['value'] = value;
                        label.push(label_)
                    }
                }else if($(this).attr('type') == 'text') {
                    if($(this).attr('data-changed')){
                        var htext = $(this).attr('data-help-text');
                        var vals = filtersData[$(this).attr('data-id')];
                        if(vals){

                            var value =  $(this).attr('data-values');
                            if($(this).attr('data-ftype') == 'term'){
                                value =  $(this).attr('data-id');
                            }
                            var label_ = [];
                            label_['key'] = $(this).attr('data-id');
                            label_['label'] =`${htext}${vals[0]} - ${htext}${vals[1]}`;
                            label_['value'] = value;
                            label.push(label_)
                        }
                    }
                }
                if(label.length > 0){
                    labels.push(label);
                }
            });
            if(labels.length > 0){
                labels.forEach(element => {
                    element = element[0];
                    filtersHtml = filtersHtml + getOneCurrentFilterHtml(element);
                });
            }
        }
        if(current_filters_show){
            jQuery(".carsCurFilterDiv .applied-filters").html(filtersHtml);
            jQuery(".carsCurFilterDiv").show();
        }else{
            jQuery(".carsCurFilterDiv").hide();
        }
		if(total != 0){ 
			total = total - 1;
		}
		
			const checkboxes = document.querySelectorAll('.filterInput');
			let selectedCheckboxNumber = -1;
			let selectedCheckboxClass = '';

			checkboxes.forEach((checkbox, index) => {
				if (checkbox.checked) {
					selectedCheckboxNumber = index + 1;
					selectedCheckboxClass = checkbox.className;
				}
			});

			if (selectedCheckboxNumber !== -1) {
				console.log("Selected checkbox number:", selectedCheckboxNumber);
				console.log("Selected checkbox class:", selectedCheckboxClass);
			} else {
				console.log("No checkbox selected");
			}
		
		if(selectedCheckboxNumber== -1){
			selectedCheckboxNumber = 0;
		}
		
		
		jQuery(".filter-count").text(selectedCheckboxNumber);
    }

});


