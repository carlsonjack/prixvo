<?php
if (!defined('ABSPATH')) {
	exit;
}
/**
 *
 * Auction Shortcodes
 *
 * @class  Uat_Events_Shortcode
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
class Uat_Events_Shortcode
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
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function __construct()
	{
		add_shortcode('ua_all_events', array($this, 'ua_all_events_fun'));
		add_shortcode('ua_live_events', array($this, 'ua_live_events_fun'));
		add_shortcode('ua_past_events', array($this, 'ua_past_events_fun'));
		add_shortcode('ua_future_events', array($this, 'ua_future_events_fun'));
	}
	/**
	 * All Events shortcode
	 * [ua_all_events]
	 *
	 * @param array $atts
	 *
	 * 1)per_page
	 * 2)orderby  == date / ID / title
	 * 3)order  == ASC/DESC
	 * 4)show_pagination  == Yes /No
	 * 5)selected_datetime == "today,2020-08-31"
	 */
	public function ua_all_events_fun($atts)
	{
		global $wpdb;
		extract(shortcode_atts(array(
			'per_page' 	=> '12',
			'orderby' => 'ID',
			'order' => 'DESC',
			'show_pagination' => 'No',
			'selected_datetime' => '',
			'timer' => 'false',
		), $atts));
		$event_status = "";
		$postin_array = array();
		$postids = uat_get_all_events_ids($event_status, $order, $orderby, $selected_datetime);
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => array('uat_event'),
			'post_status' => array('publish'),
			'ignore_sticky_posts' => 1,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => 'start_time_and_date',
			'posts_per_page' => $per_page,
			'paged' => $paged,
		);
		if (empty($postids)) {
			$postids[] = array();
		}
		$args['post__in'] = $postids;
		ob_start();
		$events = new WP_Query($args);
		$list_page_layout = get_option('options_uat_event_list_page_layout');
		$page_type = isset($list_page_layout) ? $list_page_layout : "full-width";
?>
		<script>
			var wpml_lang_code = "";
			<?php if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) { ?>
				wpml_lang_code = '<?php echo ICL_LANGUAGE_CODE; ?>';
			<?php } ?>
		</script>
		<?php if ($events->have_posts()) { ?>
			<div class="ua-product-list-sec <?php echo $page_type; ?>">
				<?php
				$default_view_set = get_option('options_uat_event_list_default_view', 'grid-view');
				$default_view = $default_view_set ? $default_view_set : "grid-view";
				?>
				<!--Event Grid List view Start-->
				<div class="ua-product-listing  prod <?php echo $default_view; ?>">
					<div class="product-list-columns EventSearch-results">
						<?php
						while ($events->have_posts()) : $events->the_post();
							set_query_var('show_timer', $timer);
							get_template_part('templates/events/uat', 'event-box');
						endwhile;
						?>
					</div>
					<?php
					if ($show_pagination == "Yes") {
						echo "<nav class='woocommerce-pagination'>";
						$big = 999999999;
						echo paginate_links(array(
							'base' => str_replace($big, '%#%', get_pagenum_link($big)),
							'format' => '?paged=%#%',
							'prev_text'    => '&larr;',
							'next_text'    => '&rarr;',
							'current' => max(1, get_query_var('paged')),
							'total' => $events->max_num_pages
						));
						echo '</nav>';
					}
					?>
				</div>
				<?php wp_reset_query(); ?>
			<?php
		} else {
			echo __("No Events were found matching your selection.", 'ultimate-auction-pro-software');
		} ?>
			</div>
		<?php
		return ' ' . ob_get_clean() . ' ';
	}
	/**
	 * Live Events shortcode
	 * [ua_live_events]
	 *
	 * @param array $atts
	 *
	 */
	public function ua_live_events_fun($atts)
	{
		global $wpdb;
		extract(shortcode_atts(array(
			'per_page' 	=> '12',
			'orderby' => 'ID',
			'order' => 'DESC',
			'show_pagination' => 'No',
			'selected_datetime' => '',
			'timer' => 'false',
		), $atts));
		$event_status = "uat_live";
		$postin_array = array();
		$postids = uat_get_all_events_ids($event_status, $order, $orderby, $selected_datetime);

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => array('uat_event'),
			'post_status' => array('publish'),
			'ignore_sticky_posts' => 1,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => 'start_time_and_date',
			'posts_per_page' => $per_page,
			'paged' => $paged,
		);
		if (empty($postids)) {
			$postids[] = array();
		}
		$args['post__in'] = $postids;
		ob_start();
		$events = new WP_Query($args);
		$list_page_layout = get_option('options_uat_event_list_page_layout');
		$page_type = isset($list_page_layout) ? $list_page_layout : "full-width";
		?>
			<div class="ua-product-list-sec <?php echo $page_type; ?>">
				<?php
				$default_view_set = get_option('options_uat_event_list_default_view', 'grid-view');
				$default_view = $default_view_set ? $default_view_set : "grid-view";
				if ($events->have_posts()) {
				?>

					<!--Event Grid List view Start-->
					<div class="ua-product-listing  prod <?php echo $default_view; ?>">
						<div class="product-list-columns EventSearch-results">
							<?php
							while ($events->have_posts()) : $events->the_post();
								set_query_var('show_timer', $timer);
								get_template_part('templates/events/uat', 'event-box');
							endwhile;
							?>
						</div>
						<?php
						if ($show_pagination == "Yes") {
							echo "<nav class='woocommerce-pagination'>";
							$big = 999999999;
							echo paginate_links(array(
								'base' => str_replace($big, '%#%', get_pagenum_link($big)),
								'format' => '?paged=%#%',
								'prev_text'    => '&larr;',
								'next_text'    => '&rarr;',
								'current' => max(1, get_query_var('paged')),
								'total' => $events->max_num_pages
							));
							echo '</nav>';
						}
						?>
					</div>
					<?php wp_reset_query(); ?>
				<?php
				} else {
					echo __("No Events were found matching your selection.", 'ultimate-auction-pro-software');
				} ?>
			</div>
		<?php
		return ' ' . ob_get_clean() . ' ';
	}
	/**
	 * Future Events shortcode
	 * [ua_future_events]
	 *
	 * @param array $atts
	 *
	 */
	public function ua_future_events_fun($atts)
	{
		global $wpdb;
		extract(shortcode_atts(array(
			'per_page' 	=> '12',
			'orderby' => 'ID',
			'order' => 'DESC',
			'show_pagination' => 'No',
			'selected_datetime' => '',
			'timer' => 'false',
		), $atts));
		$event_status = "uat_future";
		$postin_array = array();
		$postids = uat_get_all_events_ids($event_status, $order, $orderby, $selected_datetime);
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => array('uat_event'),
			'post_status' => array('publish'),
			'ignore_sticky_posts' => 1,
			'order' => $order,
			'orderby' => $orderby,
			'meta_key' => 'start_time_and_date',
			'posts_per_page' => $per_page,
			'paged' => $paged,
		);
		if (empty($postids)) {
			$postids[] = array();
		}
		$args['post__in'] = $postids;
		ob_start();
		$events = new WP_Query($args);
		$list_page_layout = get_option('options_uat_event_list_page_layout');
		$page_type = isset($list_page_layout) ? $list_page_layout : "full-width";
		?>
			<div class="ua-product-list-sec <?php echo $page_type; ?>">
				<?php if ($events->have_posts()) {
					$default_view_set = get_option('options_uat_event_list_default_view', 'grid-view');
					$default_view = $default_view_set ? $default_view_set : "grid-view";
				?>
					<!--Event Grid List view Start-->
					<div class="ua-product-listing  prod <?php echo $default_view; ?>">
						<div class="product-list-columns EventSearch-results">
							<?php
							while ($events->have_posts()) : $events->the_post();
								set_query_var('show_timer', $timer);
								get_template_part('templates/events/uat', 'event-box');
							endwhile;
							?>
						</div>
						<?php
						if ($show_pagination == "Yes") {
							echo "<nav class='woocommerce-pagination'>";
							$big = 999999999;
							echo paginate_links(array(
								'base' => str_replace($big, '%#%', get_pagenum_link($big)),
								'format' => '?paged=%#%',
								'prev_text'    => '&larr;',
								'next_text'    => '&rarr;',
								'current' => max(1, get_query_var('paged')),
								'total' => $events->max_num_pages
							));
							echo '</nav>';
						}
						?>
					</div>
					<?php wp_reset_query(); ?>
				<?php
				} else {
					echo __("No Events were found matching your selection.", 'ultimate-auction-pro-software');
				} ?>
			</div>
		<?php
		return ' ' . ob_get_clean() . ' ';
	}
	/**
	 * Past Events shortcode
	 * [ua_past_events]
	 *
	 * @param array $atts
	 *
	 */
	public function ua_past_events_fun($atts)
	{
		global $wpdb;
		extract(shortcode_atts(array(
			'per_page' 	=> '12',
			'orderby' => 'ID',
			'order' => 'DESC',
			'show_pagination' => 'No',
			'selected_datetime' => '',
		), $atts));
		$event_status = "uat_past";
		$postin_array = array();
		$postids = uat_get_all_events_ids($event_status, $order, $orderby, $selected_datetime);
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => array('uat_event'),
			'post_status' => array('publish'),
			'ignore_sticky_posts' => 1,
			'order' => $order,
			'orderby' => $orderby,
			'posts_per_page' => $per_page,
			'paged' => $paged,
		);
		if (empty($postids)) {
			$postids[] = array();
		}
		$args['post__in'] = $postids;
		ob_start();
		$events = new WP_Query($args);
		?>
			<?php if ($events->have_posts()) {
				$list_page_layout = get_option('options_uat_event_list_page_layout');
				$page_type = isset($list_page_layout) ? $list_page_layout : "full-width"; ?>
				<div class="ua-product-list-sec <?php echo $page_type; ?>">
					<?php
					$default_view_set = get_option('options_uat_event_list_default_view', 'grid-view');
					$default_view = $default_view_set ? $default_view_set : "grid-view";
					?>
					<!--Event Grid List view Start-->
					<div class="ua-product-listing  prod <?php echo $default_view; ?>">
						<div class="product-list-columns EventSearch-results">
							<?php
							while ($events->have_posts()) : $events->the_post();
								get_template_part('templates/events/uat', 'event-box');
							endwhile;
							?>
						</div>
						<?php
						if ($show_pagination == "Yes") {
							echo "<nav class='woocommerce-pagination'>";
							$big = 999999999;
							echo paginate_links(array(
								'base' => str_replace($big, '%#%', get_pagenum_link($big)),
								'format' => '?paged=%#%',
								'prev_text'    => '&larr;',
								'next_text'    => '&rarr;',
								'current' => max(1, get_query_var('paged')),
								'total' => $events->max_num_pages
							));
							echo '</nav>';
						}
						?>
					</div>
					<?php wp_reset_query(); ?>
				<?php
			} else {
				echo __("No Events were found matching your selection.", 'ultimate-auction-pro-software');
			} ?>
				</div>
		<?php
		return ' ' . ob_get_clean() . ' ';
	}
} /* end of class */
Uat_Events_Shortcode::get_instance();
