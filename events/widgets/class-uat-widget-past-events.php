<?php

if (!defined('ABSPATH')) {
	exit;
}


/**
 * Past Events Widget
 *
 * @class UWA_Widget_Past_Events
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 * @category Widgets
 *
 */
class UAT_Widget_Past_Events extends WP_Widget
{

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->widget_cssclass    = 'woocommerce widget_uat_past_events';
		$this->widget_description = __('Display a list of Past Auction Events from your store.', 'ultimate-auction-pro-software');
		$this->widget_id          = 'woocommerce_ua_past_events';
		$this->widget_name        = __('UA Past Auction Events', 'ultimate-auction-pro-software');
		/* Widget settings. */
		$uat_widget_arg = array('classname' => $this->widget_cssclass, 'description' => $this->widget_description);
		parent::__construct('uat_past_events', $this->widget_name, $uat_widget_arg);
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
		wp_cache_delete('widget_uat_past_events', 'widget');
	}

	/**
	 * Output widget
	 *
	 * @see WP_Widget
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance
	 *
	 */
	function widget($args, $instance)
	{
		global $woocommerce;

		$cache = wp_cache_get('widget_uat_past_events', 'widget');
		if (!is_array($cache)) $cache = array();
		if (isset($cache[$args['widget_id']])) {
			echo $cache[$args['widget_id']];
			return;
		}
		ob_start();
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Past Auction Events', 'ultimate-auction-pro-software') : $instance['title'], $instance, $this->id_base);
		if (!$number = (int) $instance['number'])
			$number = 10;
		else if ($number < 1)
			$number = 1;
		else if ($number > 10)
			$number = 10;
		$postin_array = array();
		$postids  = uat_get_expired_events_ids();
		if (empty($postids)) {
			$postids[] = array();
		}
		$query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'uat_event');
		$query_args['meta_key'] = 'start_time_and_date';
		$query_args['orderby']  = 'meta_value';
		$query_args['order']    = 'ASC';
		$query_args['post__in'] = $postids;
		$uat_query = new WP_Query($query_args);
		echo $before_widget;
		if ($title)
			echo $before_title . $title . $after_title;

		echo '<ul class="product_list_widget events_list_widget">';
		if ($uat_query->have_posts()) {
			$uat_hide_time = empty($instance['uat_hide_time']) ? 0 : 1;
			while ($uat_query->have_posts()) {
				$uat_query->the_post();
				$event_id =  get_the_ID();
				$featured_img_url = get_the_post_thumbnail_url($event_id, 'event-widget-thumb');
				if (empty($featured_img_url)) {
					$featured_img_url = wc_placeholder_img_src();
				}
?>
				<li>
					<div class="ua-wid-design">
						<a href="<?php echo get_permalink(); ?>">
							<div class="ua-wid-img"><img src="<?php echo $featured_img_url; ?>"></div>
							<div class="ua-wid-discription">
								<div class="ua-wid-pro-t">
									<div class="ua-wid-head"><?php echo get_the_title(); ?></div>
								</div>
							</div>
						</a>
					</div>
				</li>
			<?php }
		} else { ?>
			<li><?php _e('Past Auction events not found', 'ultimate-auction-pro-software'); ?></li>
		<?php }
		echo '</ul>';
		echo $after_widget;
		wp_reset_postdata();
		$content = ob_get_clean();
		if (isset($args['widget_id'])) $cache[$args['widget_id']] = $content;
		echo $content;
		wp_cache_set('widget_uat_past_events', $cache, 'widget');
	}

	/**
	 * Update function
	 *
	 * @see WP_Widget->update
	 * @access public
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
		$this->flush_widget_cache();

		$alloptions = wp_cache_get('alloptions', 'options');
		if (isset($alloptions['widget_uat_past_events'])) delete_option('widget_uat_past_events');

		return $instance;
	}

	/**
	 * Form function
	 *
	 * @see WP_Widget->form
	 * @access public
	 * @param array $instance
	 * @return void
	 *
	 */
	function form($instance)
	{
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		if (!isset($instance['number']) || !$number = (int) $instance['number'])
			$number = 5;
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ultimate-auction-pro-software'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('How many to show:', 'ultimate-auction-pro-software'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" />
		</p>
<?php
	}
}
