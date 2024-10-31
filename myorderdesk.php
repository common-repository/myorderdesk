<?php
/*
Plugin Name:  MyOrderDesk
Plugin URI:   https://support.myorderdesk.com/hc/en-us
Description:  MyOrderDesk iFrame plugin
Version:      3.2.6
Author:       Print Reach, Inc.
Author URI:   https://printreach.com
License:      GPL3
License URI:  https://www.gnu.org/licenses/gpl-3.0.en.html
*/

// Exit if accessed directly
if (!defined('ABSPATH'))
	exit;

define('MODWOP_PLUGIN_VERSION', '3.2.6');

/**
 * DEFINE PATHS
 */
define('MODWOP_PATH', plugin_dir_path(__FILE__));
define('MODWOP_ASSETS', MODWOP_PATH . 'assets/');
define('MODWOP_CSS', MODWOP_ASSETS . 'css/');
define('MODWOP_IFRAME', MODWOP_ASSETS . 'iframe/');
define('MODWOP_IMAGES', MODWOP_ASSETS . 'images/');
define('MODWOP_SCRIPTS', MODWOP_ASSETS . 'scripts/');
define('MODWOP_SHORTCODES', MODWOP_SCRIPTS . 'shortcodes/');

/**
 * DEFINE URLS
 */
define('MODWOP_URL', plugin_dir_url(__FILE__));
define('MODWOP_ASSETS_URL', MODWOP_URL . 'assets/');
define('MODWOP_CSS_URL', MODWOP_ASSETS_URL . 'css/');
define('MODWOP_IFRAME_URL', MODWOP_ASSETS_URL . 'iframe/');
define('MODWOP_IMAGES_URL', MODWOP_ASSETS_URL . 'images/');
define('MODWOP_SCRIPTS_URL', MODWOP_ASSETS_URL . 'scripts/');
define('MODWOP_SHORTCODES_URL', MODWOP_SCRIPTS_URL . 'shortcodes/');
define('MODWOP_SVN_VERSION_URL', 'https://plugins.svn.wordpress.org/myorderdesk/trunk/version.txt');

define('MODWOP_IFRAME_SANDBOX', 'allow-storage-access-by-user-activation allow-forms allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox allow-modals allow-downloads allow-top-navigation');

require(MODWOP_SCRIPTS . 'main.php');
require(MODWOP_SHORTCODES . 'shortcodes.php');

//Create admin menu
add_action( 'admin_menu', 'myorderdesk_settingsmenu' );

// Add plugin scripts
if ( !is_admin() ) {
	add_action('wp_enqueue_scripts', 'myorderdesk_load_scripts');
}
?>