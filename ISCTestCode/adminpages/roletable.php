<?php
/*NOTE:
  since roletable.php is heavily used in this plugin,
  it should be called with require_once,
  which will ensure that any overlap of functionality
  will not generate an error where this file is concerned
*/
function getRoleNum($roleName) {
  global $wpdb;
  $roleTable = getRoleTable();
  $rolekey = array_search($roleName, $roleTable);
  $sqlQuery = $wpdb->prepare("SELECT * from Role_Type WHERE name = %s", strval($rolekey));
  $roleRow = $wpdb->get_row($sqlQuery, ARRAY_A);
  if(empty($roleRow)) {
    $roleNum = 4;
    //set to user/subscriber
  }else{
    $roleNum = $roleRow["role_type_id"];
  }
  return $roleNum;
}
function getUserIDByUsername($username) {
  global $wpdb;
  $sqlQuery = $wpdb->prepare("SELECT * FROM wp_users WHERE user_login = %s", strval($username));
  $userRow = $wpdb->get_row($sqlQuery, ARRAY_A);
  if (!empty($userRow)){
    $resultValue = $userRow['ID'];
  }else{
    $resultValue = 0;
  }
  return $resultValue;
}
function updateUserRole($userID, $roleName) {
  global $wpdb;
  //$roleTable = getRoleTable();
  //$roleY = $roleTable[$roleName];
  $roleNum = getRoleNum($roleName);
  $user = get_user_by('id', intval($userID));
  //the value, not the key was related as the result of select
  $user->set_role($roleName);
  $checkUpdate = wp_update_user(array(
    'ID' => $userID,
    'role' => $roleName
  ));
  $sqlQuery = $wpdb->prepare("SELECT COUNT(*) FROM User_Roles WHERE user_id = %s", $userID);
  $countedID = intval($wpdb->get_var($sqlQuery));
  if($countedID > 0) {
    $done = $wpdb->update("User_Roles", array("role_id" => $roleNum), array("user_id" => $userID));
  }else{
    $startTime = date("Y-m-d");
    $sqlQuery = $wpdb->prepare("INSERT INTO User_Roles (user_id, role_id, start_time) VALUES (%d, %d, %s)", $userID, $roleNum, $startTime);
    $done = $wpdb->query($sqlQuery);
  }
  if(!is_int($done) OR !is_int($checkUpdate)) {
  // AND is_wp_error( $checkUpdate)) {
    $resultValue = "ERROR";
  }else{
    $resultValue = "SUCCESS, updated role for account ID: " . strval($checkUpdate);
  }
  return $resultValue;
}
function getRoleKey($roleName) {
  $roleTable = getRoleTable();
  $roleKey = array_search($roleName, $roleTable);
  return $roleKey;
}
function getRoleTable(){
  /*NOTE:
  the role must be in this array
  (and be defined in mknewroles.php) to be supported
  the Role_Type table may contain unsupported roles
  */
  $roleTable = array(
    "Performer" => "performer",
    "Admin" => "administrator",
    "Event Director" => "event_director",
    "Auditor" => "audit",
    "Transcriber" => "transcribe",
    "Author" => "auth",
    "User" => "subscriber"
  );
  return $roleTable;
}
function getTitleTable(){
  //some may not be represented, but if it is an issue
  //can easily be added
  $title = array(
    "Dr.",
    "Rev.",
    "Father",
    "Pastor",
    "Bishop",
    "Rabbi",
    "Ven.",
    "Elder",
    "Judge",
    "Chief Justice",
    "Chief",
    "General",
    "Captain",
    "Lt.",
    "Professor",
    "Principal",
    "Chancellor",
    "DJ",
    "Mr.",
    "Mrs.",
    "Ms.",
    "Mx.",
    "Sir",
    "Dame",
    "Count",
    "Countess",
    "Lady",
    "Lord"
  );
  return $title;
}

?>