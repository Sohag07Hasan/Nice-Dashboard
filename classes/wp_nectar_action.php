<?php
//if(class_exists('WpNectar')) return;


class WpNectar{
	
	private $nectar_cap = "enable_nice_dashboard";
	
	/*
	 *constructor that contains everything hooks
	 */
	function __construct(){
		register_activation_hook(NECTAR_FILE, array(&$this, 'activate_the_plugin'));
		
		// adding it to the admin area
		add_filter('admin_footer_text', array(&$this, 'wb_nectar_admin_footer'));
		
		//dashboard widgets
		add_action('wp_dashboard_setup', array(&$this, 'wb_nectar_custom_dashboard_widgets'));
		
		//menu ordering
		add_filter('custom_menu_order', array(&$this, 'wb_nectar_menu_order'));
		add_filter('custom_menu_order', array(&$this, 'wb_nectar_menu_order'));
		
		//ation to remvoe the menus/submenus
		add_action('admin_menu', array(&$this, 'remove_menu_submeuns'));
		add_action('wp_dashboard_setup', array(&$this, 'remove_dashboard_widgets'));
	}
	
	
	/*
	 *modify the editor role when activating
	 * 
	 */
	function activate_the_plugin(){
		if($editor = get_role('editor')){			
			$editor->add_cap('edit_theme_options');
			$editor->remove_cap('install_themes');
			$editor->remove_cap('import');
			$editor->add_cap('manage_options');
			$editor->add_cap('edit_users');
			$editor->add_cap('create_users');
			$editor->add_cap('delete_users');
			$editor->add_cap('list_users');
			$editor->add_cap('remove_users');
			$editor->add_cap( 'chat_with_users' );
			
			//new cap to fire the plguin activity in front end
			$editor->add_cap($this->nectar_cap);
		}
	}
	
	
	/*
	 * alter the footer text
	 * */
	function wb_nectar_admin_footer($footer){
		return '<span id="footer-thankyou">Developed by <a href="http://www.wpbees.com" target="_blank">WordPress Bees</a></span>';
	}
	
	
	/*
	 *	Registering the dashboard widgets
	 */
	function wb_nectar_custom_dashboard_widgets(){
		wp_add_dashboard_widget('welcome_dashboard_widget', 'Welcome', array(&$this, 'welcome_dashboard_widget'));
	}
	
	
	/*
	 * welcome widget content
	 * */
	function welcome_dashboard_widget(){
		global $current_user;  
	    get_currentuserinfo();
		$blurb = '<p><strong>Hi '.$current_user->display_name.'</strong>, welcome to your website\'s dashboard.</p>';
		$blurb .= '<p>Watch the video below to learn how to use this dashboard and start editing or adding to your website\'s content in minutes.</p>';
		$blurb .= get_option('nice_dashboard_vimeo_video');
		echo $blurb;
	}
	
	
	/*
	 * customize the menu order 
	 */
	function wb_nectar_menu_order($menu_ord) {
		if (!$menu_ord) return true;
		return array(
			'index.php', // Dashboard
			'edit.php', // Posts
			'edit.php?post_type=page', // Pages
			'upload.php' // Media
		);
	}
	
	
	
	/*
	 * if an user has $this->nectar_cap, the prescribe menus/submenus will be hidden
	 * */
	function remove_menu_submeuns(){
		if(current_user_can($this->nectar_cap)){
			if(!$menus_submenus = get_option('nice_dashboard_menus_submenus')){
				$menus_submenus = array();
				$menus_submenus['submenus'] = array();
				$menus_submenus['toplevel_menus'] = array();
			}
			
			//mneu pages
			if(count($menus_submenus['toplevel_menus']) > 0){
				foreach($menus_submenus['toplevel_menus'] as $top_level_menu){
					remove_menu_page($top_level_menu);
				}
			}
			
			//submenu pages
			if(count($menus_submenus['submenus']) > 0){
				foreach($menus_submenus['submenus'] as $submenu){
					$slugs = explode(', ', $submenu);
					remove_submenu_page(trim($slugs[0]), trim($slugs[1]));					
				}
			}
		}
	}
	
	
	/*
	 * if an user has $this->nectar_cap, the prescribe dashboard will be hidden
	 * */
	function remove_dashboard_widgets(){
		if(current_user_can($this->nectar_cap)){
			
			if ( !$widget_options = get_option( 'dashboard_widget_options' ) )
				$widget_options = array();
			
			if ( !isset($widget_options['nice_dashboard_filtering']) ){
				$widget_options['nice_dashboard_filtering'] = array();	
			}
			
			if(!isset($widget_options['nice_dashboard_filtering']['normal'])){
				$widget_options['nice_dashboard_filtering']['normal'] = array();
			}
			
			if(!isset($widget_options['nice_dashboard_filtering']['side'])){
				$widget_options['nice_dashboard_filtering']['side'] = array();
			}
			
			//removing normal widgets
			foreach($widget_options['nice_dashboard_filtering']['normal'] as $widget){
				remove_meta_box($widget, 'dashboard', 'normal');
			}
			
			//removing side widgets
			foreach($widget_options['nice_dashboard_filtering']['side'] as $widget){
				remove_meta_box($widget, 'dashboard', 'side');
			}
		}
	}
	
}


$Wp_ectar = new WpNectar();