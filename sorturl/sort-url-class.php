<?php

class Url_Shortener
{
    private static $instance;
    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     *
     */
    public static function get_instance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct(){
        add_action('wp', array( $this,  'ultimate_auction_pro_admin_url_sort' ));
		add_action('woocommerce_update_product', array($this, 'auction_products_type_save_post_sort_uirl'), 10, 1);

    }
    public function ultimate_auction_pro_admin_url_sort(){
        if( isset($_GET['uaturl']) )
        {
            $uatsorturl = $_GET['uaturl'];
                global $wpdb, $woocommerce, $product, $post;
                $products = wc_get_products( array(
                    'limit'         => -1,
                    'status'        => 'publish',
                    'meta_key'      => 'uat_sort_link',
                    'meta_value'      => $uatsorturl,
                    'meta_compare'  => 'EXISTS',
                ) );
                if(count($products) > 0)
                {
                    foreach( $products as $product ) {
                        $product_url = $product->get_permalink();
                        header('Location: '.$product_url);
                        // echo $product_url;
                    }
                }
        }
    }
    public function checkCodeValid($code){
        global $wpdb, $woocommerce, $product, $post;
        $products = wc_get_products( array(
            'limit'         => -1,
            'status'        => 'publish',
            'meta_key'      => 'uat_sort_link',
            'meta_value'      => $code,
            'meta_compare'  => 'EXISTS',
        ) );
        if(count($products) > 0)
        {
            return false;
        }
        return true;
    }
    public function auction_products_type_save_post_sort_uirl($post_id)
    {
        global $wpdb;
        $product = wc_get_product($post_id);
        $permalink = $product->get_permalink();
        $createRandomString = $this->createRandomString();

        $urlcheck = get_post_meta($post_id, 'uat_sort_link', true);
        if( $urlcheck == "" ){
            update_post_meta( $post_id, 'uat_sort_link', $createRandomString );
        }
    }
    public function createRandomString() {

        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;

        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        if( $this->checkCodeValid($pass) )
        {
            return $pass;
        }
        $this->createRandomString();

    }
}
Url_Shortener::get_instance();
