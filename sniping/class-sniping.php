<?php
 /**
 * Class for Sniping
 * Uat_Auction_Sniping Main class
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

    class Uat_Auction_Sniping {

		public function __construct() {

			add_action( 'uat_sniping_extend_auction_time', array( $this, 'uat_sniping_extend_auction_time_antisnipping' ) ,10, 2);
		}

		public function uat_sniping_extend_auction_time_antisnipping( $auction_id ){

			$enable = get_option('options_uat_anti_snipping_enable', 'off');
			if($enable =="on"){
				$ext_tm = get_option('options_uat_auto_extend_time', '0');
				$ext_tm = (double)$ext_tm;

				$ext_tmm = get_option('options_uat_auto_extend_time_m', '5');
				$ext_tmm = (double)$ext_tmm;

				$is_snip="false";

				if($ext_tm > 0 || $ext_tmm > 0 ){	/* any of them must be > 0 */

						$ext_whn = get_option('options_uat_auto_extend_when', ' 0');
						$ext_whn = (double)$ext_whn;

						$ext_whnm = get_option('options_uat_auto_extend_when_m', ' 5');
						$ext_whnm = (double)$ext_whnm;

						if(($ext_whn > 0 || $ext_whnm > 0) && ($ext_tm > 0 || $ext_tmm > 0) ){
							$le = get_post_meta($auction_id, 'woo_ua_auction_end_date', true);

							if(strtotime(get_ultimate_auction_now_date()) >= (strtotime($le) - (($ext_whn*3600) + ($ext_whnm*60)))){

								$dt = strtotime(get_ultimate_auction_now_date())+(($ext_tm*3600) + ($ext_tmm*60));
								//$new_end_date = wp_date('Y-m-d H:i:s', $dt,get_uwa_wp_timezone());
								update_post_meta($auction_id, 'uat_from_anti_snipping', 'yes');
								$sniping_type  = get_option('options_uat_aviod_snipping_type', 'snipping_only_once');
								//snipping_recursive // snipping_only_once
								$new_date = date("Y-m-d H:i:s", $dt);
								$cookie_time = strtotime($new_date)  -  (get_option( 'gmt_offset' )*3600);
								if($sniping_type == "snipping_recursive"){

									$is_done = update_post_meta($auction_id, 'woo_ua_auction_end_date', $new_date);
$is_snip='true';

									/* Set that recursive antisipping is done */
									if($is_done != false){
										setcookie('acution_end_time_php_'.$auction_id, $cookie_time, time() + (86400 * 30 * 7), "/");
										update_post_meta($auction_id, 'uat_snipping_recursive_done', 'yes');


									}
								}
								else if($sniping_type == "snipping_only_once" || $sniping_type == "" ){

									$is_updated = update_post_meta($auction_id, 'woo_ua_auction_end_date', date("Y-m-d H:i:s", $dt));
$is_snip='true';
									/* Set that only once antisipping is done */
									if($is_updated != false){
										setcookie('acution_end_time_php_'.$auction_id, $cookie_time, time() + (86400 * 30 * 7), "/");
										update_post_meta($auction_id, 'uat_snipping_only_once_done', 'yes');


									}
								}

							}





						} /* end of if */


						$auctionId=$auction_id;
							global $wpdb;
							global $post;
							if (empty($auctionId)) {
								return;
							}
							$upload = wp_get_upload_dir();
							$file_name = $auctionId . '_bids.json';
							$save_path = $upload['basedir'] . '/auction_json/' . $file_name;
							$file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
							$url      = $file_path;
							// $response = wp_remote_get($url, getArgs());
							// $api_response = json_decode(wp_remote_retrieve_body($response), true);
							$api_response = get_auction_json_file($auctionId,$file_type="_bids");
							if (sizeof((array)$api_response) == 0) {
								return;
							}
							$api_response[sizeof($api_response) - 1]['woo_ua_is_sniping'] = $is_snip;


							$data = json_encode($api_response);
							$f = fopen($save_path, "w");
							fwrite($f, $data);
							fclose($f);

				} /* end of if  -- extend minutes and hours  > 0  */



			} /* end of if  -- enable  */
		}


	}
$GLOBALS['Uat_Auction_Sniping'] = new Uat_Auction_Sniping();