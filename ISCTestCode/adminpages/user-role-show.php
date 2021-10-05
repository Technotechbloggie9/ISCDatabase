<?php
  require_once "roletable.php";
  function user_modify_form() {
    //NOTE: do not use get_home_path for requires and includes, ABSPATH has trailing slash in string

    global $wpdb;
    $roleTable = getRoleTable();
    $htmlForm = '';
    $htmlForm = $htmlForm . '<br><br><div class="isccard">';
    $htmlForm = $htmlForm . '<div class="isccardheader">';
    $htmlForm = $htmlForm . '<br><span class="title1">User Modify</span><br>';
    $htmlForm = $htmlForm . '</div>';
    $htmlForm = $htmlForm . '<div class="container fancyfill">';

    $sqlQuery = "SELECT * FROM wp_users";
    $results = $wpdb->get_results($sqlQuery);
    $htmlForm = $htmlForm . '<form method="POST" action="#">';
    $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
    $htmlForm = $htmlForm . '<label for="select_user" class="medium1">User to Modify:</label>';
    $htmlForm = $htmlForm .  '<select name="select_user" id="select_user">';
    foreach($results as $userRow){
      $htmlForm = $htmlForm .  '<option value="'. $userRow->user_login .'"> '. $userRow->user_login . ' (' . $userRow->display_name.' ) </option>';
    }
    $htmlForm = $htmlForm .  '</select>';


    $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
    $htmlForm = $htmlForm . '<label for="select_role" class="medium1">Assign Role:</label>';
    $htmlForm = $htmlForm .  '<select name="select_role" id="select_role">';
    $htmlForm = $htmlForm .  '<option value=""></option>';
    foreach($roleTable as $key=>$value) {
      $htmlForm = $htmlForm .  '<option value="'. $value .'">'. $key .'</option>';
    }
    $htmlForm = $htmlForm .  '</select>';
    $htmlForm = $htmlForm .  '<br><br>';
    $htmlForm = $htmlForm . '<span class="mono1 normal1">Role will be ignored if Delete or Edit chosen</span>';
    $htmlForm = $htmlForm .  '<br><br>';
    $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
    $htmlForm = $htmlForm . "<input type='submit' class='iscbtn' id='submit_user_role' name='submit_user_role' value='Change Role' style='font-size: 200%; margin-top: 15px' />";
    $htmlForm = $htmlForm .  '<br><br>';
    $htmlForm = $htmlForm . "<input type='submit' class='iscbtn' id='submit_edit_modify' name='submit_edit_modify' value='Edit User' style='font-size: 200%; margin-top: 15px' />";
    $htmlForm = $htmlForm .  '<br><br>';
    $htmlForm = $htmlForm . "<input type='submit' class='iscbtn' id='submit_user_delete' name='submit_user_delete' value='Delete User' style='font-size: 200%; margin-top: 15px' /><br><br>";

    $htmlForm = $htmlForm . '</form></div></div><br><br>';
    return $htmlForm;
  }

 ?>