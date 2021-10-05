<?php
require_once "roletable.php";
/*
Function: uvalue
Description:
  Use with individual values from useed
  returns unique int or false
Purpose:
  To help prevent username conflict
*/
  function uvalue($randvalue){
    global $wpdb;
    $ucount = $wpdb->get_var("SELECT COUNT(*) FROM U_Values");

    if($ucount < 3999) {
      /*
      NOTE:
      didn't provide iteratable value anywhere, such as single value in file, opted to randomize instead
      may be better to iterate via single value instead later to avoid incidental repetition except 1 out of 3999
      (minus chance of actual repeated name)
      (random chance to get U_Value value *should* be about twice as high as iterate,
      but I've not done the math)
      Was unable to import original permutation table, so resorted to doing this instead,
      Similar result after 4000 are entered
      */
      $checkrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM U_Values WHERE value = %d", intval($randvalue)), ARRAY_A);
      if(empty($checkrow)) {
        $uvalueresult = intval($randvalue);
        $sqlQuery = $wpdb->prepare("INSERT INTO U_Values (value) VALUES (%d)", intval($randvalue));
        $wpdb->query($sqlQuery);
      }else{
        $uvalueresult = FALSE;
      }
    }else{
      $upos1 = rand(1, 3998);
      $checkrow = $wpdb->get_row($wpdb->prepare("SELECT * FROM U_Values WHERE uvalue = %d", $upos1), ARRAY_A);
      $uvalueresult = intval($checkrow['value']);
    }
    return $uvalueresult;
  }
  /*
  Function: useed
  Description:
    Use with specialized foreach loop and
    with the uvalue function
    returns unique int in associative array
    ("rand" and numbers 1 to 5 in named key)
  Purpose:
    To help prevent username conflict
  */
  function useed(){
    $u1 = rand(1, 9);
    $u2 = rand(1, 9);
    $u3 = rand(1, 9);
    $u4 = rand(1, 9);
    $stringU1 = "" . $u1 . $u2 . $u3 . $u4;
    $stringU2 = "" . $u2 . $u1 . $u4 . $u3;
    $stringU3 = "" . $u4 . $u2 . $u3 . $u1;
    $stringU4 = "" . $u4 . $u1 . $u3;
    $stringU5 = "" . $u3 . $u1 . $u2;
    $valarr = array(
      "rand1" => intval($stringU1),
      "rand2" => intval($stringU2),
      "rand3" => intval($stringU3),
      "rand4" => intval($stringU4),
      "rand5" => intval($stringU5)
    );
    return $valarr;
  }
  function user_create_form() {
    $valarr = useed(); //allows five tries due to remix of individual random factors
    //specialized for each to navigate useed values,
    //note the key name retrieval in $seednum = valarr[]
    foreach(range(1,5) as $number) {
      $seednum = $valarr['rand' . strval($number)];
      $resultnum = uvalue($seednum);
      if(is_int($resultnum)) {
        break; //exits loop upon finding unique value
      }
    }
    $stringnum = strval($resultnum);
    $roleTable = getRoleTable();
    //form should be compatible with wp_create_user() or wp_insert_user()
    //see style.css for css classes and notes for most of these
    $htmlForm = '';
    $htmlForm = $htmlForm . '<br><br><div class="isccard">';//start card
    $htmlForm = $htmlForm . '<div class="isccardheader">';
    $htmlForm = $htmlForm . '<br><span class="title1">Add New User</span><br>';
    $htmlForm = $htmlForm . '</div>';
    $htmlForm = $htmlForm . '<div class="container fancyfill">';
    $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
    $htmlForm = $htmlForm . '<form method="POST" action="#">'; //start form
    $htmlForm = $htmlForm . '<label for="txtFirstName" class="medium1">First Name (Required)</label><br><br>';
    $htmlForm = $htmlForm . '<input type="text" id="txtFirstName" name="txtFirstName" class="medium1 ch1" required><br><br>';
    $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
    $htmlForm = $htmlForm . '<label for="txtLastName" class="medium1">Last Name (Required)</label><br><br>';
    $htmlForm = $htmlForm . '<input type="text" id="txtLastName" name="txtLastName" class="medium1 ch1" required><br><br>';
    $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
    $htmlForm = $htmlForm . '<label for="txtEmail" class="medium1">Email Address</label><br><br>';
    $htmlForm = $htmlForm . '<input type="text" id="txtEmail" name="txtEmail" class="medium1 ch1"><br><br>';
    $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
    $htmlForm = $htmlForm . '<label for="select_role" class="medium1">Choose a Role</label><br><br>';
    $htmlForm = $htmlForm .  '<select name="select_role" id="select_role">';
    $htmlForm = $htmlForm .  '<option value=""></option>';
    foreach($roleTable as $key=>$value) {
      $htmlForm = $htmlForm .  '<option value="'. $value .'">'. $key .'</option>';
    }
    $htmlForm = $htmlForm .  '</select><br><br>';
    $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
    $htmlForm = $htmlForm . '<label for="txtPassword" class="medium1">Password (Required)</label><br><br>';
    $htmlForm = $htmlForm . '<input type="text" id="txtPassword" name="txtPassword" class="medium1 ch1" required><br><br>';
    $htmlForm = $htmlForm . '<input type="text" id="txtUvalue" name="txtUvalue" value="'.  $stringnum .'" hidden><br><br>';
    $htmlForm = $htmlForm . '<br><br><hr width="20%"/><br><br>';
    $htmlForm = $htmlForm . "<input type='submit' class='iscbtn' id='submit_user_create' name='submit_user_create' value='Create User' style='font-size: 200%; margin-top: 15px' /><br><br>";
    $htmlForm = $htmlForm . '</form>';//end form
    $htmlForm = $htmlForm . '</div></div><br><br>';//end card
    return $htmlForm;
    /*
    From user_create_form
    ---------------------
    txtFirstName,
    txtLastName,
    txtEmail,
    txtPassword,
    txtUvalue (hidden)
    ----------------------
    Submit button
    ----------------------
    submit_user_create
    */
  }

 ?>