<?php
/*
 * controlls the admin panel
 * */

class WpNectarController{

	/*
	 * contains action/filter hooks
	 * */
	static function init(){
		register_activation_hook(NECTAR_FILE, array(get_class(), 'activate_the_plugin'));
		
		//add_action('blog_privacy_selector', array(get_class(), 'blog_privacy_selector'));
		add_action('admin_menu', array(get_class(), 'admin_menu'), 1000);
		
		
		//dashboard only for admin
		add_action('wp_dashboard_setup', array(get_class(), 'add_dashboard_widget'));
		
	}
	
	
	/*
	 * add a dashbaord widget 
	 * */
	static function add_dashboard_widget(){
		if(current_user_can('manage_options')){
			wp_add_dashboard_widget('nice_dashboard_filtering', 'Nice Dashboard', array(get_class(), 'nice_dashboard_widget'), array(get_class(), 'nice_dashboard_configure'));
		}
	}
	
	
	/*
	 * widget content
	 * */
	static function nice_dashboard_widget(){		
		include self::load_file('templates/admin/nice-dashboard.php');
	}
	
	
	/*
	 * configure nicd dashboard
	 * */
	static function nice_dashboard_configure(){
		include self::load_file('templates/admin/nice-dashboard-configure.php');
	}
	
	
	static function blog_privacy_selector(){
		var_dump(get_option('blog_public'));
	}
	
	/*
	 * Uncheck the "Discourage search engines from indexing this site" box from within Settings > Reading ?
	 * Uncheck the following three boxes from Settings > Discussion, "Allow people to post comments on new articles" 
	 * and "Email me whenever Anyone posts a comment" and "Email me whenever A comment is held for moderation"
	 * */
	static function activate_the_plugin(){
		// (wp-admin/options-reading.php)
		update_option('blog_public', '1');
		
		// (wp-admin/options-discussion.php)
		update_option('default_comment_status', 'closed');
		update_option('comments_notify', '0');
		update_option('moderation_notify', '0');		
	}
	
	
	//admin page to handle the options
	static function admin_menu(){
		add_options_page('Wordpress Nicer Dashboard', 'Nectar', 'manage_options', 'wpnicerdashboard', array(get_class(), 'options_page_content'));	
	}

	
	//options page content
	static function options_page_content(){
		include self::load_file('templates/admin/options-page.php');
	}
	
	
	//get the file diercotyr
	static function load_file($file = ''){
		return NECTAR_DIR . '/' . $file;
	}
	
	
	//tab selector
	static function get_appropriate_tab(){
		if(isset($_GET['tab'])){
			return self::load_file('templates/admin/tabs/tab_' . $_GET['tab'] . '.php');
		}
		else{
			return self::load_file('templates/admin/tabs/tab_1.php');
		}
	}
	
	
	//get tab url
	static function get_tab_url($id = 1){
		$page_url = admin_url('options-general.php?page=wpnicerdashboard');
		if($id > 1){
			$page_url .= '&tab=%s';
			$page_url = sprintf($page_url, $id);
		}
		
		return $page_url;
	}
	
	
}