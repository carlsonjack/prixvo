<?php

/**
 * Extra Functions file
 *
 * @package Ultimate Auction Pro Software - business- twilio sms
 * @author Nitesh Singh
 * @since 1.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}




	?>
 <div class="wrap welcome-wrap uat-admin-wrap">
	<ul class="subsubsub">
		<?php
			$sms_tabs = array(
				array(
					'slug' => 'sms_settings',
					'label' => __('Settings', 'ultimate-auction-pro-software')),
				array(
					'slug' => 'sms',
					'label' => __('SMS', 'ultimate-auction-pro-software')),
					array(
						'slug' => 'whatsapp',
						'label' => __('Whatsapp', 'ultimate-auction-pro-software')),
			);
			$link = isset($_GET['sms_type']) ? $_GET['sms_type'] : 'sms_settings';
		?>
			<?php foreach ($sms_tabs as $sms_tab) { ?>
				<li><a href="?page=ua-auctions-emails&uat-emails-tab=ua-auctions-tsms&sms_type=<?php echo $sms_tab['slug'];?>" class="<?php echo $link == $sms_tab['slug'] ? 'current' : '';?>"><?php echo $sms_tab['label'];?></a>|</li>
			<?php } ?>
	</ul>
</div>
						<?php
							if($link=='sms_settings'){
								include_once (UAT_THEME_PRO_ADMIN . 'notifications/tabs/settings.php');
							}
						?>
						<?php
							if($link=='sms'){
								include_once (UAT_THEME_PRO_ADMIN . 'notifications/tabs/sms.php');
							}
						?>
						<?php
							if($link=='whatsapp'){
								include_once (UAT_THEME_PRO_ADMIN . 'notifications/tabs/whatsapp.php');
							}
						?>


		<style>
.wrapper-tootltip {
							text-transform: uppercase;
							/* background: #ececec; */
							color: #555;
							cursor: help;
							font-size: 12px;
							padding: 11px 14px;
							position: relative;
							text-align: left;
							width: 10px;
							-webkit-transform: translateZ(0);
							/* webkit flicker fix */
							-webkit-font-smoothing: antialiased;
							/* webkit text rendering fix */
							width: 100%;
						}

						.wrapper-tootltip .tooltip {
							background: #1d2327;
							bottom: 100%;
							color: #fff;
							display: block;
							left: -15px;
							/* margin-bottom: 15px; */
							opacity: 0;
							padding: 8px 10px;
							pointer-events: none;
							position: absolute;
							width: auto;
							-webkit-transform: translateY(10px);
							-moz-transform: translateY(10px);
							-ms-transform: translateY(10px);
							-o-transform: translateY(10px);
							transform: translateY(10px);
							-webkit-transition: all .25s ease-out;
							-moz-transition: all .25s ease-out;
							-ms-transition: all .25s ease-out;
							-o-transition: all .25s ease-out;
							transition: all .25s ease-out;
							-webkit-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
							-moz-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
							-ms-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
							-o-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
							box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
						}

						/* This bridges the gap so you can mouse into the tooltip without it disappearing */
						.wrapper-tootltip .tooltip:before {
							bottom: -20px;
							content: " ";
							display: block;
							height: 20px;
							left: 0;
							position: absolute;
							width: 100%;
						}

						/* CSS Triangles - see Trevor's post */
						.wrapper-tootltip .tooltip:after {
							border-left: solid transparent 10px;
							border-right: solid transparent 10px;
							border-top: solid #1d2327 10px;
							bottom: -10px;
							content: " ";
							height: 0;
							left: 40px;
							margin-left: -13px;
							position: absolute;
							width: 0;
						}

						.wrapper-tootltip:hover .tooltip {
							opacity: 1;
							pointer-events: auto;
							-webkit-transform: translateY(0px);
							-moz-transform: translateY(0px);
							-ms-transform: translateY(0px);
							-o-transform: translateY(0px);
							transform: translateY(0px);
						}

						/* IE can just show/hide with no transition */
						.lte8 .wrapper-tootltip .tooltip {
							display: none;
						}

						.lte8 .wrapper-tootltip:hover .tooltip {
							display: block;
						}
			</style>

			<script>
				jQuery(document).ready(function($){
    var test_msg  = '<?php echo __('Please make sure you have entered a mobile phone number and test message.', "ultimate-auction-pro-software") ?>';
  /* start testing */
  jQuery('.uwt_twilio_sms_test_sms_button').on('click', function(event){
        var valid=1;
      var uwt_test_phone = jQuery('#uwt_twilio_sms_test_number').val();
      var uwt_test_message = jQuery('#uwt_twilio_sms_test_template').val();

          if (uwt_test_phone == "" || uwt_test_message == "" ) {
              valid=0;
              alert(test_msg);
          }

          if(valid==1)
          {
              jQuery.ajax({
                  type : "post",
                  url : '<?php echo admin_url('admin-ajax.php'); ?>',
                  data : {action: "uwt_twilio_send_test_sms", uwt_test_phone:uwt_test_phone,uwt_test_message:uwt_test_message, uat_nonce : '<?php echo wp_create_nonce('UtAajax-nonce'); ?>' },
                  success: function(response) {
                      var data = $.parseJSON( response );
                      alert(data.message);
                      window.location.reload();
                  }

              });

          }

      event.preventDefault();
  });
  jQuery('a.uwt_twilio_sms_test_whatsapp_button').on('click', function(event){
    var valid=1;
  var uwt_test_phone = jQuery('#uwt_twilio_sms_test_number').val();
  var uwt_test_message = jQuery('#uwt_twilio_sms_test_template').val();

      if (uwt_test_phone == "" || uwt_test_message == "" ) {
          valid=0;
          alert(test_msg);
      }

      if(valid==1)
      {
          
		  jQuery.ajax({
                  type : "post",
                  url : '<?php echo admin_url('admin-ajax.php'); ?>',
                  data : {action: "uwt_twilio_send_test_sms", from:"whatsapp:", uwt_test_phone:uwt_test_phone,uwt_test_message:uwt_test_message, uat_nonce : '<?php echo wp_create_nonce('UtAajax-nonce'); ?>' },
                  success: function(response) {
                      var data = $.parseJSON( response );
                      alert(data.message);
                      window.location.reload();
                  }

              });

      }

  event.preventDefault();
});

});
			</script>
