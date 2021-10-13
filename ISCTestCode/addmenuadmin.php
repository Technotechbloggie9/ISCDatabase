<?php

require __DIR__ . '/adminpages/user-manage-page.php';
require __DIR__ . '/adminpages/user-browse-page.php';
require __DIR__ . '/adminpages/isc-db-settings-page.php';
/*
add_menu_page(string $pagetitle,
string $menu_title, string $capability,
string $menu_slug, callable $function = '',
string $icon_url = '', int $position = null);
*/
/*NOTE:
Each callable function is a page which has
it's main code body wrapped in a function
add_menu_page(
string $page_title, shows at top
string $menu_title, shows in admin menu proper
string $capability, if user has capability this will show
string $menu_slug,  the proper name of the menu item (for removal and such)
callable $function = '', the function which displays the page
string $icon_url = '',   the icon which shows in the menu
int $position = null )   the area of the menu it shows up in
*/
function add_cust_admin_menu() {
  $icon_url = "/wp-content/plugins/ISCTestCode/icons/user.png";
  add_menu_page(
    __( 'Manage Users', 'iscusermanage'),
    __( 'Manage Users', 'iscusermanage'),
    'promote_users',
    'user_manage',
    'userManagePage',
    $icon_url,
    67
  );
  add_menu_page(
    __( 'Browse Users', 'iscuserbrowse'),
    __( 'Browse Users', 'iscuserbrowse'),
    'promote_users',
    'user_browse',
    'userBrowsePage',
    $icon_url,
    68
  );
  //the position is before 70, which is the WordPress Users menu
}
function isc_database_plugin_manage_menu() {

	//create new top-level menu
	//The page would be named ISC DB Settings, and the menu will be the same
    //One can specify the role needed to access this setting (administrator)
    //changed this to the capability as it was documented as on
    // https://developer.wordpress.org/reference/functions/add_menu_page/
  /*
  NOTE: $icon_url must use relative path,
        external URL's may not work,
        dashicons have not worked,
        encoded svg's have not worked,
        png format (with transparency)
        seems to work even if display
        is not ideal
  */
  $icon_url = "/wp-content/plugins/ISCTestCode/icons/database.png";
	add_menu_page(
    __('ISC DB Settings', 'iscdb'),
    __('ISC DB Settings', 'iscdb'),
    'update_core',
    'isc_db_settings',
    'isc_db_settings_page',
    $icon_url,
    79
   );

	//call register settings function when admins sign on

}
function removeDefaultMenus(){
    /*
    NOTE: in theory WordPress menu slugs will match their php-file name
    */
    remove_menu_page('edit-comments.php');
    remove_menu_page('users.php');
}

?>