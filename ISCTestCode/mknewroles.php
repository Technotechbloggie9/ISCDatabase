<?php
/*
Function: mk_new_roles
Description:
Makes custom roles
event_director
audit
performer
transcribe
auth
and alters administrator
*/
function mk_new_roles() {
    remove_role('event_director');
    add_role('event_director', 'Event Director', array(
      'read' => true,
      'read_private_posts' => true,
      'delete_others_pages' => true,
      'delete_others_posts' => true,
      'delete_pages' => true,
      'delete_private_posts' => true,
      'delete_posts' => true,
      'delete_published_pages' => true,
      'delete_published_posts' => true,
      'edit_others_pages' => true,
      'edit_private_posts' => true,
      'edit_others_posts' => true,
      'edit_pages' => true,
      'edit_posts' => true,
      'edit_published_pages' => true,
      'edit_published_posts' => true,
      'manage_categories' => true,
      'manage_links' => true,
      'moderate_comments' => true,
      'unfiltered_html' => true,
      'add_users' => true,
      'create_users' => true,
        'float_transcribe' => true,
        'assoc_transcribe' => true,
        'view_transcribe' => true,
        'publish_transcribe' => true,
        'flag_transcribe' => true
    ));
    remove_role('audit');
    /*
    //removed at client request
    add_role('audit', 'Auditor', array(
      'read' => true,
      'view_transcribe' => true,
      'view_self_transcribe' => true,
      'read_private_pages' => true,
      'read_private_posts' => true,
      'read_audit_log' => true,
      'post_audit_log' => true,
      'link_note_audit' => true,
      'browse_all' => true,
    ));
    */
    remove_role('performer');
    //performer must not have menu per client request
    //not clear if total removal is desirable or possible
    //at this point
    add_role('performer', 'Performer', array(
      'read' => true,
      'request_performance_delete' => true,
      'view_self_transcribe' => true
    ));
    remove_role('transcribe');
    add_role('transcribe', 'Transcriber', array(
      'read' => true,
      'view_transcribe' => true,
      'view_self_transcribe' => true,
      'create_transcribe' => true,
      'assoc_transcribe' => true,
      'edit_transcribe' => true
    ));
    remove_role('auth');
    add_role('auth', 'ISC Author', array(
      'read' => true,
      'delete_posts' => true,
      'edit_posts' => true,
      'edit_published_posts' => true,
      'read' => true,
      'upload_files' => true
    ));
    //Extend admin with custom capabilities
    /*$role = get_role('administrator');

    $role->remove_cap('read_audit_log');
    $role->add_cap('read_audit_log');
    $role->remove_cap('float_transcribe');
    $role->add_cap('float_transcribe');
    $role->remove_cap('browse_all');
    $role->add_cap('browse_all');
    $role->remove_cap('direct_download');
    $role->add_cap('direct_download');
    $role->remove_cap('reset_database');
    $role->add_cap('reset_database');
    $role->remove_cap('assoc_transcribe');
    $role->add_cap('assoc_transcribe');
    $role->remove_cap('view_transcribe');
    $role->add_cap('view_transcribe');
    $role->remove_cap('publish_transcribe');
    $role->add_cap('publish_transcribe');
    $role->remove_cap('view_transcribe');
    $role->add_cap('view_transcribe');
    $role->remove_cap('view_self_transcribe');
    $role->add_cap('view_self_transcribe');
    $role->remove_cap('edit_transcribe');
    $role->add_cap('edit_transcribe');
    $role->remove_cap('create_transcribe');
    $role->add_cap('create_transcribe');
    $role->remove_cap('manage_users');
    $role->add_cap('manage_users');
    */
}
/*
  Function: get_roles_path
  Description: returns file directory of mknewroles.php
  Purpose: Used in registering hook by register_activation_hook
*/
function get_roles_path() {
  /*NOTE:
  From StackOverFlow in https://stackoverflow.com/questions/1506459/what-does-file-mean
  (answer by user Greg)
  __FILE__ is a magic constant that gives you the filesystem path to the current .php file
  (the one that __FILE__ is in, not the one it's included by if it's an include.
  Apparently this may not be needed
  TODO: Delete if not needed after initial testing
  */
  return __FILE__;
}

/*NOTE:
Add the new user with: $someone = new WP_USER($user_id);
Add roles with: $someone->add_role('auth');
                $someone->add_role('performer');
                $someone->add_role('audit');
                $someone->add_role('transcribe');
                $someone->add_role('event_director');
Check capabilities with: current_user_can('read_audit_log');
(Will return true or false)
Similar with: user_can($someone->ID, 'post_audit_log');
New capabilities (caps) added here
  read_audit_log
  post_audit_log
  link_note_audit ... can link to page in log, or to page on site
  float_transcribe ... this is disassociate from performance
  assoc_transcribe
  view_transcribe
  publish_transcribe
  flag_transcribe ... part of a delete mechanism, presumes review by others
  create_transcribe
  edit_transcribe
  view_self_transcribe
  browse_all
  direct_download
  reset_database
  request_performance_delete
Event Director
  It is unclear whether Event Director should be able to
  edit or delete private pages based on RBAC matrix,
  private posts and public posts are likely okay,
  Role seems almost like Editor or Admin in wordpress,
  Create users is left on due to Performers editing page,
  Which relies on this permission.
Transcriber
  Only contains custom permissions and read
auth: ISC Author
  This is a more limited version of the author role,
  which does NOT allow the deleting of published posts,
  or the publishing of posts
Admin
  Best to leave this as default administrator role,
  some added capability code to put in some of the custom
  capabilities
User
  Best to leave this as default subscriber role
*/
?>