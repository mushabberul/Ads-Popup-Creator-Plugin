<?php
/**
 * Plugin Name: Ads Popup Creator
 * Plugin URI:  https://example.com/plugins/the-basics/
 * Description: I am creating custom post.
 * Version:     1.0
 * Author:      Sabbir Mia
 * Author URI:  https://sabbirmia.com/
 * License:     GPL v2 or later
 * Text Domain: apc
 * Domain Path: /languages
 */
class Ads_Popup_Creator{
	function __construct(){
		add_action('plugins_loaded',[$this,'apc_loaded_textdomain']);
		add_action('init',[$this,'apc_register_image_size']);
		add_action('wp_enqueue_scripts',[$this,'load_assets']);
		add_action('wp_footer',[$this,'print_plainmodal_markup']);

		require( plugin_dir_path( __FILE__ ) . 'includes/metabox/ads-popup-metabox.php');
		require( plugin_dir_path( __FILE__ ) . 'includes/custom-post-type/ads-popup-cpt.php');
	}
	function apc_loaded_textdomain(){
		load_plugin_textdomain('apc',false,plugin_dir_url(__FILE__).'languages');
	}
	function apc_register_image_size(){
		add_image_size('landscape',800,600,true);
		add_image_size('square',500,500,true);
	}
	function load_assets(){
		wp_enqueue_style('modal-css',plugin_dir_url(__FILE__).'assets/public/css/modal.css');
		wp_enqueue_script('plainmodal-js',plugin_dir_url(__FILE__).'assets/public/js/plain-modal-min.js',array('jquery'),'1.0',true);
		wp_enqueue_script('ads-popup-main-js',plugin_dir_url(__FILE__).'assets/public/js/ads-popup-creator-main.js',array('jquery','plainmodal-js'),time(),true);
	}
	function print_plainmodal_markup(){
		$arguments = [
			'post_status' => 'publish',
    		'post_type'   => 'ads_popup',
			'meta_key'=>'apc_active',
			'meta_value'=>1
		];
		$query = new WP_Query($arguments);
		while($query->have_posts()){
			$query->the_post();
			$size = get_post_meta(get_the_ID(),'ads_popup_image',true);
			$delay = get_post_meta(get_the_ID(),'apc_second',true);
			$url = get_post_meta(get_the_ID(),'apc_link',true);
			if($delay > 0){
				$delay*=1000;
			}else{
				$delay = 0;
			}
			$image = get_the_post_thumbnail_url(get_the_ID(), $size);
			?>
			<div class="modal-content" data-delay="<?php echo esc_attr($delay); ?>">
			<div>
				<img class="close-button" src="<?php echo plugin_dir_url(__FILE__). "assets/public/img/close.png" ?>" width="30" alt="close">
			</div>
			<a href="<?php echo esc_url($url); ?>">
				<img src="<?php echo esc_url( $image) ?>" alt="Ads">
			</a>
		</div>
			<?php
		}
		wp_reset_query();
	}
}
new Ads_Popup_Creator();



