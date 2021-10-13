

<?php
/*
 * Plugin Name: ISC User Features
 * Plugin URI:
 * Description: Admin pages and user roles, database features and more
 * Version: 1.1.0
 * Author: Nathan Eggers and Jonah Bouton
 * Author URI:
 */





 //the earlier comments are needed for wordpress to identify your plugin
 //includes the scripts for creating a plugin menu
require 'addmenuadmin.php';
require 'mknewroles.php';



//fetches the global class object for wordpress database access
//global $wpdb;
//$charset_collate = $wpdb->get_charset_collate();

//similar style on https://learnwithdaniel.com/2019/06/wordpress-create-menu/
//that one is for add_options_page though
//runs on plugin activation


function isc_load_styles(){
    $pluginstyleurl = "/wp-content/plugins/ISCTestCode/css/style.css";
    wp_enqueue_style('dashicons');
		wp_enqueue_style('iscadminshine', $pluginstyleurl);
}
add_action('wp_enqueue_scripts', 'isc_load_styles');

//if this fails, then callable function must be included in this file instead.
register_activation_hook(__FILE__, 'mk_new_roles');
//add_action( 'plugins_loaded', [$this, 'mk_new_roles'] );
//should remove footer text via https://www.pdevice.com/wordpress/how-to-remove-edit-thank-you-for-creating-with-wordpress-and-wordpress-versions-from-admin-area/9550
function wpse_edit_footer() {
	add_filter( 'admin_footer_text', 'wpse_edit_text', 11 );
}

function wpse_edit_text($content) {
	$output = "";
	return $output;
}
add_action( 'admin_init', 'wpse_edit_footer' );
function iscfooter(){
	if(current_user_can('promote_users')){
		echo '<span style="background-color: navy; color: cornsilk; width: 100%; height: 3em;">Created by the ISCGroup Capstone from ETSU, Primary Developer: Nathan Eggers, Initial Work: A. Pitman & J. Bouton & Others , July 2021 </span>';
	}
}
add_action('wp_footer', 'iscfooter');
//Alters the admin_menu based on add_cust_admin_menu from addmenuadmin.php
add_action( 'admin_menu', 'add_cust_admin_menu' );
add_action('admin_menu', 'isc_database_plugin_manage_menu');
add_action('admin_menu', 'removeDefaultMenus', 99);
// Pick out the version number from scripts and styles
function remove_version_from_style_js( $src ) {
  if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
    $src = remove_query_arg( 'ver', $src );

  return $src;
}
add_filter( 'style_loader_src', 'remove_version_from_style_js');
add_filter( 'script_loader_src', 'remove_version_from_style_js');
function remove_wordpress_version() {
  return '';
}
add_filter('the_generator', 'remove_wordpress_version');
remove_action('wp_head', 'wp_generator');
//removeDefaultMenus();
//menu removal resulted in nested errors, so it may not work
//99 is supposed to set this to low level priority so that registration hooks can take place first
/*
add_action('init', 'my_init');
function my_init() {
    register_post_type('iscuser', [
        'label' => 'ISC User',
        // .. ect
        'menu_icon' => 'data:image/svg+xml;base64,' . base64_encode('<svg width="20" height="20" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path fill="black" d="M896 0q182 0 348 71t286 191 191 286 71 348q0 181-70.5 347t-190.5 286-286 191.5-349 71.5-349-71-285.5-191.5-190.5-286-71-347.5 71-348 191-286 286-191 348-71zm619 1351q149-205 149-455 0-156-61-298t-164-245-245-164-298-61-298 61-245 164-164 245-61 298q0 250 149 455 66-327 306-327 131 128 313 128t313-128q240 0 306 327zm-235-647q0-159-112.5-271.5t-271.5-112.5-271.5 112.5-112.5 271.5 112.5 271.5 271.5 112.5 271.5-112.5 112.5-271.5z"/></svg>')
     ]);
}
*/
 // ISC function for loading DB Jquery Scripts
 // this function also attempts to load data from the database to be used in the JS script











//keep

 ?>
