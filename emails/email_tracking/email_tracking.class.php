<?php
/*
use this slug in email type
1. place_bid
2. registration_confirm
3. registration_approved_admin
4. registration_approved
5. registration_reject
6. outbid
7. password_reset
8. won_bid
9. loose_bid
10. ending_soon
11. payment_reminder
*/

if (!class_exists('EmailTracking')):
class EmailTracking
{



	public function duplicate_email_check($auction_id ,$user_id,$email_type,$amount=""){
		global $wpdb;
		if($email_type=='order_payment_reminder'){
			$query   ="SELECT * FROM `".$wpdb->prefix."ua_auction_email` where auction_id=".$auction_id." and user_id=".$user_id." and  email_type='".$email_type;
			$results = $wpdb->get_results( $query );
			if(count($results)>0){
				return true;
			}else{
				return false;
			}
		}
		if($email_type=='place_bid'){

			$query   ="SELECT * FROM `".$wpdb->prefix."ua_auction_email` where auction_id=".$auction_id." and user_id=".$user_id." and  email_type='".$email_type."' and amount=".$amount;
			$results = $wpdb->get_results( $query );
			if(count($results)>0){
				return true;
			}else{
				return false;
			}

		}
		else{
			$query   ="SELECT * FROM `".$wpdb->prefix."ua_auction_email` where auction_id=".$auction_id." and user_id=".$user_id." and  email_type='".$email_type."' ";
			if(!empty($amount))
			{
				$query = $query. "and amount=".$amount;
			}
			$results = $wpdb->get_results( $query );
			if(count($results)>0){
				return true;
			}else{
				return false;
			}
		}


	}

	public function tracking_add($auction_id ,$user_id,$user_email,$receiver_email,$admin_email,$email_type,$status,$subject,$headers,$message ,$amount,$error) {
		global $wpdb;
		$mail_fild['auction_id'] = $auction_id;
		$mail_fild['user_id'] = $user_id;
		$mail_fild['user_email'] = $user_email;
		$mail_fild['receiver_email'] = $receiver_email;
		$mail_fild['admin_email'] = $admin_email;
		$mail_fild['email_type'] = $email_type;
		$mail_fild['status'] = $status;
		$mail_fild['subject'] = $subject;
		$mail_fild['headers'] = $headers;
		$mail_fild['message'] = $message;
		$mail_fild['amount'] = $amount;
		$mail_fild['error'] = $error;

		return $wpdb->insert($wpdb->prefix.'ua_auction_email',$mail_fild);
	}
}
endif;