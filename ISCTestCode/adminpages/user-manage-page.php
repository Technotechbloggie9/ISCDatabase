<?php
function userManagePage(){
  require_once "user-role-show.php";
  require_once "user-create-show.php";
  require_once "user-edit-show.php";
  require_once "roletable.php";
  require_once "updatebio.php";
  require_once "user-view-page.php";
  global $wpdb;
  /*TODO:
  currently contains only test code,
  add real code later
  */
  /*NOTE:
  Semantic conditionals are meant to clarify the
  action of the if statements.
  It is difficult to tell what each if statement is
  doing in much of the code due to several
  built-in functions surrounding the evaluation CONDITIONALS
  Boolean assignment allows use of AND, OR,
  and other boolean operands.
  Ternary is best for the base conditionals.
  */
  echo "<link rel='stylesheet' href='". get_bloginfo('url'). "/wp-content/plugins/ISCTestCode/css/style.css" ."'>";
  echo "<span class='medium1 mono1'></span><br><br>";
  /*NOTE:
  These conditionals were meant to be set by boolean operations and by ternary assignment
  This script kept failing at an unknown point,
  presumed to be before the first echo statement
  */
  //----SEMANTIC CONDITIONALS----------
  $form_posted = FALSE;
  $user_create_submit = FALSE;
  $validate_user_create = FALSE;
  $user_edit_submit = FALSE;
  $validate_user_edit = FALSE;
  $user_delete_submit = FALSE;
  $validate_user_delete = FALSE;
  $validate_edit_modify = FALSE;
  $validate_user_pass = FALSE;
  $validate_user_bio = FALSE;
  $validate_user_view = FALSE;
  $user_edit_modify = FALSE;
  $user_pass_submit = FALSE;
  $user_bio_submit = FALSE;
  //$role_found = (boolean)checkIfRoleExists($_POST['select_role']);
  $user_role_submit = FALSE;
  //$role_not_found = (boolean)(!$role_found AND !empty($_POST['select_role'] AND $user_role_submit));
  $validate_user_role = FALSE;
  $other = FALSE;
  $getUserID = 0;
  $got_ID_from_get = FALSE;

  if(isset($_GET['id'])){
    $getUserID = intval($_GET['id']);
    if($getUserID > 0){
      $got_ID_from_get = TRUE;
    }
  }

  echo "<div class='topwidth' role='main'>";
  echo "<br><br>";
  echo "<div class='topwidth official1'>";
  echo "<div class='cmdscreen mono1 topwidth' style='height: 10em;'><br><br>";
  //-------------------------------------
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_posted = TRUE;
    echo "<span class='title1'> Manage Users </span> </div><br><br>";
    echo '<script>alert("form was posted");</script>';
  }
  if(isset($_POST['submit_user_create'])) {
    $user_create_submit = TRUE;
    echo '<script>alert("create was pressed");</script>';
  }
  if(isset($_POST['submit_user_edit'])) {
    $user_edit_submit = TRUE;
    echo '<script>alert("edit was pressed");</script>';
  }
  if(isset($_POST['submit_user_pass'])) {
    $user_pass_submit = TRUE;
    echo '<script>alert("change password was pressed");</script>';
  }
  if(isset($_POST['submit_user_bio'])) {
    $user_bio_submit = TRUE;
    echo '<script>alert("update bio was pressed");</script>';
  }
  if(isset($_POST['submit_user_delete'])) {
    $user_delete_submit = TRUE;
    echo '<script>alert("delete was pressed");</script>';
  }
  if(isset($_POST['submit_user_role'])){
    $user_role_submit = TRUE;
    echo '<script>alert("change role was pressed");</script>';
  }
  if(isset($_POST['submit_edit_modify'])){
    $user_edit_modify = TRUE;
  }
  if($form_posted AND $user_create_submit) {
    $validate_user_create = TRUE;
  }else if($form_posted AND $user_edit_submit) {
    $validate_user_edit = TRUE;
  }else if($form_posted AND $user_delete_submit){
    $validate_user_delete = TRUE;
  }else if($form_posted AND $user_role_submit){
    $validate_user_role = TRUE;
  }else if($form_posted AND $user_edit_modify){
    $validate_edit_modify = TRUE;
  }else if($form_posted AND $user_bio_submit){
    $validate_user_bio = TRUE;
  }else if($form_posted AND $user_pass_submit){
    $validate_user_pass = TRUE;
  }else if((!$form_posted) AND $got_ID_from_get) {
    $validate_user_view = TRUE;

  }else{
    $other = TRUE;
  }
  //--------MAIN BODY--------------------



  //echo user_modify_form();
  if ($validate_user_create == TRUE) {
    echo "create";
    /*
    From user_create_form
    ---------------------
    txtFirstName,
    txtLastName,
    txtEmail,
    select_role,
    txtPassword,
    txtUvalue (hidden)
    ----------------------
    Submit button
    ----------------------
    submit_user_create
    ----------------------
    NOTE:
    first task is to create the username from
    the provided form pieces,
    second task creates the display name
    third task creates the user
    */
    if(!empty($_POST['txtFirstName']) AND !empty($_POST['txtLastName']) AND !empty($_POST['txtPassword'])) {
      $firstName = sanitize_text_field($_POST['txtFirstName']);
      $lastName = sanitize_text_field($_POST['txtLastName']);
      $email = sanitize_text_field($_POST['txtEmail']);
      $role = sanitize_text_field($_POST['select_role']);
      $default_role = 'subscriber';
      $passWord = sanitize_text_field($_POST['txtPassword']);
      $uniqueNumString = sanitize_text_field($_POST['txtUvalue']);
      $displayName = $firstName . " " . $lastName;
      $userName = strtolower($lastName) . strtolower(substr($firstName,0,1)) . $uniqueNumString;
      $userdata = array(
        'user_pass'             => $passWord,   //(string) The plain-text user password.Gave a default to override later.
        'user_login'            => $userName,   //(string) The user's login username.
        'user_nicename'         => $userName,   //(string) The URL-friendly user name.
        'user_email'            => $email,   //(string) The user email address.
        'display_name'          => $displayName,   //(string) The user's display name. Default is the user's username.
        'nickname'              => $userName,   //(string) The user's nickname. Default is the user's username.
        'first_name'            => $firstName,   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
        'last_name'             => $lastName,   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
        'role'                  => $defaut_role //set to user first
      );
      if(!empty($userdata)){
        echo '<script>alert("User data has been initialized for use in database")</script>';
        //$ucf_ID is user create form ID, basically user id, but isolated to processing this form
        $ucf_ID = wp_insert_user($userdata);
        $userID = getUserIDByUsername($userName);

        //use of updateUserRole simplifies the addition of users to User_Roles table
      }else{
        echo '<script>alert("Error: user data has NOT been initialized for use in database")</script>';
        $ucf_ID = FALSE;
      }

      if(is_int($ucf_ID)) {
        echo '<script>alert("Successful user creation.")</script>';
        echo '<p class="medium1">Added new user: '. $userName .'</p>';
        echo '<p class="medium1"> ' . updateUserRole($userID, $role) . ' </p>';
      }else{
        //if it is not an int for an id, it's an error
        echo '<script>alert("Something went wrong.")</script>';

      }//else

    }
  }else if($validate_edit_modify == TRUE){
    $userName = sanitize_text_field($_POST['select_user']);
    $sqlQuery = $wpdb->prepare("SELECT * FROM wp_users WHERE user_login = %s", $userName);
    $userRow = $wpdb->get_row($sqlQuery, ARRAY_A);
    $userID = $userRow['ID'];
    $userDisplayName = $userRow['display_name'];
    $userEmail = $userRow['user_email'];
    $userBio = " ";
    $metaKey = "description";
    $metaQuery = $wpdb->prepare("SELECT * FROM wp_usermeta WHERE meta_key = %s AND user_id = %d", $metaKey, $userID);
    $metaRow = $wpdb->get_row($sqlQuery, ARRAY_A);
    if(!empty($metaRow) AND !empty($metaRow['meta_value'])) {
      $userBio = strval($metaRow['meta_value']);
    }else{
      $userBio = get_user_meta($userID, $metaKey, true);
    }
    $metaKey = "first_name";
    $metaRow = $wpdb->get_row($sqlQuery, ARRAY_A);
    if(!empty($metaRow) AND !empty($metaRow['meta_value'])) {
      $userFirstName = strval($metaRow['meta_value']);
    }else{
      $userFirstName = get_user_meta($userID, $metaKey, true);
    }
    $metaKey = "last_name";
    $metaRow = $wpdb->get_row($sqlQuery, ARRAY_A);
    if(!empty($metaRow) AND !empty($metaRow['meta_value'])) {
      $userLastName = strval($metaRow['meta_value']);
    }else{
      $userLastName = get_user_meta($userID, $metaKey, true);
    }

    echo userEditForm($userID, $userName, $userDisplayName, $userEmail);
    echo userPassForm($userID, $userName);
    echo userBioForm($userID, $userDisplayName, $userBio, $userFirstName, $userLastName);
  }else if($validate_user_edit == TRUE) {
    $userID = intval(sanitize_text_field($_POST['txtUserID']));
    $displayName = sanitize_text_field($_POST['txtDisplayName']);
    $userEmail = sanitize_text_field($_POST['txtEmail']);
    $user_data = wp_update_user(array('ID' => $userID, 'user_email' => $userEmail, 'display_name' => $displayName));
    if ( is_wp_error( $user_data ) ) {
      echo '<p>Error. No changes have occurred.</p>';
    }else{
      echo '<p>User profile updated.</p>';
    }

  }else if($validate_user_pass== TRUE) {
    $userID = intval(sanitize_text_field($_POST['txtUserID']));
    $passWord = sanitize_text_field($_POST['txtPassword']);
    $user_data = wp_update_user(array('ID' => $userID, 'user_pass' =>$passWord));
    if ( is_wp_error( $user_data ) ) {
    // There was an error; possibly this user doesn't exist.
      wp_set_password($passWord, $userID);
      echo '<p>Potential Error. New password may have been set on retry (with no feedback for success).</p>';
    } else {
    // Success!
      echo '<p>User password updated.</p>';
    }
  }else if($validate_user_delete == TRUE) {
    $userName = sanitize_text_field($_POST['select_user']);
    $editor = 2;
    $userID = getUserIDByUsername($userName);

    if($userID > 0) {
      $sqlQuery = $wpdb->prepare("DELETE FROM wp_users WHERE ID = %d", intval($userID));

      if(wp_delete_user($userID, $editor)){
        echo "<p class='medium1'>Delete action performed.</p>";
      }else{
        $done = $wpdb->query($sqlQuery);
        if(is_int($done)){
          echo "<p class='medium1'>Delete action performed.</p>";
        }else{
          echo "<p class='medium1'>Delete action was not performed, something went wrong.</p>";
        }
      }

    }else{
      echo "<p class='medium1'>User not found.</p>";
    }
    /*NOTE:
    second parameter reassigns posts,
    in our case to the default editor
    */
  }else if($validate_user_role == TRUE) {
    $role = sanitize_text_field($_POST['select_role']);
    $userName = sanitize_text_field($_POST['select_user']);
    if(!empty($role AND !empty($userName))){
      $userID = getUserIDByUsername($userName);
      if($userID > 0) {
        echo '<p> ' . updateUserRole($userID, $role) . ' </p>';
      }else{
        echo '<p>User not found</p>';
      }
    }else{
      echo '<p>Please enter username & role for the change role function.</p>';
      echo user_modify_form();
    }
    echo "role";
  }else if($validate_user_view == TRUE) {
    echo "<span class='title1'> User View </span> </div><br><br>";
    $userID = intval($_GET['id']);
    echo makeUserView($userID);
  }else if($validate_user_bio == TRUE) {

    $valarr = useed(); //allows five tries due to remix of individual random factors
    //specialized for each to navigate useed values,
    //note the key name retrieval in $seednum = valarr[]
    foreach(range(1,5) as $number) {
      $seednum = $valarr['rand' . strval($number)];
      $uvalue = uvalue($seednum);
      if(is_int($uvalue)) {
        break; //exits loop upon finding unique value
      }
    }
    $userID = 0;
    $title = sanitize_text_field($_POST['select_honor']);
    $firstName = sanitize_text_field($_POST['txtFirstName']);
    $middleName = sanitize_text_field($_POST['txtMiddleName']);
    $lastName = sanitize_text_field($_POST['txtLastName']);
    $suffix = sanitize_text_field($_POST['txtSuffix']);
    $bio = sanitize_text_field($_POST['txtBio']);
    $imageProperties = getimageSize($_FILES['imgpfp']['tmp_name']);
    $img_type = $imageProperties['mime'];
    $img_name = basename($_FILES["imgpfp"]["name"]);
    $userID = intval(sanitize_text_field($_POST['txtUserID']));
    if(!empty($img_name) AND $userID > 0){
      img_processuf($userID, $image_type, $img_name);
    }
    echo processUserBio($userID, $title, $firstName, $middleName, $lastName, $suffix, $bio, $uvalue);
  }else {
    //displays the primary forms cards
    echo "<span class='title1'> Manage Users </span> </div><br><br>";
    echo user_modify_form();
    echo user_create_form();
  }
  echo "</div>";
  echo "</div>";
  do_action('wp_footer');

}
function img_processuf($user_ID, $image_type, $img_name)
{
    //required for each function
    global $wpdb;
    //echo '<script>alert("In image processing function")</script>';

    //the wp_upload_dir() function returns an array
    $upload_dir = wp_upload_dir();
    //prepare the imgprofile directory in uploads if it doesn't exist
    //and if the upload directory is defined in wordpress
    if(!empty($upload_dir['basedir'])) {
        $img_dir = $upload_dir['basedir'].'/imgprofile/';
        if(!file_exists($img_dir)) {
            wp_mkdir_p($img_dir);
        }

        $img_path = $img_dir . $user_ID . "_" . $img_name;
        $img_path2 = get_bloginfo('url') . '/wp-content/uploads/imgprofile/' . $user_ID . "_" . $img_name;
        //does the actual upload, moves from the tmp folder to target
        if(move_uploaded_file($_FILES["imgpfp"]["tmp_name"], $img_path)) {
            echo '<script>alert("The image has been stored to '. $img_path .' ");</script>';
            echo '<script>alert("The image can accessed from '. $img_path2 .' ");</script>';
            $img_table = "Profile_Images";
            update_user_meta($user_ID, 'profile_image', $img_path2);
            $sqlQuery0 = $wpdb->prepare("SELECT * FROM Profile_Images WHERE profile_id = %d", $user_ID);
            $imgRow = $wpdb->get_row($sqlQuery0);
            $sqlQuery1 = $wpdb->prepare("INSERT INTO Profile_Images (image_name, image_path, image_type, profile_id) ".
						"VALUES (%s, %s, %s, %d)", $img_name, $img_path2, $img_type, $user_ID);
            $sqlQuery2 = $wpdb->prepare("UPDATE Profile_Images SET image_name = %s, image_path =%s, image_type = %s, WHERE profile_id = %d)", $img_name, $img_path2, $img_type, $user_ID);

            if(empty($imgRow)) {
              $done = $wpdb->query($sqlQuery1);
            }else{
              $done = $wpdb->query($sqlQuery2);
            }
            if (is_int($done) AND ($done > 0)) {
                echo '<script>alert("Submission success (Profile_Images), '. $done .' rows inserted");</script>';
                echo '<img src="'.$img_path2.'" alt="Profile Image" height="120px" width="120px" />';
            }else{
                echo '<script>alert("Result of submission unknown."</script>';
            }//else $done
        } else {
            echo '<script>alert("Error uploading file")</script>';
        }//else move_uploaded_file
    }else{
        echo '<script>alert("Error: Directory /UPLOADS/ is undefined");</script>';
    }//else
    //TODO
}
/*
function checkIfRoleExists($rolename) {
  $roleY = get_role($rolename);
  if ($roleY == false AND !is_object($roleY)) {
  //NOTE: ran condition with an OR, which was too loose
  //!is_array($roleY)) { <-- This was incorrect, as get_role returns an object with an array as a member
    //$resultoutput = "<span style='font-size: 200%'>The role - ". $rolename ." does not exist</span><br><br>";
    $resultoutput = FALSE;
  }else if(is_object($roleY)){
    //$resultoutput = "<span style='font-size: 200%'>The role - ". $rolename ." was found</span><br><br>";
    //$resultoutput = "<div>". implode(" ", $roleY) . "</div>";
    $resultoutput = TRUE;
  }else{
    //$resultoutput = "<span style='font-size: 200%'>Error - ". $rolename ."</span><br><br>";
    $resultoutput = FALSE;
  }
  return $resultoutput;
}
*/
 ?>