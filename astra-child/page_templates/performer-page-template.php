<?php
/*
	Template Name: Performer Page Template
	Website: 	   ISC
	Description:
		Display a HTML page for a performer given a specific
			GET id for the performer.  The performer's
			information is retrieved from the database.
			This file is a template file meaning it is designed
			to display many performers.
	Last Edited:	5/06/2021

*/
get_header(); // Invoke WordPress methods for header display

global $wpdb; // access WordPress's database management
const GET_RETRIEVE_CODE = "id"; //??

// Handle the case of the performer not existing
function performerDoesNotExist()
{
  echo "<h1 style=margin:2%>Selected performer does not exist.</h1>";
}

// Display the HTML for the title area
function displayTitleArea()
{
  $html = "<div class='center-text'>"
    . "<h1>Performer</h1>"
    . "</div> <!-- .center-text -->"
    . "<hr>";

  echo $html; // Display the page's title
}

// Display the HTML for the name and url area of the performance page
// name (string) - the performer's display name name
// url (string) - the performer's website url
function displayNameArea($name, $url)
{
  if ($name !== NULL) {
    $html = "<div class='center-text'>"
      . "<h2>"
      . $name
      . "</h2>";

    if ($url !== NULL) {
      $html = $html . "<br><div class='center-text'>"
        . "<h4>"
        . $url
        . "</h4>"
        . "</div> <!-- .center-text -->";
    } // If no URL, don't show anything about it
    $html = $html . "</div> <!-- .center-text -->"
      . "<hr>";

    echo $html; // display the performer's name
  } // No name condition, should be prevented by the database
}

// Display the HTML for the email address
// email_address (string) - the performer's email address
function displayEmailArea($email_address)
{
  if ($email_address !== NULL) {
    $html = "<div class='reduced-top-margin'>"
      . "<h4> email: "
      . $email_address
      . "</h4>"
      . "</div> <!-- .reduced-top-margin -->";

    echo $html; // display the performer's email
  } // If no email address, don't show anything about it
}

// Display the HTML for the biography area
// biography (string) - The performer's biography info
function displayBiographyArea($biography)
{
  if ($biography !== NULL) {
    $html = "<div>"
      . "<h2 class='center-text'>Performer Biography</h2>"
      . "<hr>"
      . "<div>"
      . "<div class='squareup2 normal1'>"
      . $biography
      . "</div>"
      . "</div>" // inner div
      . "</div>"; // outer div

    echo $html; // display the performer's biographies
  } // If the biography field is NULL, don't show it on the page
}

// Display the performance area
// first_name (string) - the performer's first name
// performance_list (array) - list of a performer's performances
function displayPerformanceArea($performance_list)
{
  global $wpdb; // access WordPress's database management
  $PERFORMANCE_DNE_MSG = "No performances are associated with the performer.";

  $html = "<div>"
    . "<h2 class='centered_header'>Performances</h2>"
    . "<hr>"
    . "<div class='reduced-top-margin'>";

  if ($performance_list !== NULL) { // Check for null values
    if (count($performance_list) !== 0) { // If there are more than 0 performers
      // Get all the performances for a given user
      foreach ($performance_list as $performance) {
        $perf_id = $performance->performance_id;
        $sql = "SELECT * FROM Performances WHERE performance_id = $perf_id";
        $the_performances = $wpdb->get_results($sql);
        foreach ($the_performances as $row) {
          $perf_name = $row->name;
          $html = $html . "<h5>". $perf_name ."</h5>";
        }
      }
    } else {
      $html = $html . $PERFORMANCE_DNE_MSG;
    }
  }
  $html = $html . "</div> <!-- .reduced-top-margin -->"
    . "</div>"; // Outer div

  echo $html; // display the performances
}

// Main
$user_id  = intval($_GET[GET_RETRIEVE_CODE]);
$sqlQuery = $wpdb->prepare("SELECT * from Profile_Images WHERE profile_id = %d", $user_id);
$imageRow = $wpdb->get_row($sqlQuery, ARRAY_A);
if(!empty($imageRow)) {
  $imagePath = $imageRow['image_path'];
}else{
  $imagePath = strval(get_user_meta($userID, 'profile_image', true));
  if(empty($imagePath)) {
    $imagePath = "";
  }
}

$sql = "SELECT * FROM wp_users WHERE ID = $user_id";
$performer_results = $wpdb->get_row($sql);
if ($performer_results === NULL) {
  performerDoesNotExist();
} else {
  // Get the data needed for the form
  $performer_id = $performer_results->ID;
  //get_user_meta( int $user_id, string $key = '', bool $single = false )
  $performer_bio = strval(get_user_meta($performer_id, 'description', true));
  $performer_display_name = strval($performer_results->display_name);
  $sql = "SELECT * FROM User_Names WHERE user_id = $performer_id";
  //User_Names does not seem to be currently in use
  $performer_link = strval($performer_results->user_url);
  $performer_email = strval($performer_results->user_email);
  $sql = "SELECT * FROM Performance_Performers WHERE performer_id = $performer_id";
  $performer_performances = $wpdb->get_results($sql);
}
?>

<div id="primary" class="site-content center-text topwidth">
  <div id="content" role="main">

    <?php
    displayTitleArea();
    if(!empty($imagePath)) {
      echo "<br>";
      echo "<img src='".$imagePath."' alt='Profile Image' class='thumbcenter'>";
      echo "<br>";
    }
    displayNameArea($performer_display_name, $performer_link);
    displayEmailArea($performer_email);
    displayBiographyArea($performer_bio);
    displayPerformanceArea($performer_performances);

    ?>

  </div> <!-- #content -->
</div> <!-- #primary -->

<?php
the_content();
get_footer();
 // Invoke WordPress methods for footer display
 ?>