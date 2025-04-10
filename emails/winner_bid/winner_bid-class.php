<?php

/*
* WinnerBidMail class
*
* This class initiate general purpose custom fields.
*/
if (!defined('ABSPATH'))
{
    die('Access denied.');
}
if (!class_exists('WinnerBidMail')):
    class WinnerBidMail
    {

	private $from_address;
	private $from_name;
	private $content_type;
	private $headers;
	private $template;
	private $heading = '';
	/**
	 * WinnerBidMail constructor.
	 */
	public function __construct() {

		add_action( 'uat_email_send_before', array( $this, 'send_before' ) );
		add_action( 'uat_email_send_after', array( $this, 'send_after' ) );
	}
	public function __set( $key, $value ) {
		$this->$key = $value;
	}
	public function __get( $key ) {
		return $this->$key;
	}
	public function get_blogname() {

		return wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}
	public function get_admin_email() {
		$admin_email = get_option( 'admin_email' );
		return $admin_email;
	}
	public function get_from_name() {
		$email_type ="email_setting";
		$email_object = get_option("uat_email_template_" . $email_type);
		$this->from_name = $email_object['from_name'];

		if ( !$this->from_name ) {
			$this->from_name = $this->get_blogname();
		}
		return wp_specialchars_decode( $this->from_name );
	}

	public function get_from_address() {

		$email_object = get_option("uat_email_template_email_setting");
		$this->from_address = $email_object['from_address'];

		if( empty( $this->from_address ) || ! is_email( $this->from_address ) ) {
			$this->from_address = get_option( 'admin_email' );
		}
		return $this->from_address;
	}

	public function get_content_type() {
		$email_object = get_option("uat_email_template_email_setting");
		$template = $email_object['template'];
		$this->content_type ='text/html';

		if ( $template =="none" ) {
			$this->content_type = 'text/plain';
		}
		return $this->content_type;
	}


	public function get_headers() {
		if ( ! $this->headers ) {
			$this->headers  = "From: {$this->get_from_name()} <{$this->get_from_address()}>\r\n";
			$this->headers .= "Reply-To: {$this->get_from_address()}\r\n";
			$this->headers .= "Content-Type: {$this->get_content_type()}; charset=utf-8\r\n";
		}

		return $this->headers;
	}


	public function get_content( $email_slug, $user_id="", $product_id="", $user_type='') {
			ob_start();
			$template_details = get_email_temaplte_from_db($email_slug);
			//echo"<pre>";print_r($template_details);echo"</pre>";
			$template = isset($template_details['template']) ? $template_details['template'] : "default";
			
			if($template =="custom"){
				$footer_txt = isset($template_details['footer_txt']) ? $template_details['footer_txt'] : "{site_title} — Built with {Ultimate Auction Pro}";
				$base_color = isset($template_details['base_color']) ? $template_details['base_color'] : "#96588a";
				$bg_color = isset($template_details['bg_color']) ? $template_details['bg_color'] : "#f7f7f7";
				$body_bg_color = isset($template_details['body_bg_color']) ? $template_details['body_bg_color'] : "#ffffff";
				$body_text_color = isset($template_details['body_text_color']) ? $template_details['body_text_color'] : "#3c3c3c";
				$template = "customize";
				$email_data =  array(
				'email_slug' => $email_slug,
				'footer_txt' => $footer_txt,
				'base_color' => $base_color,
				'bg_color' => $bg_color,
				'body_bg_color' => $body_bg_color,
				'body_text_color' => $body_text_color,
				'user_type' => $user_type,
				);
			}else if($template =="default"){
				//getting from email main setting template name
				$template_details = get_option('uat_email_template_email_setting');
			    $template = isset($template_details['template']) ? $template_details['template'] : "default";
				if($template =="customize"){
					$footer_txt = isset($template_details['footer_txt']) ? $template_details['footer_txt'] : "{site_title} — Built with {Ultimate Auction Pro}";
					$base_color = isset($template_details['base_color']) ? $template_details['base_color'] : "#96588a";
					$bg_color = isset($template_details['bg_color']) ? $template_details['bg_color'] : "#f7f7f7";
					$body_bg_color = isset($template_details['body_bg_color']) ? $template_details['body_bg_color'] : "#ffffff";
					$body_text_color = isset($template_details['body_text_color']) ? $template_details['body_text_color'] : "#3c3c3c";

					$email_data =  array(
					'email_slug' => $email_slug,
					'footer_txt' => $footer_txt,
					'base_color' => $base_color,
					'bg_color' => $bg_color,
					'body_bg_color' => $body_bg_color,
					'body_text_color' => $body_text_color,
					'user_type' => $user_type,
					);

				} else{
					$email_data =  array('email_slug' => $email_slug,'user_type' => $user_type);
				}

			}

			$email_content = get_template_part( 'includes/emails/templates/emails/email', $template , $email_data);
			$email_content = ob_get_contents();
			ob_end_clean();
			return $this->replacing_tempalte_tags_string_body($email_content,$user_id, $product_id);

	}


	public function replacing_tempalte_tags_string_body( $string ,$user_id="", $product_id="" ) {
		
		$username =	$this->get_username( $user_id );
		$event_name =	$this->get_product_event_name( $product_id );
		$useremail =	$this->get_user_email($user_id);
		$phone_number = get_user_meta($user_id, 'billing_phone', true);
		$billing_address = get_user_meta($user_id, 'billing_address', true);

		$link_button = $this->get_user_confirmation_link($user_id);
		$approve_link = $this->get_user_approve_link($user_id);
		//$psw_reset = $this->get_psw_reset_link($user_id);
		$string = str_replace( '{username}', $username, $string );
		$string = str_replace( '{event_name}', $event_name, $string );
		$string = str_replace( '{site_title}', $this->get_blogname(), $string );
		$string = str_replace( '{confirmation_link}', $link_button, $string );
		$string = str_replace( '{approve_link}', $approve_link, $string );

		$string = str_replace( '{bidder_name}', $username, $string );
		$string = str_replace( '{bidder_email}', $useremail, $string );
		$string = str_replace( '{bidder_phone}', $phone_number, $string );
		$string = str_replace( '{bidder_address}', $billing_address, $string );
		$string = str_replace( '{useremail}', $useremail, $string );
		$string = str_replace( '{currency_code}', get_woocommerce_currency_symbol(), $string );
		//$string = str_replace( '{reset_link}', $psw_reset, $string );
		if(!empty($product_id)){
			$product_name =	$this->get_product_name( $product_id );
			$product_url =	$this->get_product_url( $product_id );
			$product_image =	$this->get_product_image( $product_id );
			$bid_value =	$this->get_product_bid_value( $product_id );
			$product_description =	$this->get_product_description( $product_id );
			$auction_endtime =	$this->get_product_auction_endtime( $product_id );
			/* Seller details */
			
			
			$uat_enable_offline_dealing_for_buyer_seller = get_option( 'options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller',"0" );
			$uat_send_first_last_name = get_option( 'options_uat_send_first_last_name',"0" );
			$uat_send_mailing_address = get_option( 'options_uat_send_mailing_address',"0" );
			$uat_send_phone_mobile_number = get_option( 'options_uat_send_phone_mobile_number',"0" );
			$uat_send_seller_address = get_option( 'options_uat_send_seller_address',"0" );
			$uat_do_you_want_to_send_information_via_email = get_option( 'options_uat_do_you_want_to_send_information_via_email',"0" );
			$uat_only_show_when_buyers_commission_debited = get_option( 'options_uat_only_show_when_buyers_commission_has_been_automatically_debited',"0" );
			$seller_name = '';
			$seller_email = '';
			$seller_phone = '';
			$seller_address = '';
	   
			
			
			if($uat_enable_offline_dealing_for_buyer_seller=='1' && $uat_do_you_want_to_send_information_via_email=='1'){
				if($uat_only_show_when_buyers_commission_debited=='1'){
					global $wpdb;
					$query_bp = "SELECT `status` FROM `".$wpdb->prefix."auction_direct_payment` WHERE uid=".$user_id." AND pid=".$product_id." AND debit_type='buyers_premium'";
					$results_bp = $wpdb->get_results($query_bp);
					if(!empty($results_bp)){
						$status_bp = $results_bp[0]->status;
						if($status_bp == 'succeeded'){
							if($uat_send_first_last_name=='1') { $seller_name = get_field('auction_seller_name', $product_id);}
							if($uat_send_mailing_address=='1') { $seller_email = get_field('seller_email_id', $product_id); }
							if($uat_send_phone_mobile_number=='1') { $seller_phone = get_field('seller_phone_number', $product_id); }
							if($uat_send_mailing_address=='1') { $seller_address = get_field('contact_details', $product_id); }
						}else{
							$seller_hide = "The payment for the buyer's premium was unsuccessful. Kindly reach out to settle the commission in order to access the seller's information.";
							$string = str_replace('{seller_name}', $seller_hide, $seller_hide);
						}
					}
				}else{
					if($uat_send_first_last_name=='1') { $seller_name = get_field('auction_seller_name', $product_id);}
					if($uat_send_mailing_address=='1') { $seller_email = get_field('seller_email_id', $product_id); }
					if($uat_send_phone_mobile_number=='1') { $seller_phone = get_field('seller_phone_number', $product_id); }
					if($uat_send_seller_address=='1') { $seller_address = get_field('contact_details', $product_id); }
				}				
			}else{
				$order_id = get_post_meta( $product_id, 'woo_ua_order_id', true );
				if(!empty($order_id)){
					$order = wc_get_order($order_id);
					$pay_now_url =  $order->get_checkout_payment_url() ;
					$string = str_replace( '{order_pay_url}', $pay_now_url, $string );
				}else{
					$pay_now_url = esc_attr(add_query_arg("pay-uwa-auction",$product_id, wc_get_checkout_url()));
					$string = str_replace( '{order_pay_url}', $pay_now_url, $string );
				}
			}
			
			$string = str_replace( '{seller_name}', $seller_name, $string );
			$string = str_replace( '{seller_email}', $seller_email, $string );
			$string = str_replace( '{seller_phone}', $seller_phone, $string );
			$string = str_replace( '{seller_address}', $seller_address, $string );
			
			/* Seller email */
			
			$string = str_replace( '{product_name}', $product_name, $string );
			$string = str_replace( '{product_url}', $product_url, $string );
			$string = str_replace( '{product_image}', $product_image, $string );
			$string = str_replace( '{bid_value}', $bid_value, $string );
			$string = str_replace( '{product_description}', $product_description, $string );
			$string = str_replace( '{auction_endtime}', $auction_endtime, $string );

			
			



			}
		return $string;

	}
	public function replacing_tempalte_tags_string_subject( $string , $user_id="" , $product_id="" ) {

		$username =	$this->get_username( $user_id );
		$event_name =	$this->get_product_event_name( $product_id );
		$string = str_replace( '{username}', $username, $string );
		$string = str_replace( '{event_name}', $event_name, $string );
		$string = str_replace( '{site_title}', $this->get_blogname(), $string );
		$string = str_replace( '{bidder_name}', $username, $string );

		if(!empty($product_id)){
			$product_name =	$this->get_product_name( $product_id );
			$product_url =	$this->get_product_url( $product_id );
			$string = str_replace( '{product_name}', $product_name, $string );
			$string = str_replace( '{product_url}', $product_url, $string );
			}
		return $string;
	}
	public function get_product_name( $product_id ) {
		$product_title = wp_kses_post( get_the_title( $product_id ) );
		return $product_title;
	}

	public function get_product_url( $product_id ) {
		$product_title = wp_kses_post( get_the_title( $product_id ) );
		$url_product = get_permalink( $product_id );
		$url_produc_link = '<a  target="blank" href="'.$url_product.'" >'.$product_title.'</a>';
		return $url_produc_link;
	}
	public function get_product_image( $product_id ) {
		$product = wc_get_product( $product_id );
		$thumb_image = $product->get_image( 'thumbnail' );
		return $thumb_image;
	}
	public function get_product_bid_value( $product_id ) {
		$product = wc_get_product( $product_id );
		$bid_value = $product->get_uwa_current_bid();
		return $bid_value;
	}
	public function get_product_description( $product_id ) {
		$product = wc_get_product( $product_id );
		$description = $product->get_description();
		return $description;
	}
	public function get_product_auction_endtime( $product_id ) {
		$datetimeformat = get_option('date_format').' '.get_option('time_format');
		$product = wc_get_product( $product_id );
		$endtime1 = $product->get_uwa_auction_end_dates();
		$endtime = mysql2date($datetimeformat ,$endtime1);
		return $endtime;
	}
	public function get_product_event_name( $product_id ) {
		$event_id = get_post_meta( $product_id, 'uat_event_id', true );
		$eventnm = get_the_title($event_id);
		return $eventnm;
	}

    /*
	won_bid*/
	

	public function winner_bid_email($product_id ,$user_id ) {
        $email_slug ="won_bid";
        $email_object = get_option("uat_email_template_" . $email_slug);

		$enable = $email_object['enable'];

        $admin_enable = $email_object['admin_enable'];
       $seller_enable = $email_object['seller_enable'];
        if($enable =="yes" && !empty($user_id)){

			$check_email = new EmailTracking();
			$email_status = $check_email->duplicate_email_check($product_id ,$user_id,'won_bid');
			if( !$email_status )
			{
				$uwt_email_wonbid_user_enabled = get_user_meta($user_id,'uwt_email_wonbid_user_enabled', true);
				if( $uwt_email_wonbid_user_enabled == "no" )
				{
					return false;
				}
				$to = $this->get_user_email($user_id);
				$subject = $this->replacing_tempalte_tags_string_subject($email_object['subject'],$user_id,$product_id);
				$message = $this->get_content($email_slug, $user_id,$product_id , $user_type='');
				$sent = $this->mail_send( $to, $subject, $message);

				$admin_email = get_option( 'admin_email' );
				$check_email->tracking_add($auction_id=$product_id ,$user_id=$user_id,$user_email=$admin_email,$receiver_email=$to,$admin_email=$admin_email?'1':'0',$email_type='won_bid',$status=$sent,$subject=$subject,$headers=$this->get_headers(),$message=$message ,$amount='',$error=!$sent);

			}


			if($admin_enable =="yes")
			{
				$admin_email = get_option( 'admin_email' );


				$subject = $this->replacing_tempalte_tags_string_subject($email_object['subject_admin'],$user_id,$product_id);
				$message = $this->get_content($email_slug, $user_id,$product_id, $user_type='admin' );



				$sent = $this->mail_send( $admin_email, $subject, $message);
				$check_email->tracking_add($auction_id=$product_id ,$user_id=$user_id,$user_email=$admin_email,$receiver_email=$admin_email,$admin_email=$admin_email?'1':'0',$email_type='won_bid',$status=$sent,$subject=$subject,$headers=$this->get_headers(),$message=$message ,$amount='',$error=!$sent);
			}

			if($seller_enable =="yes")
			{
				
				$uat_enable_offline_dealing_for_buyer_seller = get_option( 'options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller',"0" );
				$uat_do_you_want_to_send_information_via_email = get_option( 'options_uat_do_you_want_to_send_information_via_email',"0" );

				$seller_email_id = get_field('seller_email_id',$product_id);

				if($uat_enable_offline_dealing_for_buyer_seller=='1' && $uat_do_you_want_to_send_information_via_email=='1'){
					$admin_email = get_option( 'admin_email' );
					if(!empty($seller_email_id)){
						$subject = $this->replacing_tempalte_tags_string_subject($email_object['subject_seller_admin'],$user_id,$product_id);
						$message = $this->get_content($email_slug, $user_id,$product_id, $user_type='seller' );
						$sent = $this->mail_send( $seller_email_id, $subject, $message);
						$check_email->tracking_add($auction_id=$product_id ,$user_id=$user_id,$user_email=$admin_email,$receiver_email=$seller_email_id,$admin_email=$admin_email?'1':'0',$email_type='won_bid',$status=$sent,$subject=$subject,$headers=$this->get_headers(),$message=$message ,$amount='',$error=!$sent);
					}
				}
			
			}

			

        }
        return false;
    }

	public function mail_send( $to, $subject, $message, $attachments = '' ) {
		do_action( 'uat_email_send_before', $this );

		$sent = wp_mail( $to, $subject, $message, $this->get_headers(), $attachments );

		do_action( 'uat_email_send_after', $this );
		return $sent;
	}


	public function get_user_email( $user_id ) {
		$author_obj = get_user_by('id', $user_id);
		$user_email =$author_obj->user_email;
		return $user_email;
	}

	public function get_username( $user_id ) {
		$author_obj = get_user_by('id', $user_id);
		$username = $author_obj->user_login;
		return $username;
	}

	public function get_psw_reset_link( $user_id ) {
		$author_obj = get_user_by('id', $user_id);
		$psw_reset_link = get_password_reset_key($author_obj);
		return $psw_reset_link;
	}


	public function get_user_approve_link( $user_id ) {
		$code = md5(time());
		// make it into a code to send it to user via email
		$string = array('id'=>$user_id, 'code'=>$code);
		$my_account_page = wc_get_page_permalink( 'myaccount' );
		$link = $my_account_page. '/?approve=' .base64_encode( serialize($string));
		$link_button = '<a  target="blank" href="'.$link.'" >'.$link.'</a>';

		return $link_button;
	}

	public function get_user_confirmation_link( $user_id ) {
		$code = md5(time());
		// make it into a code to send it to user via email
		$string = array('id'=>$user_id, 'code'=>$code);
		$my_account_page = wc_get_page_permalink( 'myaccount' );
		$link = $my_account_page. '?con=' .base64_encode( serialize($string));
		$btn_txt = __('CONFIRM EMAIL ADDRESS', 'ultimate-auction-pro-software');
		$link_button = '<a  target="blank" href="'.$link.'" >'.$btn_txt.'</a>';
		return $link_button;
	}

	public function send_before() {
		add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
	}


	public function send_after() {
		remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );

		$this->heading = '';
	}

	}
endif;