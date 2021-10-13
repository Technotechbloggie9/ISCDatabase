<?php
require_once "roletable.php";
    function userEditForm($userID, $userName, $userDisplayName, $userEmail){
      $roleTable = getRoleTable();
      //form should be compatible with wp_create_user() or wp_insert_user()
      //see style.css for css classes and notes for most of these
      $htmlForm = '';
      $htmlForm = $htmlForm . '<br><br><div class="isccard">';//start card
      $htmlForm = $htmlForm . '<div class="isccardheader">';
      $htmlForm = $htmlForm . '<br><span class="title1">Edit User with ID: '. $userID .'</span><br>';
      $htmlForm = $htmlForm . '</div>';
      $htmlForm = $htmlForm . '<div class="container fancyfill">';
      $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
      $htmlForm = $htmlForm . '<form method="POST" action="#">'; //start form
      $htmlForm = $htmlForm . '<label for="txtDisplayName" class="medium1">Display Name (Required)</label><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtDisplayName" name="txtDisplayName" class="medium1 ch1" value="'. $userDisplayName .'" required><br><br>';
      $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
      $htmlForm = $htmlForm . '<label for="txtEmail" class="medium1">Email Address</label><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtEmail" name="txtEmail" class="medium1 ch1" value="'. $userEmail .'"><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtUserID" name="txtUserID" value="'.  $userID .'" hidden><br><br>';
      $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
      $htmlForm = $htmlForm . "<input type='submit' class='iscbtn' id='submit_user_edit' name='submit_user_edit' value='Edit User' style='font-size: 200%; margin-top: 15px' /><br><br>";
      $htmlForm = $htmlForm . '</form>';//end form
      $htmlForm = $htmlForm . '</div></div><br><br>';//end card
      return $htmlForm;
    }
    function userPassForm($userID, $userName){
      $htmlForm = '';
      $htmlForm = $htmlForm . '<br><br><div class="isccard">';//start card
      $htmlForm = $htmlForm . '<div class="isccardheader">';
      $htmlForm = $htmlForm . '<br><span class="title1">Change Password for Username: '. $userName .'</span><br>';
      $htmlForm = $htmlForm . '</div>';
      $htmlForm = $htmlForm . '<div class="container fancyfill">';
      $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
      $htmlForm = $htmlForm . '<form method="POST" action="#">'; //start form
      $htmlForm = $htmlForm . '<label for="txtPassword" class="medium1">New Password (Required)</label><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtPassword" name="txtPassword" class="medium1 ch1" required><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtUserID" name="txtUserID" value="'.  $userID .'" hidden><br><br>';
      $htmlForm = $htmlForm . "<input type='submit' class='iscbtn' id='submit_user_pass' name='submit_user_pass' value='Change Password' style='font-size: 200%; margin-top: 15px' /><br><br>";
      $htmlForm = $htmlForm . '</form>';//end form
      $htmlForm = $htmlForm . '</div></div><br><br>';//end card
      return $htmlForm;
    }
    function userBioForm($userID, $userDisplayName, $userBio, $userFirstName, $userLastName){
      $titleTable = getTitleTable();
      $htmlForm = '';
      $htmlForm = $htmlForm . '<br><br><div class="isccard">';//start card
      $htmlForm = $htmlForm . '<div class="isccardheader">';
      $htmlForm = $htmlForm . '<br><span class="title1">Update Bio for User: '. $userDisplayName .'</span><br>';
      $htmlForm = $htmlForm . '</div>';
      $htmlForm = $htmlForm . '<div class="container fancyfill">';
      $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
      $htmlForm = $htmlForm . '<form id="form_bio" method="POST" enctype="multipart/form-data" action="#">';
      $htmlForm = $htmlForm . '<label for="imgpfp"  class="medium1" >Select Image For Profile Picture </label><br><br>';
      $htmlForm = $htmlForm . '<input type="file" id="imgpfp" name="imgpfp" accept="image/*" /><br><br>';
      $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
      $htmlForm = $htmlForm . '<span class="normal1 mono1">Other than first name and last name, these fields only alter the display data.</span><br><br>';
      $htmlForm = $htmlForm . '<span class="normal1 mono1">Changes to first and last name will alter the username and other account data.</span><br><br>';
      $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
      $htmlForm = $htmlForm . '<span class="normal1 mono1">This is an option for public display (where applicable)</span><br><br>';
      $htmlForm = $htmlForm . '<label for="select_honor" class="medium1">Chose Honorary Title</label><br><br>';
      $htmlForm = $htmlForm .  '<select name="select_honor" id="select_honor">';
      $htmlForm = $htmlForm .  '<option value=""></option>';
      foreach($titleTable as $value) {
        $htmlForm = $htmlForm .  '<option value="'. $value .'">'. $value .'</option>';
      }
      $htmlForm = $htmlForm .  '</select><br><br>';
      $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
      $htmlForm = $htmlForm . '<label for="txtFirstName" class="medium1">Enter First Name</label><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtFirstName" name="txtFirstName" class="medium1 ch1" value="'. $userFirstName .'" required><br><br>';
      $htmlForm = $htmlForm . '<span class="normal1 mono1">This is an option which alters public display </span><br><br>';
      $htmlForm = $htmlForm . '<label for="txtMiddleName" class="medium1">Enter Middle Name</label><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtMiddleName" name="txtMiddleName" class="medium1 ch1"><br><br>';
      $htmlForm = $htmlForm . '<label for="txtLastName" class="medium1">Enter Last Name</label><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtLastName" name="txtLastName" class="medium1 ch1" value="'. $userLastName .'"required><br><br>';
      $htmlForm = $htmlForm . '<span class="normal1 mono1">This is an option for public display</span><br><br>';
      $htmlForm = $htmlForm . '<label for="txtSuffix" class="medium1">Enter Suffix</label><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtSuffix" name="txtSuffix" class="medium1 ch1"><br><br>';
      $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
      $htmlForm = $htmlForm . '<label for="txtBio" class="medium1">Enter Bio</label><br><br>';
      $htmlForm = $htmlForm . '<textarea type="text" id="txtBio" name="txtBio" rows="11" cols="22" maxlength="500" style="width:auto; box-shadow: 5px 5px 2px grey;">'. $userBio .'</textarea><br><br>';
      $htmlForm = $htmlForm . '<input type="text" id="txtUserID" name="txtUserID" value="'.  $userID .'" hidden><br><br>';
      $htmlForm = $htmlForm . "<input type='submit' class='iscbtn' id='submit_user_bio' name='submit_user_bio' value='Update Bio' style='font-size: 200%; margin-top: 15px' /><br><br>";
      $htmlForm = $htmlForm . '</form>';//end form
      $htmlForm = $htmlForm . '</div></div><br><br>';//end card
      return $htmlForm;
      /*
      Submit
      ---------------
      submit_user_bio
      ---------------
      VALUES
      ---------------
      txtUserID (hidden)
      select_honor
      txtFirstName
      txtMiddleName
      txtLastName
      txtSuffix
      txtBio
      */
    }
 ?>