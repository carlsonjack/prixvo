<?php
function uat_user_place_bid_ajax(){
ob_clean();

$auction_id = $product_id = absint($_REQUEST['auction_id']);
$bid = $uwa_bid_value = abs(round(str_replace(',', '.', $_REQUEST['uwa_bid_value']), wc_get_price_decimals()));
$placing_bid = wc_get_product($product_id);


			$was_place_bid = false;

			$placing_bid = wc_get_product($product_id);

				$product_type = method_exists($placing_bid, 'get_type') ? $placing_bid->get_type() : $placing_bid->product_type;

				if ('auction' === $product_type) {

					$product_data = wc_get_product($product_id);
					$current_user = wp_get_current_user();
					$outbiddeduser = $placing_bid->get_uwa_auction_current_bider();
					$auction_high_current_bider = $product_data->get_uwa_auction_max_current_bider();
					$uwa_silent = $product_data->get_uwa_auction_silent();
					if ($auction_high_current_bider == $outbiddeduser) {
						$outbiddeduser = "";
					}
					$uwa_silent_outbid_email = get_option('uwa_silent_outbid_email', "no");
					if ($uwa_silent == 'yes'  && $uwa_silent_outbid_email == "no") {
						$outbiddeduser = "";
					}
					if ($outbiddeduser  == $current_user->ID) {
						$outbiddeduser = "";
					}




				$UAT_Bid = new UAT_Bid;
				/* Placing Bid */
				if ($UAT_Bid->uat_bidplace($product_id, $bid)) {
					// echo "l 1";
					// exit;
					/*  --- place bid message not to display -- */

					$was_place_bid = true;
					echo uat_bid_place_message($product_id);


					$placed_bid[] = $product_id;

					if ($was_place_bid) {

						$check_email = new EmailTracking();
						$email_status = $check_email->duplicate_email_check($auction_id=$product_id ,$user_id=$current_user->ID,$email_type='place_bid',$amount=$bid);
						if( !$email_status )
						{
							$uat_Email = new PlaceBidMail();
							$uat_Email->place_bid_email($product_id ,$current_user->ID );
						}
					}
				}

				}







wp_die();
}
add_action( 'wp_ajax_nopriv_uat_user_place_bid_ajax', 'uat_user_place_bid_ajax' );
add_action( 'wp_ajax_uat_user_place_bid_ajax', 'uat_user_place_bid_ajax' );


// update bid list with ajax
function get_bid_list_ajax(){
	ob_clean();
	$auctionId = $_POST['auction_id'];
	$upload = wp_get_upload_dir();
	$file_name = $auctionId . '_bids.json';
	$save_path = $upload['basedir'] . '/auction_json/' . $file_name;
	$file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
	$url      = $file_path;

	$response = wp_remote_get(esc_url_raw($url));

	$api_response = json_decode(wp_remote_retrieve_body($response), true);

	// reverce array for show latest bid first
	$api_response = array_reverse($api_response);
	$datetimeformat = get_option('date_format').' '.get_option('time_format');
	$html = "";
	// global $woocommerce, $post, $product;
	if (!empty($api_response))
	{
		foreach ($api_response as $bid) {
			$product = wc_get_product( $bid['woo_ua_auction_id'] );
			$user_name = uat_user_display_name($bid['woo_ua_auction_user_id']);
				if ($product->get_uwa_auction_proxy()=="yes"){
					$user_name = uat_proxy_mask_user_display_name($bid['woo_ua_auction_user_id']);
				}elseif($product->get_uwa_auction_silent()=="yes"){
					$user_name = uat_silent_mask_user_display_name($bid['woo_ua_auction_user_id']);
				}
			// $user = get_user_by('id', $bid['woo_ua_auction_user_id']);
			$html .= "<tr>";
				$html .= "<td>". $user_name ."</td>";
				$html .= "<td>".mysql2date($datetimeformat , $bid['woo_ua_auction_bid_time'])."</td>";
				$html .= "<td>".wc_price($bid['woo_ua_auction_bid_amount'])."</td>";
				if ($bid['woo_ua_auction_bid_proxy'] == 1) {
					$html .= "<td>".__('Auto', 'ultimate-auction-pro-software')."</td>";
				}else{
					$html .= "<td></td>";
				}
			$html .= "</tr>";
		}
	}

	// echo $html;
	$data = array();
	$data['count'] = sizeof($api_response);
	$data['html'] = $html;
	echo json_encode( $data );

	wp_die();
	}
add_action( 'wp_ajax_nopriv_get_bid_list_ajax', 'get_bid_list_ajax' );
add_action( 'wp_ajax_get_bid_list_ajax', 'get_bid_list_ajax' );