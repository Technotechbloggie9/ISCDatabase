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
 function mainbody(){
   add_action('init', 'register_isc_posts');
   add_action('init', 'register_isc_taxonomies');
 }
 function register_isc_posts(){
   /*supports in register_post_type includes
   
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