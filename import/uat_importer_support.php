<?php

/**
 * Ultimate Auction Pro Software  Importer
 *
 * @package Ultimate Auction Pro Software
 * @author Nitesh Singh 
 * @since 1.1.1 
 *
 */

/* import auction product */
add_filter('woocommerce_csv_product_import_mapping_options', 'uat_add_column_to_importer');

add_filter('woocommerce_csv_product_import_mapping_default_columns', 'uat_add_column_to_mapping_screen');

add_filter('woocommerce_product_import_pre_insert_product_object', 'uat_process_import', 10, 2);

/**
 * Register the 'Custom Column' column in the importer.
 *
 * @param array $options
 * @return array $options
 */

function uat_add_column_to_importer($options)
{

	/* check for auction product only */

	// column slug in list  => column name in list
	$options['woo_ua_auction_selling_type'] = 'Auction - Selling Type';
	//$options['woo_ua_product_condition'] = 'Auction - Product Condition';
	$options['woo_ua_auction_type'] = 'Auction - Auction Type';
	$options['uwa_auction_proxy'] = 'Auction - Enable Proxy Bid';
	$options['uwa_auction_silent'] = 'Auction - Enable Silent Bid';

	$options['woo_ua_opening_price'] = 'Auction - Opening Price';
	$options['uwa_auction_has_reserve'] = 'Auction - Enable Reserve Price';
	$options['woo_ua_lowest_price'] = 'Auction - Lowest Price to Accept';
	$options['woo_ua_bid_increment'] = 'Auction - Bid Increment';

	/* Variable Bid Increment */
	$options['uwa_auction_variable_bid_increment'] = 'Auction - Enable Variable Increment';
	$options['uwa_var_inc_price_val'] = 'Auction - Variable Increment';
	$options['uwa_auction_variable_bid_increment_type'] = 'Auction - Enable Variable Increment Type';

	$options['uat_import_buynow_price'] = 'Auction - Buy Now Price';
	$options['woo_ua_auction_start_date'] = 'Auction - Start Date';
	$options['woo_ua_auction_end_date'] = 'Auction - End Date';

	/* Extra Field Add */
	$options['uat_auction_subtitle'] = 'Auction - Product Subtitle';
	$options['uwa_event_auction'] = 'Auction - Lot of an Auction Event';
	$options['uat_auction_lot_number'] = 'Auction - Lot Number';
	$options['uwa_number_of_next_bids'] = 'Auction - Number Next Bid';
	$options['uat_estimate_price_from'] = 'Auction - Estimated Opening Price';
	$options['uat_estimate_price_to'] = 'Auction - Estimated Closing Price';
	$options['uat_locationP_address'] = 'Auction - Product Location Details';

	// $options['woo_ua_auction_has_started'] = 'Auction - Started'; 		    		

	/*Buyers Premium Field */

	/*Enable Buyer's Premium */
	$options['uat_buyers_premium_type_sp_main'] = 'Auction - Buyers Premium Options';
	$options['sp_buyers_premium'] = 'Auction - Enable Buyers Premium';
	/*Do you want to automatically debit the Buyer's premium? */
	$options['sp_buyers_premium_auto_debit'] = 'Auction - Enable Auto Debit Buyers Premium';
	/*What will you charge */
	$options['sp_buyers_premium_type'] = 'Auction - Buyers Premium Type';
	/*Mention the Charge */
	$options['sp_buyers_premium_fee_amt'] = 'Auction - Buyers Premium Charge';
	/*Minimum Premium Amount */
	$options['sp_buyers_premium_fee_amt_min'] = 'Auction - Buyers Premium Minimum Premium Amount';
	/*Maximum  Premium Amount */
	$options['sp_buyers_premium_fee_amt_max'] = 'Auction - Buyers Premium Maximum Premium Amount';

	/*Payment Hold & Debit Field */
	/*Hold a specific amount (from first bid) only one time or hold bid amount each time bid is placed. ---- yes*/
	$options['sp_automatically_debit'] = 'Auction - Enable Hold a Specific Amount';
	$options['sp_type_automatically_debit_hold_type'] = 'Auction - Hold a Specific Amount Type';
	/* Enter specific amount */
	$options['charge_hold_fix_amount'] = 'Auction - Specific Amount Charge';

	/*Hold a specific amount (from first bid) only one time or hold bid amount each time bid is placed. --- no*/
	/* Do you want to automatically debit the winning amount on user's credit card */
	$options['sp_type_automatically_debit'] = 'Auction - Enable Auto Debit Winning Amount';
	/*Partial Amount Type*/
	$options['sp_partial_amount_type'] = 'Auction - Partial Amount Type';
	/*Enter Partial Amount or Percentage*/
	$options['sp_partially_amount'] = 'Auction - Partial Amount';


	return $options;
}


/**
 * Add automatic mapping support for 'Custom Column'. 
 * This will automatically select the correct mapping for columns named 'Custom Column' or 'custom
  	column'.
 *
 * @param array $columns
 * @return array $columns
 */

function uat_add_column_to_mapping_screen($columns)
{
	// potential column name in file  => column slug in list	    
	$columns['Auction - Selling Type'] = 'woo_ua_auction_selling_type';
	//$columns['Auction - Product Condition'] = 'woo_ua_product_condition';
	$columns['Auction - Auction Type'] = 'woo_ua_auction_type';
	$columns['Auction - Enable Proxy Bid'] = 'uwa_auction_proxy';
	$columns['Auction - Enable Silent Bid'] = 'uwa_auction_silent';

	$columns['Auction - Opening Price'] = 'woo_ua_opening_price';
	$columns['Auction - Enable Reserve Price'] = 'uwa_auction_has_reserve';
	$columns['Auction - Lowest Price to Accept'] = 'woo_ua_lowest_price';
	$columns['Auction - Bid Increment'] = 'woo_ua_bid_increment';

	/* Variable Bid Increment */
	$columns['Auction - Enable Variable Increment'] = 'uwa_auction_variable_bid_increment';
	$columns['Auction - Enable Variable Increment Type'] = 'uwa_auction_variable_bid_increment_type';
	$columns['Auction - Variable Increment'] = 'uwa_var_inc_price_val';

	$columns['Auction - Buy Now Price'] = 'uat_import_buynow_price';
	$columns['Auction - Start Date'] = 'woo_ua_auction_start_date';
	$columns['Auction - End Date'] = 'woo_ua_auction_end_date';

	/*Extra Field */
	$columns['Auction - Product Subtitle'] = 'uat_auction_subtitle';
	$columns['Auction - Lot of an Auction Event'] = 'uwa_event_auction';
	$columns['Auction - Lot Number'] = 'uat_auction_lot_number';
	$columns['Auction - Number Next Bid'] = 'uwa_number_of_next_bids';
	$columns['Auction - Estimated Opening Price'] = 'uat_estimate_price_from';
	$columns['Auction - Estimated Closing Price'] = 'uat_estimate_price_to';
	$columns['Auction - Product Location Details'] = 'uat_locationP_address';

	/*Buyers Premium Field */

	/*Enable Buyer's Premium */
	$columns['Auction - Buyers Premium'] = 'sp_buyers_premium';
	/*Do you want to automatically debit the Buyer's premium? */
	$columns['Auction - Enable Auto Debit Buyers Premium'] = 'sp_buyers_premium_auto_debit';
	/*What will you charge */
	$columns['Auction - Buyers Premium Type'] = 'sp_buyers_premium_type';
	/*Mention the Charge */
	$columns['Auction - Buyers Premium Charge'] = 'sp_buyers_premium_fee_amt';
	/*Minimum Premium Amount */
	$columns['Auction - Buyers Premium Minimum Premium Amount'] = 'sp_buyers_premium_fee_amt_min';
	/*Maximum  Premium Amount */
	$columns['Auction - Buyers Premium Maximum Premium Amount'] = 'sp_buyers_premium_fee_amt_max';

	/*Payment Hold & Debit Field */

	/*Hold a specific amount (from first bid) only one time or hold bid amount each time bid is placed. */
	$columns['Auction - Enable Hold a Specific Amount'] = 'sp_automatically_debit';
	$columns['Auction - Hold a Specific Amount Type'] = 'sp_type_automatically_debit_hold_type';
	/* Enter specific amount */
	$columns['Auction - Specific Amount Charge'] = 'charge_hold_fix_amount';

	/*Hold a specific amount (from first bid) only one time or hold bid amount each time bid is placed. --- no*/
	/* Do you want to automatically debit the winning amount on user's credit card */
	$columns['Auction - Enable Auto Debit Winning Amount'] = 'sp_type_automatically_debit';

	/*Partial Amount Type*/
	$columns['Auction - Partial Amount Type'] = 'sp_partial_amount_type';
	/*Enter Partial Amount or Percentage*/
	$columns['Auction - Partial Amount'] = 'sp_partially_amount';


	//$columns['Auction - Started '] = 'woo_ua_auction_has_started'; 

	return $columns;
}

/**
 * Process the data read from the CSV file.
 * This just saves the value in meta data, but you can do anything you want here with the data.
 *
 * @param WC_Product $object - Product being imported or updated.
 * @param array $data - CSV data read for the product.
 * @return WC_Product $object
 */

function uat_process_import($object, $data)
{

	if ($data['type'] == "auction") {
		$arr_selling_type = array('both', 'auction', 'buyitnow');
		$arr_proxy = array("yes", "0");
		$arr_slient = array("yes", "0");
		$arr_event_auction = array("yes", "0");
		$arr_buyers_premium = array("yes", "no");
		$arr_buyers_premium_main_type = array('global', 'custom');
		$arr_buyers_premium_type = array('flat', 'percentage');
		$arr_auto_debit = array("yes", "no");
		$arr_automatically_debit = array("yes", "no");
		$arr_auction_has_reserve = array("yes", "no");
		//$arr_auction_type = array("normal");
		$arr_bid_increment_type = array('global', 'custom');
		$arr_automatically_debit_hold_type = array('stripe_charge_hold_fix_amount', 'stripe_charge_hold_bid_amount');
		$arr_auto_debit_winning_amount = array('stripe_charge_type_full', 'stripe_charge_type_partially', 'stripe_charge_type_no');
		$arr_partial_amount_type = array('flat_rate', 'percentage');

		/*  ------------------  auction type  -------------------- */
		$object->update_meta_data('woo_ua_auction_type', "normal");


		/*  ------------------     Product Location Details     --------------------  */
		if (isset($data['uat_locationP_address'])) {

			$address = strtolower(trim($data['uat_locationP_address']));
			$uat_google_maps_api_key = get_option('options_uat_google_maps_api_key', "");
			if (!empty($uat_google_maps_api_key)) {
				$url = "https://maps.google.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $uat_google_maps_api_key . "";

				$response = wp_remote_get($url);

				if (!empty($response)) {

					$body = wp_remote_retrieve_body($response);
					$output = json_decode($body);
					$GeoLocator = new \stdClass();
					$centre_lat = $output->results[0]->geometry->location->lat;
					$centre_long = $output->results[0]->geometry->location->lng;
					$formatted_address = $output->results[0]->formatted_address;
					$place_id = $output->results[0]->place_id;

					$data['uat_locationP_address'] = array(
						'address' => $formatted_address,
						'lat' => $centre_lat,
						'lng' => $centre_long,
						'place_id' => $place_id,
						'zoom' => 14
					);


					$lot_locationP_address = $data['uat_locationP_address'];


					foreach ($output->results[0]->address_components as $comp) {

						if (in_array('locality', $comp->types)) {
							$GeoLocator->city = trim($comp->long_name);
							$city = $GeoLocator->city;
						} else if (in_array('administrative_area_level_1', $comp->types)) {
							$GeoLocator->state = strtoupper(trim(preg_replace('/\d/', '', $comp->long_name)));
							$state = $GeoLocator->state;
							$GeoLocator->state_short = strtoupper(trim(preg_replace('/\d/', '', $comp->short_name)));
							$state_short = $GeoLocator->state_short;
						} else if (in_array('country', $comp->types)) {
							$GeoLocator->country = strtoupper(trim(preg_replace('/\d/', '', $comp->long_name)));
							$country = $GeoLocator->country;
							$GeoLocator->country_short = strtoupper(trim(preg_replace('/\d/', '', $comp->short_name)));
							$country_short = $GeoLocator->country_short;
						} else if (in_array('postal_code', $comp->types)) {
							$GeoLocator->postal_code = trim($comp->long_name);
							$postal_code = $GeoLocator->postal_code;
						} else if (in_array('sublocality_level_1', $comp->types)) {
							$GeoLocator->loc_name = trim($comp->long_name);
							$loc_name = $GeoLocator->loc_name;
						}
					}


					if ($lot_locationP_address != "") {

						if (!empty($lot_locationP_address)) {
							$object->update_meta_data('uat_locationP_address', $lot_locationP_address);
						}

						if (!empty($formatted_address)) {
							$object->update_meta_data('uat_Product_loc_address', $formatted_address);
						}

						if (!empty($centre_lat)) {
							$object->update_meta_data('uat_Product_loc_lat', $centre_lat);
						}

						if (!empty($centre_long)) {
							$object->update_meta_data('uat_Product_loc_lng', $centre_long);
						}
						if (!empty($place_id)) {
							$object->update_meta_data('uat_Product_loc_place_id', $place_id);
						}

						if (!empty($postal_code)) {
							$object->update_meta_data('uat_Product_loc_post_code', $postal_code);
						}

						if (!empty($city)) {
							$object->update_meta_data('uat_Product_loc_city', $city);
						}

						if (!empty($country)) {
							$object->update_meta_data('uat_Product_loc_country', $country);
						}

						if (!empty($country_short)) {
							$object->update_meta_data('uat_Product_loc_country_short', $country_short);
						}

						if (!empty($state)) {
							$object->update_meta_data('uat_Product_loc_state', $state);
						}

						if (!empty($state_short)) {
							$object->update_meta_data('uat_Product_loc_state_short', $state_short);
						}

						if (!empty($loc_name)) {
							$object->update_meta_data('uat_Product_loc_name', $loc_name);
						}
					}
				}
			} else {
				$object->update_meta_data('uat_locationP_address', $address);
			}
		}


		/*  ------------------     Product Subtitle     --------------------  */
		if (isset($data['uat_auction_subtitle'])) {
			$lot_auction_subtitle = $data['uat_auction_subtitle'];
			if ($lot_auction_subtitle != "") {
				$object->update_meta_data('uat_auction_subtitle', $lot_auction_subtitle);
			}
		}

		/*  ------------------     Will it be a lot of an Auction Event    --------------------  */
		if (isset($data['uwa_event_auction'])) {
			$i_event_auction = strtolower(trim($data['uwa_event_auction']));

			if (in_array($i_event_auction, $arr_event_auction)) {
				$object->update_meta_data('uwa_event_auction', $i_event_auction);
			} else {
				/* "you have entered wrong auction type " */
				$object->update_meta_data('uwa_event_auction', "");
			}
		} /* end of isset */

		/*  ------------------   Buyer's Premium Auction Product    --------------------  */
		if (isset($data['uat_buyers_premium_type_sp_main'])) {
			$i_buyers_premium_main_type = strtolower(trim($data['uat_buyers_premium_type_sp_main']));

			if (in_array($i_buyers_premium_main_type, $arr_buyers_premium)) {
				$object->update_meta_data('uat_buyers_premium_type_sp_main', $i_buyers_premium_main_type);
			}
		} /* end of isset */

		if (isset($data['sp_buyers_premium'])) {
			$i_buyers_premium = strtolower(trim($data['sp_buyers_premium']));

			if (in_array($i_buyers_premium, $arr_buyers_premium)) {
				$object->update_meta_data('sp_buyers_premium', $i_buyers_premium);
			}
		} /* end of isset */

		/*  ------------------   Buyer's Premium Auto Debit Auction Product    --------------------  */
		if (isset($data['sp_buyers_premium_auto_debit'])) {
			$i_auto_debit = strtolower(trim($data['sp_buyers_premium_auto_debit']));

			if (in_array($i_auto_debit, $arr_auto_debit)) {
				$object->update_meta_data('sp_buyers_premium_auto_debit', $i_auto_debit);
			}
		} /* end of isset */


		/*  ------------------   Buyer's Premium Type Auction Product    --------------------  */
		if (isset($data['sp_buyers_premium_type'])) {
			$i_buyers_premium_type = strtolower(trim($data['sp_buyers_premium_type']));

			if (in_array($i_buyers_premium_type, $arr_buyers_premium_main_type)) {
				$object->update_meta_data('sp_buyers_premium_type', $i_buyers_premium_type);
			}
		} /* end of isset */


		/*  ------------------    Buyer's Premium Mention the Charge Auction Product     --------------------  */
		if (isset($data['sp_buyers_premium_fee_amt'])) {
			$i_buyers_premium_fee_amt = $data['sp_buyers_premium_fee_amt'];
			if ($i_buyers_premium_fee_amt != "") {
				$object->update_meta_data('sp_buyers_premium_fee_amt', $i_buyers_premium_fee_amt);
			}
		}

		/*  ------------------    Buyers Premium Minimum Premium Amount Auction Product   --------------------  */
		if (isset($data['sp_buyers_premium_fee_amt_min'])) {
			$i_buyers_premium_fee_amt_min = $data['sp_buyers_premium_fee_amt_min'];

			if ($i_buyers_premium_fee_amt_min > 0) {
				$object->update_meta_data('sp_buyers_premium_fee_amt_min', $i_buyers_premium_fee_amt_min);
			}
		} /* end of isset */

		/*  ------------------    Buyers Premium Maximum Premium Amount Auction Product   --------------------  */
		if (isset($data['sp_buyers_premium_fee_amt_max'])) {
			$i_buyers_premium_fee_amt_max = $data['sp_buyers_premium_fee_amt_max'];

			if ($i_buyers_premium_fee_amt_max > 0) {
				$object->update_meta_data('sp_buyers_premium_fee_amt_max', $i_buyers_premium_fee_amt_max);
			}
		} /* end of isset */


		/*  ------------------   Payment Hold & Debit Auction Product    --------------------  */
		if (isset($data['sp_type_automatically_debit_hold_type'])) {
			$i_automatically_debit_hold_type = strtolower(trim($data['sp_type_automatically_debit_hold_type']));

			if (in_array($i_automatically_debit_hold_type, $arr_automatically_debit_hold_type)) {
				$object->update_meta_data('sp_type_automatically_debit_hold_type', $i_automatically_debit_hold_type);
			}
		} /* end of isset */

		/*  ------------------   Hold a Specific Amount Auction Product    --------------------  */
		if (isset($data['sp_automatically_debit'])) {
			$i_automatically_debit = strtolower(trim($data['sp_automatically_debit']));

			if (in_array($i_automatically_debit, $arr_automatically_debit)) {
				$object->update_meta_data('sp_automatically_debit', $i_automatically_debit);
			}
		} /* end of isset */

		/*  ------------------  Specific Amount Charge Auction Product  --------------------  */
		if (isset($data['charge_hold_fix_amount'])) {
			$i_charge_hold_fix_amount = $data['charge_hold_fix_amount'];
			if ($i_charge_hold_fix_amount != "") {
				$object->update_meta_data('charge_hold_fix_amount', $i_charge_hold_fix_amount);
			}
		}
		/*  ------------------  Auto Debit Winning Amount Auction Product    --------------------  */
		if (isset($data['sp_type_automatically_debit'])) {
			$i_auto_debit_winning_amount = strtolower(trim($data['sp_type_automatically_debit']));

			if (in_array($i_auto_debit_winning_amount, $arr_auto_debit_winning_amount)) {
				$object->update_meta_data('sp_type_automatically_debit', $i_auto_debit_winning_amount);
			}
		} /* end of isset */

		/*  ------------------  Partial Amount Type Auction Product    --------------------  */
		if (isset($data['sp_partial_amount_type'])) {
			$i_partial_amount_type = strtolower(trim($data['sp_partial_amount_type']));

			if (in_array($i_partial_amount_type, $arr_partial_amount_type)) {
				$object->update_meta_data('sp_partial_amount_type', $i_partial_amount_type);
			}
		} /* end of isset */

		/*  ------------------   Partial Amount or Percentage Auction Product  --------------------  */
		if (isset($data['sp_partially_amount'])) {
			$i_partially_amount = $data['sp_partially_amount'];
			if ($i_partially_amount != "") {
				$object->update_meta_data('sp_partially_amount', $i_partially_amount);
			}
		}

		/*  ------------------  Auction - Enable Variable Increment Type  --------------------  */
		if (isset($data['uwa_auction_variable_bid_increment_type'])) {
			$i_bid_increment_type = strtolower(trim($data['uwa_auction_variable_bid_increment_type']));

			if (in_array($i_bid_increment_type, $arr_bid_increment_type)) {
				$object->update_meta_data('uwa_auction_variable_bid_increment_type', $i_bid_increment_type);
			} else {
				$object->update_meta_data('uwa_auction_variable_bid_increment_type', "");
			}
		} /* end of isset */

		/*  ------------------     Lot Number      --------------------  */
		if (isset($data['uat_auction_lot_number'])) {
			$lot_number = $data['uat_auction_lot_number'];
			if ($lot_number != "") {
				$object->update_meta_data('uat_auction_lot_number', $lot_number);
			} else {
				/* gives error for if needed */
				$object->update_meta_data('uat_auction_lot_number', "");
			}
		}

		/*  ------------------  Estimated opening price  --------------------  */
		if (isset($data['uat_estimate_price_from'])) {
			$i_estimate_price_from = $data['uat_estimate_price_from'];

			if ($i_estimate_price_from > 0) {
				$object->update_meta_data('uat_estimate_price_from', $i_estimate_price_from);
			} else {
				/* error - "you have entered wrong Estimated opening price " */
				$object->update_meta_data('uat_estimate_price_from', "");
			}
		} /* end of isset */


		/*  ------------------  Estimated closing price  --------------------  */
		if (isset($data['uat_estimate_price_to'])) {
			$i_estimate_price_to = $data['uat_estimate_price_to'];

			if ($i_estimate_price_to > 0) {
				$object->update_meta_data('uat_estimate_price_to', $i_estimate_price_to);
			} else {
				/* error - "you have entered wrong closing price " */
				$object->update_meta_data('uat_estimate_price_to', "");
			}
		} /* end of isset */


		/*  ------------------  Number of Next bid  --------------------  */
		if (isset($data['uwa_number_of_next_bids'])) {
			$i_next_bid = $data['uwa_number_of_next_bids'];

			if ($i_next_bid != "") {
				$object->update_meta_data('uwa_number_of_next_bids', $i_next_bid);
			} else {
				/* error - "you have entered wrong Next bid " */
				$object->update_meta_data('uwa_number_of_next_bids', "");
			}
		} /* end of isset */


		/*  ------------------ auction selling type  --------------------  */
		if (isset($data['woo_ua_auction_selling_type'])) {
			$i_selling_type = strtolower(trim($data['woo_ua_auction_selling_type']));

			if (in_array($i_selling_type, $arr_selling_type)) {
				$object->update_meta_data('woo_ua_auction_selling_type', $i_selling_type);
			} else {
				$object->update_meta_data('woo_ua_auction_selling_type', "auction");
				/* "you have entered wrong selling type " */
			}
		} /* end of isset */


		/*  ------------------  product condition  --------------------  */
		/* product condition can be anything */
		/*  if(isset($data['woo_ua_product_condition'])){
	    $i_product_condition = strtolower(trim($data['woo_ua_product_condition']));
	    
	    
	    if(in_array($i_product_condition, $arr_product_condition)){    
	        $object->update_meta_data( 'woo_ua_product_condition', $i_product_condition);
	    }
	    else{
	    	
	    	$object->update_meta_data( 'woo_ua_product_condition', "new");
	    }
	}  end of isset */






		/*  ------------------  proxy and slient  --------------------  */
		if (isset($data['uwa_auction_proxy']) && isset($data['uwa_auction_silent'])) {
			$i_proxy = strtolower(trim($data['uwa_auction_proxy']));
			$i_slient = strtolower(trim($data['uwa_auction_silent']));

			if ($i_proxy == "yes" && $i_slient == "yes") {
				/* error - Both can not enabled at the same time */
				$object->update_meta_data('uwa_auction_proxy', "0");
				$object->update_meta_data('uwa_auction_silent', "0");
			} else {
				if (in_array($i_proxy, $arr_proxy)) {
					$object->update_meta_data('uwa_auction_proxy', $i_proxy);
				} else {
					/* "you have entered wrong proxy value "  or set as 0 */
					$object->update_meta_data('uwa_auction_proxy', "0");
				}

				if (in_array($i_slient, $arr_slient)) {
					$object->update_meta_data('uwa_auction_silent', $i_slient);
				} else {
					/* "you have entered wrong slient value "  or set as 0 */
					$object->update_meta_data('uwa_auction_silent', "0");
				}
			} /* end of else */
		} /* end of isset */


		/*  ------------------  opening price  --------------------  */
		if (isset($data['woo_ua_opening_price'])) {
			$i_opening_price = $data['woo_ua_opening_price'];

			if ($i_opening_price > 0) {
				$object->update_meta_data('woo_ua_opening_price', $i_opening_price);
			} else {
				/* error - "you have entered wrong opening price " */
				$object->update_meta_data('woo_ua_opening_price', "");
			}
		} /* end of isset */


		/*  ------------------   Enable Reserve Price Auction Event    --------------------  */
		if (isset($data['uwa_auction_has_reserve'])) {
			$i_auction_has_reserve = strtolower(trim($data['uwa_auction_has_reserve']));

			if (in_array($i_auction_has_reserve, $arr_auction_has_reserve)) {
				$object->update_meta_data('uwa_auction_has_reserve', $i_auction_has_reserve);
			} else {
				/* "you have entered wrong auction type " */
				$object->update_meta_data('uwa_auction_has_reserve', "no");
			}
		} /* end of isset */

		/*  ------------------  lowest price  --------------------  */
		if (isset($data['woo_ua_lowest_price'])) {
			$i_lowest_price = $data['woo_ua_lowest_price'];

			if ($i_lowest_price >= 0) {
				$object->update_meta_data('woo_ua_lowest_price', $i_lowest_price);
			} else {
				/* error - "you have entered wrong lowest price " */
				$object->update_meta_data('woo_ua_lowest_price', "");
			}
		} /* end of isset */


		/*  ------------------  buy now price  --------------------  */
		if (isset($data['uat_import_buynow_price'])) {

			$i_buynow_price = $data['uat_import_buynow_price'];
			if ($i_buynow_price > 0) {
				$object->update_meta_data('uat_import_buynow_price', $i_buynow_price);
			}

			/*$i_buynow_price = $data['_regular_price'];
		$object->update_meta_data( 'uwa_auction_via_importing', "yes" );
	    if ( $i_buynow_price >= 0 ) {
	        $object->update_meta_data( '_regular_price', $i_buynow_price );
	        $object->update_meta_data( '_price', $i_buynow_price );
	    }*/
		} /* end of isset */


		/*  ------------------  start date and end date  --------------------  */
		if (isset($data['woo_ua_auction_start_date']) && isset($data['woo_ua_auction_end_date'])) {

			$i_start_date = $data['woo_ua_auction_start_date'];
			$i_end_date = $data['woo_ua_auction_end_date'];

			if (!empty($i_start_date) && !empty($i_end_date)) {

				$sd_timestamp = strtotime($i_start_date);
				$ed_timestamp = strtotime($i_end_date);
				if ($sd_timestamp != false && $ed_timestamp != false) {

					if ($sd_timestamp < $ed_timestamp) {

						/* startdate */
						$new_startdt_format = date('Y-m-d H:i:s', $sd_timestamp);
						$object->update_meta_data('woo_ua_auction_start_date', $new_startdt_format);

						/* enddate */
						$new_enddt_format = date('Y-m-d H:i:s', $ed_timestamp);
						$object->update_meta_data('woo_ua_auction_end_date', $new_enddt_format);
					} else {
						/* "end date must be greater than start date" */
					}
				} else {
					/* "you have entered wrong start or end date" */
				}
			} else {
				/* error - "start date or end date is blank" */
			}
		} /* end of isset */

		/*  ------------------  Auction - Enable Variable Increment Type  --------------------  */
		if (isset($data['uwa_auction_variable_bid_increment_type'])) {
			$i_bid_increment_type = strtolower(trim($data['uwa_auction_variable_bid_increment_type']));

			if (in_array($i_bid_increment_type, $arr_bid_increment_type)) {
				$object->update_meta_data('uwa_auction_variable_bid_increment_type', $i_bid_increment_type);
			}
		} /* end of isset */


		/*  ------------------  Variable and Simple Bid Increment  --------------------  */
		if (isset($data['woo_ua_bid_increment']) || isset($data['uwa_auction_variable_bid_increment'])) {

			/*  --- simple bid increment  ---  */
			$i_bid_increment = $data['woo_ua_bid_increment'];

			if ($i_bid_increment != "") {
				if ($i_bid_increment >= 0) {
					$object->update_meta_data('woo_ua_bid_increment', $i_bid_increment);
				} else {
					/* no error "you have entered wrong bid increment" */
				}
			}
			//else{

			/*  --- variable bid increment  ---  */
			$i_enable_variable_bidinc = $data['uwa_auction_variable_bid_increment'];
			if ($i_enable_variable_bidinc == "yes") {

				/* add variable increment price */
				$i_variable_bid_inc = $data['uwa_var_inc_price_val'];

				if (!empty($i_variable_bid_inc)) {
					$array_data = array();
					$jsondatas = explode("*", $i_variable_bid_inc);
					$i = 0;
					$count_error = 0;
					foreach ($jsondatas as $jsondata) {
						$variable_val = explode("-", $jsondata);

						if (isset($variable_val[0]) && isset($variable_val[1]) && isset($variable_val[2])) {
							$start = $variable_val[0];
							$end = $variable_val[1];
							$inc_val = $variable_val[2];

							if ($start > 0 && $end > 0 && $inc_val > 0) {
								//if($end == $end){
								//$i=$end;
								//}

								$array_data[$i] = array("start" => $start, "end" => $end, "inc_val" => $inc_val);
							} else {
								$count_error++;
							}
							$i++;
						} /* end of if - isset variable_val */ else {
							$count_error++;
						}
					} /* end of foreach */


					if ($count_error > 0) {
						/* Error - you have entered wrong format or value in  variable increment */
					} else {

						$arr_i_variable_bid_inc  = $array_data;

						$object->update_meta_data(
							'uwa_auction_variable_bid_increment',
							$i_enable_variable_bidinc
						);
						$object->update_meta_data(
							'uwa_var_inc_price_val',
							$arr_i_variable_bid_inc
						);
					}
				} /* end of if - empty */
			}  /* end of if - enabled variable inc */

			//} /* end of else */

		} /* end of isset */
	} /* end of main if - type= auction */

	return $object;
}


add_action('woocommerce_product_import_inserted_product_object', 'uat_admin_force_update_buynow_price', 200, 2);
function uat_admin_force_update_buynow_price($object, $data)
{

	if ($data['type'] == "auction") {

		$product_id = $object->get_id();
		$buynow_price = get_post_meta($product_id, 'uat_import_buynow_price', true);

		if (!empty($buynow_price)) {
			delete_post_meta($product_id, '_price');
			delete_post_meta($product_id, '_regular_price');
			update_post_meta($product_id, '_price', wc_format_decimal(wc_clean($buynow_price)));
			update_post_meta($product_id, '_regular_price', wc_format_decimal(wc_clean($buynow_price)));
		}
	}
}


add_action('wp_ajax_nopriv_get_import_results_data', 'fun_get_import_results_data');
add_action('wp_ajax_get_import_results_data', 'fun_get_import_results_data');
function fun_get_import_results_data()
{
	if (!empty($_REQUEST["btn_import"])) {
		// input data  through array
		$response = [];
		//$today_date = date('Y-m-d H:i:s');
		$today_date = get_ultimate_auction_now_date();
		$start_date = $today_date;
		$end_date =  date('Y-m-d H:i:s', strtotime('30 days'));
		$timezone = get_option('timezone_string');
		$data = array(
			"0" => array(
				"ID" => "",
				"post_title" => "Live product 1",
				"post_name" => "live-product-1",
				"woo_ua_auction_start_date" => "$start_date",
				"woo_ua_auction_end_date" => "$end_date",
				"woo_ua_auction_status" => "future",
				"woo_ua_auction_current_bid" => "100",
				"woo_ua_auction_reserve_price" => "200",
				"timezone" => ".$timezone."
			)
		);

		// encode array to json
		$json = json_encode($data);
		$upload = wp_upload_dir();
		$dir = $upload['basedir'];
		$upload_dir = $dir . '/auction_json';
		if (file_exists($upload_dir)) {
			$folder_exist = __('Folder Already Exists <br> Please Go Ahead.', 'ultimate-auction-pro-software');
		} else {
			// try to create this directory if it doesn't exist
			$booExists     = is_dir($upload_dir) || (mkdir($upload_dir, 0755, false) && is_dir($upload_dir));
			$booIsWritable = false;
			if ($booExists && is_writable($upload_dir)) {
				$tempFile = tempnam($upload_dir, 'tmp');
				if ($tempFile !== false) {
					$res = file_put_contents($upload_dir . '/auction_test.json', $json);
					$folder_perms = __('Folder Created & File Write Success', 'ultimate-auction-pro-software');

					$save_path = $upload_dir . '/auction_test.json';
					//$save_path = $upload['baseurl'] . "/auction_json/auction_test.json";
					if (file_exists($save_path)) {
						$file_url = $upload['baseurl'] . '/auction_json/auction_test.json';
						$args = array(
							'timeout' => 10,
							'method'  => 'POST'
						);
						//$response = is_readable($file_url);
						$response = wp_remote_post($file_url, $args);
						//print_r($response);
						if (is_wp_error($response)) {

							$file_data = __('File Not Read Success', 'ultimate-auction-pro-software');
							//return $json_data_response;
						} else {
							$file_data = __('File Read Success', 'ultimate-auction-pro-software');
						}
					}

					$booIsWritable = $res !== true;
					@unlink($tempFile);
				}
			} else {

				$not_writable = __('NO directory it is not writable! Please check Permission For Folder wp-content\uploads\auction_json', 'ultimate-auction-pro-software');
			}
		}

		//$file_data = 'File Write Success';
		//$not_writable = "NO directory it is not writable! Please check Permission For Folder wp-content\uploads\auction_json";
		$response = array(
			'folder_exist' => $folder_exist,
			'folder_perms' => $folder_perms,
			'file_data' => $file_data,
			'not_writable' => $not_writable
		);

		exit(json_encode($response));
	}

	wp_die();
}
