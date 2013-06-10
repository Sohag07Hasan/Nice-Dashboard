<?php 
	
/*
Plugin Name: Nectar
Plugin URI: http://www.wpbees.com
Description: Sweet, sweet nectar. Tidies up the WordPress dashboard.
Version: 1.0.0
Author: WordPress Bees
Author URI: http://www.wpbees.com 
* Modified by: Mahibul Hasan
*/
/*

Changelog:
v1.0: Initial release

*/
/*
Credits: 
	This template is based on the template at http://pressography.com/plugins/wordpress-plugin-template/ 
	My changes are documented at http://soderlind.no/archives/2010/03/04/wordpress-plugin-template/
*/

define("NECTAR_FILE", __FILE__);
define("NECTAR_DIR", dirname(__FILE__));

//admin section controlling
include NECTAR_DIR . '/classes/class.controller.php';
WpNectarController::init();


//front end controlling
include NECTAR_DIR . '/classes/wp_nectar_action.php';

