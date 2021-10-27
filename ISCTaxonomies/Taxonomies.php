<?php
/*
 * Plugin Name: ISC Custom Post and Search Taxonomies
 * Plugin URI:
 * Description: Transcriptions, Articles, and Search Features
 * Version: 1.2.0
 * Author: N. Eggers and 2021 to 2022 ISC Capstone Group
 * Author URI:
 */
 //ISC Capstone Group includes: 
 mainbody();
 /*
 function name: mainbody
 description:
 the main driver for setting up 
 ISC custom posts, taxonomies, and 
 search functionality
 */
 function mainbody(){
   add_action('init', 'register_isc_posts');
   add_action('init', 'register_isc_taxonomies');
 }
 function register_isc_posts(){
   register_post_type("article", );
   /*
   information

    description
    public
    exclude_from_search
    publicly_queryable
    show_ui
    show_in_nav_menus
    show_in_menu
    show_in_admin_bar
    menu_position
    menu_icon
    capability_type
    capabilities
    map_meta_cap
    hierarchical
    supports
    register_meta_box_cb
    taxonomies
    has_archive
    rewrite
    permalink_epmask
    query_var
    can_export
    delete_with_user
    show_in_rest
    rest_base
    rest_controller_class
    _builtin
    _edit_link 
    supports in register_post_type includes
   
    ‘title’
    ‘editor’ (content)
    ‘author’
    ‘thumbnail’ (featured image) (current theme must also support Post Thumbnails)
    ‘excerpt’
    ‘trackbacks’
    ‘custom-fields’ (see Custom_Fields, aka meta-data)
    ‘comments’ (also will see comment count balloon on edit screen)
    ‘revisions’ (will store revisions)
    ‘page-attributes’ (template and menu order) (hierarchical must be true)
    ‘post-formats’ (see Post_Formats)
    */
    
 }
 function register_isc_taxonomies(){
   
 }
?>