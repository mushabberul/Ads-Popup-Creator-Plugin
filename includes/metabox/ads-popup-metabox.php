<?php
class Ads_Popur_Creator_Metabox{
	function __construct(){
		add_action('add_meta_boxes',[$this,'apc_metabox']);
		add_action('save_post',[$this,'apc_metabox_save']);
	}
	private function is_metabox_secure($nonce_field,$nonce_action,$post_id){

		$nonce = isset($_POST[$nonce_field]) ? $_POST[$nonce_field] : '';
		if($nonce == ''){
			return false;
		}
		if( !wp_verify_nonce($nonce,$nonce_action)){
			return  false;
		}
		if(! current_user_can('edit_post',$post_id)){
			return false;
		}
		if( wp_is_post_autosave($post_id)){
			return false;
		}

		return true;
	}
	function apc_metabox(){
		add_meta_box('apc_metabox_id',
		__('Enter your info','apc'),
		[$this,'apc_metabox_callback'],
		'ads_popup');
	}
	function apc_metabox_callback($post){
		wp_nonce_field('apc_nonce_action','apc_nonce_field');
		$second = get_post_meta($post->ID,'apc_second',true);
		$link = get_post_meta($post->ID,'apc_link',true);

		$active = get_post_meta($post->ID,'apc_active',true);
		$active_Checked = $active == 1 ? 'checked' : '';

		$popup_sizes = ['square','landscape','full'];
		$popup_image_size = get_post_meta($post->ID,'ads_popup_image',true);

		?>
		<div>
			<label for="apc_active">Active</label>
			<input type="checkbox" name="apc_active" id="apc_active" value="<?php echo $active; ?>" <?php echo $active_Checked; ?>>
		</div>
		<div>
			<p><strong>How much time will delay popup after page load.</strong></p>
			<input placeholder="Set Seconds" type="text" name="apc_second" id="apc_second" value="<?php echo $second ?>">
		</div>
		<div>
			<p><strong>Enter your link.</strong></p>
			<input placeholder="http://sabbirmia.com" type="text" name="apc_link" id="apc_link" value="<?php echo $link ?>">
		</div>
		<div>
			<p><strong>Select your popup size.</strong></p>
			<select name="ads_popup_image" id="ads_popup_image">
				<option>Select Image Size</option>
				<?php
					foreach($popup_sizes as $popup_size){
						$popup_image_size_selected = ($popup_image_size == $popup_size) ? 'selected' : '';
						printf("<option %s value='%s'>%s</option>",$popup_image_size_selected,$popup_size,ucwords($popup_size));
					}
				?>
			</select>
		</div>

		<?php
	}
	function apc_metabox_save($post_id){
		if(! $this->is_metabox_secure('apc_nonce_field','apc_nonce_action',$post_id)){
			return $post_id;
		}
		$second = isset($_POST['apc_second']) ? $_POST['apc_second'] : '';
		$second = sanitize_text_field($second);

		$link = isset($_POST['apc_link']) ? $_POST['apc_link'] : '';
		$link = sanitize_text_field($link);

		$active = isset($_POST['apc_active']) ? 1 : 0;

		$ads_popup_image = isset($_POST['ads_popup_image']) ? $_POST['ads_popup_image'] : '';

		update_post_meta($post_id,'apc_second',$second);
		update_post_meta($post_id,'apc_link',$link);
		update_post_meta($post_id,'ads_popup_image',$ads_popup_image);
		update_post_meta($post_id,'apc_active',$active);
	}
}
new Ads_Popur_Creator_Metabox();
