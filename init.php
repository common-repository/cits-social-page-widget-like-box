<?php 
/*
Plugin Name: CITS Social Page Widget
Plugin URI: https://coderitsolution.com
Author: Ashik
Author URI: https://ashik.me
Description: CITS Social Page Widget Plugin to display the page likes in sidebar widget. Display like button for the posts. All Options Available.
Tags: social page widget, cits social page widget.
Version: 2.2.0
Requires at least:5.0
Tested up to: 6.3
Requires PHP version: 7.0
License: GPL2
*/

class CITS_SOCIAL_PAGE_WIDGET{
	
	public function __construct(){
		add_action('widgets_init',array($this,'cits_social_page_widget')); 
		add_shortcode('cits_page_widget',array($this,'cits_page_widget_shortcode'));
	}

	
	public function cits_social_page_widget(){
		register_widget('CITS_SOCIAL_WIDGET');
	}

	// Social Page Widget  Shortcode
	public function cits_page_widget_shortcode($atts,$content){
		extract(shortcode_atts(array(
			'page_title' => 'coderitsolution',
			'page_url' => 'https://fb.com/coderitsolution',
			'type' => 'timeline',
			'width' => '300',
			'height' => '300',
			'cover' => 'false',
			'small_header' => 'false',
			'friends_face' => 'true'
		),$atts));
		ob_start();
		?>
		<div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v10.0" nonce="lghNRVEy"></script>
		<div class="fb-page" data-href="<?php echo $page_url; ?>" data-tabs="<?php echo $type; ?>" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>" data-adapt-container-width="true" data-hide-cover="<?php echo $cover; ?>" data-small-header="<?php echo $small_header; ?>"  data-show-facepile="<?php echo $friends_face; ?>"><blockquote cite="<?php echo $page_url; ?>" class="fb-xfbml-parse-ignore">
			<a href="<?php echo $page_url;?>"><?php echo $page_title; ?></a></blockquote></div>
		<?php 
		$output = ob_get_clean();
		return $output;
	}

}

new CITS_SOCIAL_PAGE_WIDGET();
 
class CITS_SOCIAL_WIDGET extends WP_Widget{

	public function __construct(){
		parent::__construct('cits_social_widget','CITS Social Page Widget',array(
			'description' => 'Social Page widget All options Available.'
		));
	}

	public function widget($args,$instance){
		$data = $args['before_widget'];
		$data .= $args['before_title'];
		$data .= isset($instance['title']) ? $instance['title'] : 'Coder IT Solution';
		// Options
		$page_title = isset($instance['page_title']) ? $instance['page_title'] : '';
		$page_url = isset($instance['page_url']) ? $instance['page_url'] : 'https://fb.com/coderitsolution';
		$page_width = isset($instance['page_width']) ? $instance['page_width'] : '300';
		$page_height = isset($instance['page_height']) ? $instance['page_height'] : '300';
		$tab_type = isset($instance['tab_types']) ? $instance['tab_types'] : 'timeline'; 
		$hide_cover = isset($instance['hide_cover']) ? 'true' : 'false';
		$small_header = isset($instance['small_header']) ? 'true' : 'false';
		$friends_face = isset($instance['friends_face']) ? 'true' : 'false';
		$data .= $args['after_title'];
		$data .= '<div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v10.0" nonce="lghNRVEy"></script>';

		$data .= '<div class="fb-page" data-href="'.$page_url.'" data-tabs="'.$tab_type.'" data-width="'.$page_width.'" data-height="'.$page_height.'" data-adapt-container-width="true" data-hide-cover="'.$hide_cover.'" data-small-header="'.$small_header.'"  data-show-facepile="'.$friends_face.'"><blockquote cite="'.$page_url.'" class="fb-xfbml-parse-ignore"><a href="'.$page_url.'">'.$page_title.'</a></blockquote></div>';

		$data .= $args['after_widget'];
		echo $data;
	}

	public function form($instance){
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php if(isset($instance['title'])){echo $instance['title'];} ?>" class="widefat">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('page_title'); ?>">Page Title:</label>
			<input type="text" name="<?php echo $this->get_field_name('page_title'); ?>" id="<?php echo $this->get_field_id('page_title'); ?>" value="<?php if(isset($instance['page_title'])){echo $instance['page_title'];} ?>" class="widefat">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('page_url'); ?>">Page URL:</label>
			<input type="url" name="<?php echo $this->get_field_name('page_url'); ?>" id="<?php echo $this->get_field_id('page_url'); ?>" value="<?php if(isset($instance['page_url'])){echo $instance['page_url'];}else{echo "https://fb.com/coderitsolution";} ?>" class="widefat">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('page_width'); ?>">Width:</label>
			<input type="number" name="<?php echo $this->get_field_name('page_width'); ?>" id="<?php echo $this->get_field_id('page_width'); ?>" value="<?php if(isset($instance['page_width'])){echo $instance['page_width'];}else{echo "300";} ?>" class="widefat">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('page_height'); ?>">Height:</label>
			<input type="number" name="<?php echo $this->get_field_name('page_height'); ?>" id="<?php echo $this->get_field_id('page_height'); ?>" value="<?php if(isset($instance['page_height'])){echo $instance['page_height'];}else{echo "300";} ?>" class="widefat">
		</p>
 
		<p>
			<label for="<?php echo $this->get_field_id('tab_types'); ?>">Select Type:</label>
			<select class="widefat" name="<?php echo $this->get_field_name('tab_types'); ?>" id="<?php echo $this->get_field_id('tab_types'); ?>">
				<?php if(isset($instance['tab_types'])) : ?>
				<option value="<?php echo $instance['tab_types']; ?>"><?php 
				if($instance['tab_types'] == 'timeline'){
					echo "Timeline";
				}else if($instance['tab_types'] == 'message'){
					echo "Message";
				}else if($instance['tab_types'] == 'events'){
					echo "Events";
				} 
				?></option>
				<?php endif; ?> 
				<option value="timeline">Timeline</option>
				<option value="message">Message</option>
				<option value="events">Events</option>
			</select>
		</p>
		<p>
			<input value="1" type="checkbox" name="<?php echo $this->get_field_name('hide_cover'); ?>" class="checkbox" id="<?php echo $this->get_field_id('hide_cover'); ?>" <?php if(isset($instance['hide_cover'])){
				if($instance['hide_cover'] == 1){
					echo "checked";
				}
			} ?> >
			<label for="<?php echo $this->get_field_id('hide_cover'); ?>">Hide Cover Photo</label>
		</p>
		<p>
			<input value="1" type="checkbox" name="<?php echo $this->get_field_name('small_header'); ?>" class="checkbox" id="<?php echo $this->get_field_id('small_header'); ?>" <?php if(isset($instance['small_header'])){
				if($instance['small_header'] == 1){
					echo "checked";
				}
			} ?> >
			<label for="<?php echo $this->get_field_id('small_header'); ?>">Use Small Header</label>
		</p>

		<p>
			<input value="1" type="checkbox" name="<?php echo $this->get_field_name('friends_face'); ?>" class="checkbox" id="<?php echo $this->get_field_id('friends_face'); ?>" <?php if(isset($instance['friends_face'])){
				if($instance['friends_face'] == 1){
					echo "checked";
				}
			} ?> >
			<label for="<?php echo $this->get_field_id('friends_face'); ?>">Show Friend's Faces</label>
		</p>
		<?php 

	}

}
 
 ?>