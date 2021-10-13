<?php

  //--------MAIN BODY --------------
  //makeUserView is called outside of this page
  //------END MAIN BODY-------------
  function makeUserView($userID){
    require_once "roletable.php";
    //get_user_meta( int $user_id, string $key = '', bool $single = false )
    echo '<script>alert("User ID is '.$userID.' ")</script>';
    $userArray = get_user_meta($userID);
    $userInfo = get_user_by('id', $userID);

    if(!empty($userArray)){
      $htmloutput = "<br><br>";
      $htmloutput = $htmloutput . "<div class='topwidth regfill centerup'>";

      $userLogin = $userInfo->user_login;
      //if(!empty($userLogin)) {
        $htmloutput = $htmloutput . "<div class='squareup2 medium1'><span>";
        $htmloutput = $htmloutput . "Username: " . $userLogin . " ";
        $htmloutput = $htmloutput . "</span></div><br><br>";
      //}
      $userImg = strval(get_user_meta($userID, 'profile_image', true));

      if(!empty($userImg)) {
        $htmloutput = $htmloutput . "<div class='squareup2'><img src='" . $userImg ."' alt='No Profile Image' class='thumbcenter'></div><br><br>";
      }
      $userDisplayName = strval($userInfo->display_name);

      if(!empty($userDisplayName)) {
        $htmloutput = $htmloutput . "<div class='squareup2 medium1'><span>";
        $htmloutput = $htmloutput . "User Display Name: " . $userDisplayName . " ";
        $htmloutput = $htmloutput . "</span></div><br><br>";
      }

      $userEmail = strval($userInfo->user_email);
      //display user email if available
      if(!empty($userEmail)) {
        $htmloutput = $htmloutput . "<div class='squareup2 medium1'><span>";
        $htmloutput = $htmloutput . "User Email Address: " . $userEmail . " ";
        $htmloutput = $htmloutput . "</span></div><br><br>";
      }

      $count = 0;
      $allRole = "";
      $roles = ( array ) $userInfo->roles;
      //display user role if available
      if(!empty($roles)) {
        $htmloutput = $htmloutput . "<div class='squareup2 medium1'><span>";
        foreach($roles as $userRole){
          $count = $count + 1;
          $rolekey = strval(getRoleKey($userRole));
          if(empty($rolekey)){
            $rolekey = $userRole;
          }
          if($count > 1){
            $allRole = $allRole . " , " . strval($rolekey);
          }else{
            $allRole = $allRole . strval($rolekey) . " ";
          }
        }
        $htmloutput = $htmloutput . "User Role(s): " . $allRole . " ";
        $htmloutput = $htmloutput . "</span></div><br><br>";
      }
      $userURL = strval($userInfo->user_url);
      //display user website if available
      if(!empty($userURL)) {
        $htmloutput = $htmloutput . "<div class='squareup2 medium1'><span>";
        $htmloutput = $htmloutput . "User Website: " . $userURL . " ";
        $htmloutput = $htmloutput . "</span></div><br><br>";
      }
      $userReg = strval($userInfo->user_registered);
      if(!empty($userReg)) {
        $htmloutput = $htmloutput . "<div class='squareup2 medium1'><span>";
        $htmloutput = $htmloutput . "User Registration Date: " . $userReg . " ";
        $htmloutput = $htmloutput . "</span></div><br><br>";
      }
      $userBio = strval(get_user_meta($userID, 'description', true));
      if(!empty($userBio)) {
        $htmloutput = $htmloutput . "<div class='squareup2 medium1'><span>";
        $htmloutput = $htmloutput . "Biographical Description: " . $userBio . " ";
        $htmloutput = $htmloutput . "</span></div><br><br>";
      }



      $htmloutput = $htmloutput . "</div><br><br>";
    }else{
      $htmloutput = "<br><br><p>No user data found</p>";
    }
    return $htmloutput;
  }
 ?>