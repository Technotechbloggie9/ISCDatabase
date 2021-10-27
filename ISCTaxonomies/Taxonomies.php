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
   register_post_type("article", array(
     'labels' => array(
       'name' =>          _x('Articles', 'post type general name'),
       'singular_name' => _x('Article', 'post type singular name'),
       'add_new'       => _x('Add New', 'article'),
       'add_new_item'  => __('Add New Article'),
       'edit_item' =>     __( 'Edit Article' ),
       'new_item'  =>     __( 'New Article' ),
       'all_items' =>     __( 'All Articles' ),
       'view_item' =>     __( 'View Article' ),
       'search_items' =>  __( 'Search Articles' ),
       'not_found'    =>  __( 'No articles found' ),
       'not_found_in_trash' => __( 'No articles found in the Trash' ), 
       'parent_item_colon'  => __('Parent Articles'),
       'featured_image'        => _x( 'Article Cover Image'),
       'set_featured_image'    => _x( 'Set cover image'),
       'remove_featured_image' => _x( 'Remove cover image'),
       'use_featured_image'    => _x( 'Use as cover image'),
       'archives'              => _x( 'Article archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
       'insert_into_item'      => _x( 'Insert into article'),
       'uploaded_to_this_item' => _x( 'Uploaded to this article'),
       'filter_items_list'     => _x( 'Filter articles list'),
       'items_list_navigation' => _x( 'Articles list navigation'),
       'items_list'            => _x( 'Articles list'),
     ),
     'menu_name'          => 'Articles',
     'description'        => 'Articles are written information concerning events, performances, performers, or topics of interest',
     'public'             => true,
     'publicly_queryable' => true,
     'exclude_from_search' => false,
     'has_archive'         => true,
     'slug'                => 'article',
     'supports' => array(
       'title',
       'editor',
       'author',
       'excerpt',
       'thumbnail',
       'custom-fields',
       'revisions'
     ),
     'show_ui' => true,
     'show_in_nav_menus' => true,
     'delete_with_user' => false
   ));
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
 /*
 function name: register_isc_taxonomies
 description:
 used by action hook to
 run register_taxonomy WordPress functions
 that allow custom taxonomies to be used
 */
 function register_isc_taxonomies(){
   register_taxonomy(
     'subject',
     'articles',
     array(
       'label' => __( 'Subjects' ),
       'rewrite' => array( 'slug' => 'subject'),
       'hierarchical' => true
     )
   );
 }
?>