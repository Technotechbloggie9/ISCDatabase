<?php

  /*
  Function: processUserBio
  Description:
  Stores the user data in the appropriate locations,
  including the user_meta and the custom database tables,
  does not handle the profile image information
  Purpose:
  Update display_name and account information
  */
  function processUserBio($userID, $title, $firstName, $middleName, $lastName, $suffix, $bio, $uvalue){
    global $wpdb;
    $setlogin = false;
    $displayName = $title . " " . $firstName . " " . $middleName . " " . $lastName . " " . $suffix;
    $userName = strtolower($lastName) . strtolower(substr($firstName,0,1)) . $uvalue;
    //update_user_meta( int $user_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' )
    /*NOTE:
    Deletes any previous information for the user in User_Names,
    This is the only place so far where information is added to User_Names table
    */
    $lastNamePrevious = strval(get_user_meta($userID, 'last_name', true));
    $firstNamePrevious = strval(get_user_meta($userID, 'first_name', true));
    $sameFirstName = ($lastNamePrevious==$lastName) ? true : false;
    $sameLastName = ($firstNamePrevious==$firstName) ? true : false;
    $setlogin = ($sameFirstName !== true || $sameLastName !== true) ? true : false;
    $sqlQuery = $wpdb->prepare("DELETE FROM User_Names WHERE user_id = %d", $userID);
    $done = $done1 = $done2 = $done3 = $done4 = $done5 = false;
    $done = $wpdb->query($sqlQuery);

    if(is_int($done)) {

      $resultOutput = '<p>Initial preparation has occurred</p>';
    }
    $sqlQuery = $wpdb->prepare("INSERT INTO User_Names (user_id, first_name, middle_name, last_name, honorifics, qualifiers ) VALUES (%d, %s, %s, %s, %s, %s)",
    $userID,
    $firstName,
    $middleName,
    $lastName,
    $title,
    $suffix
    );
    $doneUserNameTable = $wpdb->query($sqlQuery);
    $metaKey = "first_name";
    $done1 = update_user_meta($userID, $metaKey, $firstName);
    $metaKey = "last_name";
    $done2 = update_user_meta($userID, $metaKey, $lastName);
    if(!empty($middleName)){
      $metaKey = "middle_name";
      $done3 = update_user_meta($userID, $metaKey, $middleName);
    }else{
      $done3 = true;
    }
    if(!empty($title)){
      $metaKey = "name_prefix";
      $done4 = update_user_meta($userID, $metaKey, $title);
    }else{
      $done4 = true;
    }
    if(!empty($suffix)){
      $metaKey = "name_suffix";
      $done5 = update_user_meta($userID, $metaKey, $suffix);
    }else{
      $done5 = true;
    }
    $metaKey = "description";
    $done = update_user_meta($userID, $metaKey, $bio);
    if($setlogin == true){
      $sqlQuery = $wpdb->prepare("UPDATE wp_users SET user_login = %s, user_nicename = %s, display_name = %s WHERE ID = %d",
      $userName, $userName, $displayName, $userID);
    }else{
      $sqlQuery = $wpdb->prepare("UPDATE wp_users SET display_name = %s WHERE ID = %d",
      $displayName, $userID);
    }

    $updated = $wpdb->query($sqlQuery);
    $continued = false;

    if ( ($done OR is_int($done))
    AND ($done1 OR is_int($done1))
    AND ($done2 OR is_int($done2))
    AND ($done3 OR is_int($done3))
    AND ($done4 OR is_int($done4))
    AND ($done5 OR is_int($done5))) {
      $continued = true;

    }
    if($continued == true) {
      $table = "wp_users";
      if($setlogin == true) {
        $data = array(
          'user_login' => $userName,
          'user_nicename' => $userName,
          'display_name' => $displayName
        );
      }else{
        $data = array(
          'display_name' => $displayName
        );
      }
      $where = array(
        'ID' => $userID
      );
      if($updated == false){
        $updated2 = $wpdb->update($title, $data, $where);
      }else{
        $updated2 = $updated;
      }
      if ( false === $updated2 ) {
        // There was an error.
        $resultOutput = '<p>User data failed to be updated. Retry attempt will occur.</p>';
        //this is unlikely to work for user_login
        if($setlogin == true) {
          $user_data = wp_update_user( array( 'ID' => $userID, 'user_login' => $userName, 'user_nicename' => $userName, 'display_name' => $displayName ) );
        }else{
          $user_data = wp_update_user( array( 'ID' => $userID, 'display_name' => $displayName ) );
        }
        if ( is_wp_error( $user_data ) ) {
            // There was an error; possibly this user doesn't exist.
            $resultOutput = '<p>User data failed to be updated. Retry attempt also failed.</p>';
        } else {
            // Success!
          $resultOutput = '<p>User data was updated on retry.</p>';
        }
      } else {
        // No error. You can check updated to see how many rows were changed.
        $resultOutput = '<p>User data was updated</p>';
      }
    }else{
      $resultOutput = '<p>Some data may have failed to be processed. Browse Users to check if the data is correct.</p>';
    }
    return $resultOutput;
  }
 ?>