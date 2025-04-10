<?php

	 error_reporting(0);

?>
<!DOCTYPE html>
<html>
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap');
       *{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;box-sizing:border-box;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale; }
        body{font-size:14px; line-height:24px; color:#000!important;margin:0!important; padding:0!important;font-family: 'Roboto', sans-serif!important;background-color: #fff!important;border: inherit!important;max-width: 100%!important;min-height: 100vh;}
        a{ text-decoration:none;transition-duration: 0.5s;-moz-transition-duration: 0.5s;-ms-transition-duration: 0.5s;transition-duration: 0.5s;font-family: 'Roboto', sans-serif;}
        img{ max-width:100%; display: inline-block; vertical-align: top; border: 0; outline: none;}
        p{margin:0;font-family: 'Roboto', sans-serif;}
        sup{ font-size: 0.6em; }
        .header-logo img{width: 345px;max-width: 100%;}
        .header-logo{display: inline-block;width: 100%;margin: 55px auto 52px auto;text-align: center;}
        .box-main {
            width: 1130px;
        max-width: calc(100% - 40px);
        margin: 0 20px 20px 20px;
        box-shadow: 0 19px 38px rgb(0 0 0 / 5%), 0 15px 12px rgb(0 0 0 / 0%);
        padding: 35px 70px 35px 70px;
    }
    table{
    background: #fff;
    border: 1px solid #c3c4c7;
    box-shadow: 0 1px 1px rgb(0 0 0 / 4%);
    color: #000;
    border-spacing: 0;
    width: 100%;
    max-width: 100%;
    clear: both;
    margin: 0 0 50px 0;
    }
    .activate a {
    color: #2271b1;
}
    .plugins tr {
    background: #fff;
}
table td strong {
    font-weight: 500;
}

table td{

    box-shadow: inset 0 -1px 0 rgb(0 0 0 / 10%);
    background-color: #f0f6fc;
    padding: 10px 9px 15px 9px;
    color: #000;
    font-size: 13px;
    line-height: 1.5em;
    vertical-align: top;


}
span {
    display: block;
}
th {
    color: #2c3338;
    font-weight: 400;
    text-align: left;
    line-height: 1.3em;
    font-size: 14px;
    padding: 8px 10px;
    border-bottom: 1px solid #c3c4c7;
    border-spacing: 0;
    clear: both;
    margin: 0;
}
    .row {
        display: flex !important;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    a.img-link {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 19px 38px rgb(0 0 0 / 5%), 0 15px 12px rgb(0 0 0 / 0%);
        color: #000;
        padding: 12px;
        font-weight: 500;
        letter-spacing: 0.5px;
        font-size: 19px;
    }
    .Install-btn:hover{
        background-color: #fff;
        color: #000;
        border: 2px solid #000;
    }
    .Install-btn {
        background-color: #000;
        color: #fff;
        padding: 13px 17px;
        font-size: 18px;
        letter-spacing: 0.5px;
        border: 2px solid #000;
        margin: 0 10px;
    }
    .install-click{display: flex;align-items: center;justify-content: center;}
    .install-click-msg {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #35b72d;
        border: 2px solid #35b72d;
        padding: 7px 20px;
        width: 360px;
        max-width: 100%;
        margin: 10px auto;
    }

    @media only screen and (max-width:1023px){
        .box-main{padding: 20px;}



    .boxes-link{margin-bottom: 33px;}
    .header-logo {
        margin: 25px auto 25px auto;
    }
    }
    @media only screen and (max-width:767px){
     table td:first-child {
    box-shadow: none;
    padding-bottom: 0;
}
    thead tr th:last-child {
    display: none;
    }
    table tbody tr {
    display: flex;
    flex-direction: column;
}
}
    @media only screen and (max-width:600px){
        .header-logo img {
        width: 285px;
    }
    .install-click {
    flex-direction: column;
}
.Install-btn{
    margin-bottom: 20px;
}
        .two-col-boxes{flex-direction: column;}
        .two-col-boxes .box {
        margin-bottom: 20px;
    }
    .Install-btn {
        padding: 10px 12px;
        font-size: 17px;
    }
    .install-click-msg{
        font-size: 15px;
        padding: 7px 11px;
        width: 300px;
    }
    }

      </style>
<script>
$(document).ready(function(){
  $("button").click(function(){
    $("p").hide();
  });
  $(".wp-die-message").remove();

});
</script>


</head>
<body class="wcfm-setup wp-core-ui">

<?php
$Version_woo="";
$Description_woo="";
$AuthorName_woo="";

$Version_acf="";
$Description_acf="";
$AuthorName_acf="";
if ( is_admin() ) {
    if( ! function_exists('get_plugin_data') ){
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
	$plugin_dir = WP_PLUGIN_DIR  .'';
	$dirnm = scandir($plugin_dir);
	$plugin_data = get_plugin_data( $plugin_dir.'/woocommerce/woocommerce.php' );
	$Version_woo=$plugin_data['Version'];
	$Description_woo=$plugin_data['Description'];
	$AuthorName_woo=$plugin_data['AuthorName'];


	$plugin_data2 = get_plugin_data( $plugin_dir.'/advanced-custom-fields-pro/acf.php' );
	$Version_acf=$plugin_data2['Version'];
	$Description_acf=$plugin_data2['Description'];
	$AuthorName_acf=$plugin_data2['AuthorName'];



}



?>

<div class="container">
  <div class="row">
      <div class="header-logo">
          <img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/ultimate-aution-pro-software-logo.svg">
      </div>
     <div class="box-main">
        <div class="responsive-table">
            <table>
                <thead>
                <tr>
                    <th>Plugin</th>
                    <th>Description</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>
                        <strong>Advanced Custom Fields PRO</strong>
                        <span class="activate"><a href="">Activated</a></span>
                    </td>
                    <td>
                        <span class="p-description"><?php echo $Description_acf; ?></span>
                        <span class="verson">Version <?php echo $Version_acf; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>WooCommerce</strong>
                        <span class="activate"><a href="">Activated</a></span>
                    </td>
                    <td>
                        <span class="p-description"><?php echo $Description_woo; ?></span>
                        <span class="verson">Version <?php echo $Version_woo; ?> </span>
                    </td>
                </tr>
            </tbody>
            </table>


        </div>
		<div id="data_result">

		</div>
        <div class="install-click">

		<?php
		 $woo_acf_lets_go = get_option('woo_acf_lets_go');

		if(!empty($woo_acf_lets_go) || $woo_acf_lets_go==1){

			?>
			<a class="Install-btn" href="<?php echo admin_url( 'admin.php?page=ua-auctions-theme-options' ); ?>">Lets Go</a>

			<?php

			} else{ ?>
			<a class="Install-btn seeletsgo" style="display:none" href="<?php echo admin_url( 'admin.php?page=ua-auctions-theme-options' ); ?>">Lets Go</a>
			<button type="button"   class="Install-btn alldone" onclick="import_demo_data();">Import Demo Data</button>
            <a class="Install-btn alldone" href="<?php echo admin_url( 'admin.php?page=ua-auctions-theme-options' ); ?>">Skip this step</a>

		  <?php } ?>



        </div>


     </div>
  </div>
</div>
	<script type="text/javascript">

function import_demo_data(){


	 jQuery.ajax({
		url:'<?php echo site_url(); ?>/wp-admin/admin-ajax.php' ,
		type: "post",
		data: {
			action: 'fun_import_demo_data_ajax',
			setp: '1',


		 },
		beforeSend: function() {

			jQuery('#data_result').html('Loading...');
		},
		success: function(data){
			jQuery("#data_result").html(data);
			jQuery(".alldone").hide();
			jQuery(".seeletsgo").show();




		 },
		error:function(){
			 console.log('failure!');

		}

	 });

}
</script>

</body>
</html>