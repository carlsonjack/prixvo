<?php

            error_reporting(0);
		  $woo_acf_install = get_option('woo_acf_install');

		if(!empty($woo_acf_install) || $woo_acf_install==1){
			wp_safe_redirect( admin_url( 'index.php?page=uat_site_setup' ) );
			exit;
		}

		 if (isset($_POST['uat_install_btn'])) {

				if(empty($woo_acf_install) || $woo_acf_install!=1){
					add_plugin_init();
					update_option('woo_acf_install', "1");
					wp_safe_redirect( admin_url( 'index.php?page=uat_site_setup' ) );

					exit;
				}
           }

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
    p{font-size:14px;line-height:normal;font-family: 'Roboto', sans-serif;}
    sup{ font-size: 0.6em; }
    .header-logo img{width: 345px;max-width: 100%;}
    .header-logo{display: inline-block;width: 100%;margin: 55px auto 52px auto;text-align: center;}
    .box-main {
        width: 1130px;
    max-width: calc(100% - 40px);
    margin: 0 20px 20px 20px;
    box-shadow: 0 19px 38px rgb(0 0 0 / 5%), 0 15px 12px rgb(0 0 0 / 0%);
    padding: 15px 70px 35px 70px;
}
.row {
    display: flex !important;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.des-text p {
    font-size: 25px!important;
    line-height: 37px!important;
    font-family: 'Roboto', sans-serif;
    text-align: center;
    margin-bottom: 0;
}
.des-text {
    width: 890px;
    max-width: 100%;
    text-align: center;
    display: flex;
    justify-content: center;
    margin: 0 auto 40px auto;
}
.two-col-boxes {
    width: 670px;
    max-width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.boxes-link {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 58px;
}
.two-col-boxes .box {
    width: 310px;
    max-width: 100%;
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
    .des-text {
    margin: 0 auto 30px auto;
}
.des-text p {
    font-size: 20px!important;
    line-height: 28px!important;
}

.boxes-link{margin-bottom: 33px;}
.header-logo {
    margin: 25px auto 25px auto;
}
}
@media only screen and (max-width:767px){
.two-col-boxes .box {
    width: 290px;
}}
@media only screen and (max-width:600px){
    .header-logo img {
    width: 285px;
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
<body  >


<div class="container">
  <div class="row">
      <div class="header-logo">
           <img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/ultimate-aution-pro-software-logo.svg">
      </div>
     <div class="box-main">
        <div class="des-text">
            <p>Our theme is based on WooCommerce and uses following plugins to provide many auction related features to you.
Please make sure to install these plugins and also keep them updated from time to time.</p>
        </div>
        <div class="boxes-link">
            <div class="two-col-boxes">
                <div class="box">
                    <a href="#"></a>
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/woocomerce-img.jpg">
                    <a class="img-link" href="#">Woocomerce</a>
                </div>
                <div class="box">
                    <a href="#"></a>
                    <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/acf-img.jpg">
                    <a class="img-link" href="#">Advanced Custom Fields Pro</a>
                </div>
            </div>
        </div>
        <div class="install-click">
		<form method="post" action="" name="uat_install_frn_1">

			<input type="submit" name="uat_install_btn" id="uat_install_btn" class="Install-btn" value="Install Core Plugin"  />


		</form>

        </div>



     </div>
  </div>
</div>

</body>
</html>