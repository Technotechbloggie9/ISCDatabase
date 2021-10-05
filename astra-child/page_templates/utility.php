<?php
/*
function deslash($slashstring) {
  $unslashstring = preg_replace('[\\]', "", $slashstring);
  return $unslashstring;
}
*/
/*
Function: mk_sanitize_date
Parameters: $date string
Returns: string
Description:
  validates or cleans string for date
  for mariadb 'yyyy-mm-dd' format
  failed validation will cause string
  '0000-00-00' to output
*/
function mk_sanitize_date($date){
    //sanitization function for mariadb format time
    //strip whitespace
    //echo '<script>alert("Sanitize date has been called")</script>';
    $date = preg_replace('/\s\s+/', ' ', $date);
    //remove non-numeric characters which aren't -
    $date = preg_replace("([^0-9-])", "", $date);
    //allows some limited types of fake dates through,
    //but shouldn't matter if datepicker is used
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
        $date2 = $date;
    } else {
        //returns empty date if anything goes wrong
        $date2 = "0000-00-00";
    }
    return $date2;
}
/*
Function: mk_sanitize_time
Parameters: $time1 string
Returns: string
Description:
  strips extra characters not expected
  in timepicker time string
*/
/*NOTE:
mk_sanitize_time was proven by experiment
in w3schools "Try It Yourself" environment
------------------------
  cleans brackets, slashes,
  and improper text,
  but not extra spaces
  or extra numbers
  clean timepicker data would not cause errors
-----------------------
in other words, it is secure,
but not error-proof...
within the context of this
code it will work
but may need improvement
to use elsewhere
-----------------------*/
function mk_sanitize_time($time1) {
    //sanitization function for timepicker time
    $pattern2 = "([^0-9:\sPM\sAM])";
    $time1 = preg_replace($pattern2, "", $time1);
    return $time1;
}
function alert_st($message=""){
    //echo '<script>alert("alert has been called");</script>';
    $report = '<script>alert(" '. $message .'");</script>';
    return $report;
}
/*
Function: to_military_time
Parameters: $timestring string
Returns: string
Description:
  reformats timepicker string to
  military/24-hour clock string
  for input into mariadb time format
*/
function to_military_time($timestring){
  list($timepart, $am_pm) = explode(" ", $timestring);
  list($hours1, $minutes1) = explode(":", $timepart);
  $inthours = (int)$hours1;
  if(strtolower($am_pm)=="pm"){
    $inthours = $inthours + 12;
  }
  $output = strval($inthours) . ":" . $minutes1;
  return $output;
}
/*
Function: from_military_time
Parameters: $timestring string
Returns: string
Description:
  reformats
  military/24-hour clock string to
  timepicker string
  for presentation
*/
function from_military_time($timestring){
  list($hours1, $mins1) = explode(":", $timestring);
  $inthours = (int)$hours1;
  if($inthours > 12){
    $inthours = $inthours - 12;
    $am_pm = " PM";
  }else{
    $am_pm = " AM";
  }
  $output = strval($inthours) . ":" . $mins1 . $am_pm;
  return $output;
}
/*
Function: uvalue
Description:
  Use with individual values from useed
Returns:
  Unique int or false
Purpose:
  To help prevent username conflict
*/
  function uvalue($randvalue){
    global $wpdb;
    $ucount = $wpdb->get_var("SELECT COUNT (*) FROM U_Values");

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
        $sqlQuery = $wpdb->prepare("INSERT INTO U_Values (value) VALUES (%d)", $randvalue);
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
  Returns:
    5 unique ints in associative array
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
  /*
  Function: uquery
  Description:
    Contains specialized loop for uvalue
    to navigate useed values and feed into U_Value table
    for checking
  Returns:
    As string, 1 unique int checked to U_Value table

  Purpose:
    To help prevent username conflict
    final piece of uvalue, useed set of functionality
    use with performer creation
  */
  function uquery(){
    $valarr = useed(); //allows five tries due to remix of individual random factors
    //specialized for each to navigate useed values,
    //note the key name retrieval in $seednum = valarr[]
    foreach(range(1,5) as $number) {
      $seednum = $valarr['rand' . $number];
      $resultnum = uvalue($seednum);
      if(is_int($resultnum)) {
        break; //exits loop upon finding unique value
      }
    }
    return strval($resultnum);
  }
  /*
  Function: checkIfRoleExists
  Description:
    Surprisingly no built in function in WordPress
    exists to check for a role's existence
    It is necessary to check the return of get_role for object,
    Which is in my opinion, not an obvious way to do this
    This function attempts to correct this oversight
  */
  function checkIfRoleExists($rolename) {
    $roleY = get_role($rolename);
    if ($roleY == false AND !is_object($roleY)) {
      //NOTE: initially ran condition with an OR, which was too loose, AND is better
      //!is_array($roleY)) { <-- This was incorrect, as get_role returns an object with an array as a member
      //in this condition, the role does not exist
      $resultoutput = FALSE;
    }else if(is_object($roleY)){
      //the return of a role object indicates that the role exists
      $resultoutput = TRUE;
    }else{
      //technically an error
      $resultoutput = FALSE;
    }
    return $resultoutput;
  }


?>