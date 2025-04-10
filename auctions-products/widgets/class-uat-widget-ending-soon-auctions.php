<?php

if (!defined('ABSPATH')) {
	exit;
}


/**
 * Ending Soon Auctions Widget
 *
 * @class UWA_Widget_Ending_Soon_Auctions
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 * @category Widgets
 *
 */
class UAT_Widget_Ending_Soon_Auctions extends WP_Widget
{

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		$this->widget_cssclass    = 'woocommerce widget_uat_ending_soon_auctions';
		$this->widget_description = __(
			'Display a list of Ending Soon Auctions from your store',
			'ultimate-auction-pro-software'
		);
		$this->widget_id          = 'woocommerce_ua_ua_ending_soon_auctions';
		$this->widget_name        = __('UA Ending Soon Auctions', 'ultimate-auction-pro-software');

		/* Widget settings. */
		$uat_widget_arg = array('classname' => $this->widget_cssclass, 'description' => $this->widget_description);
		parent::__construct('uat_ending_soon_auctions', $this->widget_name, $uat_widget_arg);

		add_action('save_post', array($this, 'flush_widget_cache'));
		add_action('deleted_post', array($this, 'flush_widget_cache'));
		add_action('switch_theme', array($this, 'flush_widget_cache'));
	}

	/**
	 * Flush the widget cache
	 *
	 */
	function flush_widget_cache()
	{
		wp_cache_delete('widget_uat_ending_soon_auctions', 'widget');
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 *
	 */
	function widget($args, $instance)
	{
		global $woocommerce;

		$cache = wp_cache_get('widget_uat_ending_soon_auctions', 'widget');

		if (!is_array($cache)) $cache = array();

		if (isset($cache[$args['widget_id']])) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Ending Soon Auctions', 'ultimate-auction-pro-software') : $instance['title'], $instance, $this->id_base);
		if (!$number = (int) $instance['number'])
			$number = 10;
		else if ($number < 1)
			$number = 1;
		else if ($number > 10)
			$number = 10;
		$postin_array = array();
		$postids = uat_get_ending_soon_auctions_ids($instance['days_left']);
		// $postids  = uat_get_live_auctions_ids();
		if (empty($postids)) {
			$postids[] = array();
		}
		$query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product');
		$query_args['meta_query'] = array();
		$query_args['meta_query'][]    = $woocommerce->query->stock_status_meta_query();
		$query_args['meta_query'][] = array('key' => 'woo_ua_auction_closed', 'compare' => 'NOT EXISTS');
		$query_args['meta_query'][] = array('key' => 'woo_ua_auction_started', 'compare' => 'NOT EXISTS');
		$query_args['meta_query']      = array_filter($query_args['meta_query']);
		$query_args['tax_query']       = array(array('taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'auction'));
		$query_args['auction_arhive']  = TRUE;
		$query_args['orderby']  = 'meta_value';
		$query_args['order']    = 'ASC';
		$query_args['post__in'] = $postids;
		$uat_query = new WP_Query($query_args);
		global $wpdb;
		echo $before_widget;
		if ($title)
			echo $before_title . $title . $after_title;

		echo '<ul class="product_list_widget">';
		if ($uat_query->have_posts()) {
			$uat_hide_time = empty($instance['uat_hide_time']) ? 0 : 1;
			while ($uat_query->have_posts()) {
				$uat_query->the_post();
				global $product;
				$remaning_time = $product->get_uwa_remaining_seconds();
				$product_id = $product->get_id();
				$auction_image = (has_post_thumbnail() ? get_the_post_thumbnail(
					$uat_query->post->ID,
					'shop_thumbnail'
				) : wc_placeholder_img('shop_thumbnail'));
				$uwa_time_zone =  (array)wp_timezone();
?>
				<li>


					<div class="ua-wid-design">
						<a href="<?php echo get_permalink(); ?>">
							<div class="ua-wid-img"><?php echo $auction_image; ?>
								<button href="#" class="place-bid-btn">
									<?php _e('PLACE BID', 'ultimate-auction-pro-software'); ?>
								</button>
							</div>
							<div class="ua-wid-discription">
								<div class="ua-wid-pro-t">
									<div class="ua-wid-head"><?php echo get_the_title(); ?></div>
									<div class="bid-start-with-time">
										<?php echo $product->get_price_html(); ?>
										<!-- <span class="uat_time_left"><?php _e('Time left', 'ultimate-auction-pro-software'); ?></span> -->
									</div>
								</div>
								<div class="ua-wid-timer">
									<?php if ($uat_hide_time == 1) {
									$auc_end_date=get_post_meta( $product_id, 'woo_ua_auction_end_date', true );
									$rem_arr=get_remaining_time_by_timezone($auc_end_date);
									?>
										
									<?php
										countdown_clock(
											$end_date=$auc_end_date,
											$item_id=$product_id,
											$item_class='uwa-main-auction-product-loop  time-countdown auction-countdown-check',   
										);					
									?>
									<?php } ?>
								</div>
							</div>
						</a>
					</div>
				</li>
			<?php }
		} else { ?>
			<li><?php _e('Ending Soon Auction not found', 'ultimate-auction-pro-software'); ?></li>

		<?php }
		echo '</ul>';
		echo $after_widget;
		wp_reset_postdata();
		$content = ob_get_clean();
		if (isset($args['widget_id'])) $cache[$args['widget_id']] = $content;
		echo $content;
		wp_cache_set('widget_uat_ending_soon_auctions', $cache, 'widget');
	}

	/**
	 * Update function
	 *
	 * @see WP_Widget->update
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 *
	 */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['days_left'] = (int) $new_instance['days_left'];
		$instance['uat_hide_time'] = empty($new_instance['uat_hide_time']) ? 0 : 1;
		$this->flush_widget_cache();
		$alloptions = wp_cache_get('alloptions', 'options');
		if (isset($alloptions['widget_uat_ending_soon_auctions']))
			delete_option('widget_uat_ending_soon_auctions');

		return $instance;
	}

	/**
	 * Form function
	 *
	 * @see WP_Widget->form
	 * @param array $instance
	 *
	 */
	function form($instance)
	{
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		if (!isset($instance['number']) || !$number = (int) $instance['number'])
			$number = 5;
		if (!isset($instance['days_left']) || !$days_left = (int) $instance['days_left'])
			$days_left = 12;
		$uat_hide_time = empty($instance['uat_hide_time']) ? 0 : 1;
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ultimate-auction-pro-software'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('days_left'); ?>"><?php _e('How many days left:', 'ultimate-auction-pro-software'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('days_left')); ?>" name="<?php echo esc_attr($this->get_field_name('days_left')); ?>" type="text" value="<?php echo esc_attr($days_left); ?>" size="3" />
		</p>
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('How many to show:', 'ultimate-auction-pro-software'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" />
		</p>
		<p><input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('uat_hide_time')); ?>" name="<?php echo esc_attr($this->get_field_name('uat_hide_time')); ?>" <?php checked($uat_hide_time); ?> />
			<label for="<?php echo $this->get_field_id('uat_hide_time'); ?>"><?php _e('Show Timer', 'ultimate-auction-pro-software'); ?></label>
		</p>
<?php
	}
}
