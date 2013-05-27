<?php




if (!class_exists('wb_nectar')) {
	class wb_nectar {
		/**
		* @var string $localizationDomain Domain used for localization
		*/
		var $localizationDomain = "wb_nectar";

		/**
		* @var string $url The url to this plugin
		*/ 
		var $url = '';
		/**
		* @var string $urlpath The path to this plugin
		*/
		var $urlpath = '';

		//Class Functions
		/**
		* PHP 4 Compatible Constructor
		*/
		function wb_nectar(){$this->__construct();}

		/**
		* PHP 5 Constructor
		*/		
		function __construct(){
			//Language Setup
			$locale = get_locale();
			$mo = plugin_dir_path(__FILE__) . 'languages/' . $this->localizationDomain . '-' . $locale . '.mo';	
			load_textdomain($this->localizationDomain, $mo);

			//"Constants" setup
			$this->url = plugins_url(basename(__FILE__), __FILE__);
			$this->urlpath = plugins_url('', __FILE__);	
			//Actions
			//add_action('admin_enqueue_scripts', array(&$this,'wb_nectar_script')); // or wp_enqueue_scripts, login_enqueue_scripts
			add_action("init", array(&$this,"wb_nectar_init"));
		}

		function wb_nectar_init() {
			
			// Custom Backend Footer
			function wb_nectar_admin_footer() {
				echo '<span id="footer-thankyou">Developed by <a href="http://www.wpbees.com" target="_blank">WordPress Bees</a></span>.';
			}
			
			// adding it to the admin area
			add_filter('admin_footer_text', 'wb_nectar_admin_footer');
			
			// disable default dashboard widgets
			function disable_default_dashboard_widgets() {
				remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
				remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
				remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
				remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget
			
				remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
				remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
				remove_meta_box('dashboard_primary', 'dashboard', 'core');         // 
				remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //
				
				// removing plugin dashboard boxes 
				remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget
				remove_meta_box('dashboardb_xavisys', 'dashboard', 'normal');         // Latest News from Range
				remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal');         // Gravity Forms
				
				/* 
				have more plugin widgets you'd like to remove? 
				share them with us so we can get a list of 
				the most commonly used. :D
				https://github.com/eddiemachado/bones/issues
				*/
			}
			
			/*
			Now let's talk about adding your own custom Dashboard widget.
			Sometimes you want to show clients feeds relative to their 
			site's content. For example, the NBA.com feed for a sports
			site. Here is an example Dashboard Widget that displays recent
			entries from an RSS Feed.
			
			For more information on creating Dashboard Widgets, view:
			http://digwp.com/2010/10/customize-wordpress-dashboard/
			*/
			
			// RSS Dashboard Widget 
			function wb_nectar_rss_dashboard_widget() {
				if(function_exists('fetch_feed')) {
					include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
					$feed = fetch_feed('http://www.wpbees.com/blog/feed/');        // specify the source feed
					$limit = $feed->get_item_quantity(3);                      // specify number of items
					$items = $feed->get_items(0, $limit);                      // create an array of items
				}
				if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message 
				else foreach ($items as $item) : ?>
			
				<h4 style="margin-bottom: 0;">
					<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo $item->get_date('j F Y @ g:i a'); ?>" target="_blank">
						<?php echo $item->get_title(); ?>
					</a>
				</h4>
				<p style="margin-top: 0.5em;">
					<?php echo substr($item->get_description(), 0, 200); ?> 
				</p>
				<?php endforeach; 
			}
			
			// Welcome Widget
			
			function welcome_dashboard_widget() {
				global $current_user;  
			    get_currentuserinfo();
				$blurb = '<p><strong>Hi '.$current_user->display_name.'</strong>, welcome to your website\'s dashboard.</p>';
				$blurb .= '<p>Watch the video below to learn how to use this dashboard and start editing or adding to your website\'s content in minutes.</p>';
				$blurb .= '<span style="color: red;">VIMEO LINK HERE</span>';
			echo $blurb;
			}		
			
			// calling all custom dashboard widgets
			function wb_nectar_custom_dashboard_widgets() {
				//wp_add_dashboard_widget('wb_nectar_rss_dashboard_widget', 'WordPress Website Owner\'s Manual', 'wb_nectar_rss_dashboard_widget');
				wp_add_dashboard_widget('welcome_dashboard_widget', 'Welcome', 'welcome_dashboard_widget');
				/*
				Be sure to drop any other created Dashboard Widgets 
				in this function and they will all load.
				*/
			}
			
			
			// removing the dashboard widgets
			add_action('admin_menu', 'disable_default_dashboard_widgets');
			// adding any custom widgets
			add_action('wp_dashboard_setup', 'wb_nectar_custom_dashboard_widgets');
			
			/************* REMOVING MENU OPTIONS FOR EDITORS *****************/
			
			$editor = get_role('editor');
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
			
			add_action('admin_menu', 'remove_menus', 102);
			function remove_menus()
			{
			global $submenu;
				if ( current_user_can( 'editor' )) {
				//remove_menu_page( 'edit.php' ); // Posts
				//remove_menu_page( 'upload.php' ); // Media
				//remove_menu_page( 'link-manager.php' ); // Links
				//remove_menu_page( 'edit.php?post_type=gallery' ); // Gallery
				//remove_menu_page( 'edit.php?post_type=partner' ); // Partner
				//remove_menu_page( 'edit.php?post_type=event' ); // Partner
				remove_menu_page( 'edit-comments.php' ); // Comments
				//remove_menu_page( 'edit.php?post_type=page' ); // Pages
				remove_menu_page( 'plugins.php' ); // Plugins
				//remove_menu_page( 'themes.php' ); // Appearance
				//remove_menu_page( 'users.php' ); // Users
				remove_menu_page( 'tools.php' ); // Tools
				//remove_menu_page(‘options-general.php’); // Settings
				remove_menu_page( 'edit.php?post_type=acf' ); // Advanced Custom Fields
				
				//remove_submenu_page ( 'index.php', 'update-core.php' );    //Dashboard->Updates
				remove_submenu_page ( 'themes.php', 'themes.php' ); // Appearance-->Themes
				//remove_submenu_page ( 'themes.php', 'widgets.php' ); // Appearance-->Widgets
				remove_submenu_page ( 'themes.php', 'theme-editor.php' ); // Appearance-->Editor
				remove_submenu_page ( 'themes.php', 'themes.php?page=custom-background' ); // Appearance-->Editor
				remove_submenu_page ( 'themes.php', 'themes.php?page=options-framework' ); // Appearance-->Editor
				//remove_submenu_page ( 'options-general.php', 'options-general.php' ); // Settings->General
				remove_submenu_page ( 'options-general.php', 'options-writing.php' ); // Settings->writing
				remove_submenu_page ( 'options-general.php', 'options-reading.php' ); // Settings->Reading
				remove_submenu_page ( 'options-general.php', 'options-discussion.php' ); // Settings->Discussion
				remove_submenu_page ( 'options-general.php', 'options-media.php' ); // Settings->Media
				//remove_submenu_page ( 'options-general.php', 'options-privacy.php' ); // Settings->Privacy
				remove_submenu_page ( 'options-general.php', 'options-general.php?page=velvet-blues-update-urls.php' ); // Settings->Update URLs
				remove_submenu_page ( 'options-general.php', 'options-general.php?page=mailchimpSF_options' ); // Settings->MailChimp Setup
				add_menu_page ('admin.php?page=sc_opt_pg_a');
				}
			}
			
			function wb_nectar_menu_order($menu_ord) {
				if (!$menu_ord) return true;
				return array(
					'index.php', // Dashboard
					'edit.php', // Posts
					'edit.php?post_type=page', // Pages
					'upload.php' // Media
				);
			}
			
			add_filter('custom_menu_order', 'wb_nectar_menu_order');
			add_filter('menu_order', 'wb_nectar_menu_order');

		}

		function wb_nectar_script() {
			wp_enqueue_script('jquery'); // other scripts included with Wordpress: http://tinyurl.com/y875age
			wp_enqueue_script('jquery-validate', 'http://ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.min.js', array('jquery')); // other/new versions: http://www.asp.net/ajaxlibrary/cdn.ashx
			wp_enqueue_script('wb_nectar_script', $this->url.'?wb_nectar_javascript'); // embed javascript, see end of this file
		}
	} //End Class
} //End if class exists statement



if (isset($_GET['wb_nectar_javascript'])) {
	//embed javascript
	Header("content-type: application/x-javascript");
	echo<<<ENDJS
/**
* @desc Nectar
* @author WordPress Bees - http://www.wpbees.com
*/

jQuery(document).ready(function(){
	// add your jquery code here

});

ENDJS;

} else {
	if (class_exists('wb_nectar')) { 
		$wb_nectar_var = new wb_nectar();
	}
}
?>
