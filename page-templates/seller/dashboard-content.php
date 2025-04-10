<div id="tab1" class="salse_tab-content">
    <div class="page-heading">
        <h1><?php echo __('Sales Overview', 'ultimate-auction-pro-software'); ?></h1>
    </div>
    <?php 
        $count = UAT_Sellers_Init::get_seller_products_count();
        $count_string = __('You have successfully submitted a total of %s auctions.', 'ultimate-auction-pro-software');
        $translated_string = sprintf($count_string, $count);
        echo $translated_string; 
    ?>
</div>