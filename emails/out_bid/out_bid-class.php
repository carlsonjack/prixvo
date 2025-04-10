<?php

/*
* OutBidMail class
*
* This class initiate general purpose custom fields.
*/
if (!defined('ABSPATH'))
{
    die('Access denied.');
}
if (!class_exists('OutBidMail')):
    class OutBidMail
    {

	private $from_address;
	private $from_name;
	private $content_type;
	private $headers;
	private $template;
	private $heading = '';
	private $mail_error ;
	/**
	 * OutBidMail constructor.
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


	public function get_content( $email_slug, $user_id="", $product_id="") {
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
					);

				} else{
					$email_data =  array('email_slug' => $email_slug);
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
		$link_button = $this->get_user_confirmation_link($user_id);
		$approve_link = $this->get_user_approve_link($user_id);
		//$psw_reset = $this->get_psw_reset_link($user_id);
		$string = str_replace( '{username}', $username, $string );
		$string = str_replace( '{event_name}', $event_name, $string );
		$string = str_replace( '{site_title}', $this->get_blogname(), $string );
		$string = str_replace( '{confirmation_link}', $link_button, $string );
		$string = str_replace( '{approve_link}', $approve_link, $string );
		$string = str_replace( '{bidder_name}', $username, $string );
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

    /*outbid*/

    public function outbid_email($product_id ,$user_id ) {
        $email_slug ="outbid";
        $email_object = get_option("uat_email_template_" . $email_slug);
        $enable = $email_object['enable'];
        if($enable =="yes" && !empty($user_id)){
			$uwt_email_outbid_user_enabled = get_user_meta($user_id,'uwt_email_outbid_user_enabled', true);
			if( $uwt_email_outbid_user_enabled == "no" )
			{
				return false;
			}
            $to = $this->get_user_email($user_id);
            $subject = $this->replacing_tempalte_tags_string_subject($email_object['subject'],$user_id,$product_id);
            $message = $this->get_content($email_slug, $user_id,$product_id );
            $sent = $this->mail_send( $to, $subject, $message);
			$check_email = new EmailTracking();
			$admin_email = get_option( 'admin_email' );
			$check_email->tracking_add($auction_id=$product_id ,$user_id=$user_id,$user_email=$admin_email,$receiver_email=$to,$admin_email=$admin_email?'1':'0',$email_type='outbid',$status=$sent,$subject=$subject,$headers=$this->get_headers(),$message=$message ,$amount='',$error=!$sent);

            return $sent;
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