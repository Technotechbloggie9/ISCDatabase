<?php
/*
	Template Name: 	Event Page Template
	Website: 		ISC
	Description:
		Display an HTML page for an event given a specific
			GET id for the event.  The event's
			information is retrieved from the database.
			This file is a template file meaning it is designed
			to display many events.
	Last Edited:	5/06/2021
*/
//TODO: review code again, a bit complex and performer area may need editing
get_header(); // Invoke WordPress methods for header display

global $wpdb; // access WordPress's database management
const DATE_FORMAT = "m/d/y"; // Can use m-d-y, or switch the positions
const GET_RETRIEVE_CODE = "id";

// Handle the case of the event not existing
function eventDoesNotExist()
{
  echo "<h1 style=margin:2%>Selected event does not exist.</h1>";
}

// Display the event name and event photo buttons
// name (string) - the event's name
function displayEventNameArea($name)
{
  if ($name !== NULL) {
    $html = "<div class='center-text'>"
      . "<h1>"
      . $name
      . "</h1>";

      // To enable the event photo button remove the starting comment
      // It is currently disabled due to not actually doing anything.
      //displayEventPhotoButton();

      $html = $html . "</div> <!-- .center-text -->"
      . "<hr>";
    echo $html; // display the event's name and a event photo button
  } // Should be a non-nullable field?
}

// Display a button to link to the event photos for this even
// TODO: currently event photos aren't implemented so the link
//     : will need to be adjusted before use.
function displayEventPhotoButton() {
  $html = "<div id='event-photo-button'>"
  . "<button type='button' href='#'>Event Photos</button>"
  . "</div>  <!-- #event-photo-button -->";

  echo $html;
}
//
// Display the date and time of an event
// start_date (string) - the event's start date
// end_date (string) - the event's end date
function displayDateTimeArea($start_date, $end_date)
{
  $DEFAULT_TIME = Date('01/01/1970');

  $html = "<div class='reduced-top-margin center-text medium-font'>"
  . "<p>";

  if ($start_date === NULL) { // Is the start date invalid?
    $html = $html . "The start date is invalid.";
  } else {
    if ($start_date === $DEFAULT_TIME) { // Is the start date the default time?
      $html = $html . "No dates were found.";
    } else { // The start date is not the default time.
      $html = $html . $start_date;  // Append start date in every case
      if ($end_date !== NULL) { // Is the end date empty?
        $html = $html . " - ";
        if ($start_date <= $end_date) { // Is start less or equal to end?
          $html = $html . $end_date;
        } else { // The start date is not less or equal to the end date.
          $html = $html . "Invalid End Date";
        }
      } // The else is do nothing.
    }
  }

  $html = $html . "</p></div> <!-- .reduced-top-margin -->";
  echo $html;
}

// Display the performers area
// performance_list (array[obj]) - the list of performances from the database
function displayPerformersArea($performance_list)
{
  global $wpdb; // access WordPress's database management
  $PERFORMER_MESSAGE = "No performers are associated with this event.";

  $html = "<div class='line-above'>"
    . "<h3>Performers</h3>"
    . "<br>";

  // There are no performances so there are also no performers.
  if (count($performance_list) === 0)
  {
    $html = $html . "<p class='twenty-point-font'>$PERFORMER_MESSAGE</p>";
  } elseif ($performance_list !== NULL) { // Is the result not NULL
    // Get the performers who performed in an event to display them
    foreach ($performance_list as $performance) {
      $perf_id = $performance->performance_id;
      $sql_performance_performer =
        "SELECT * FROM Performance_Performer WHERE performanceId = $perf_id";
      $performance_performer_results =
        $wpdb->get_results($sql_performance_performer);
      if (count($performance_performer_results) !== 0) {
        foreach ($performance_performer_results as $row) {
          $performer_id = $row->performerID;
          $sql_user = "SELECT * FROM wp_users WHERE ID = $performer_id";
          $performer = $wpdb->get_row($sql_user);
          $performer_name = $performer->display_name;
          $html = $html . "<p class='twenty-point-font'>$performer_name</p>";
        }
      }
      else {
        $html = $html . "<p class='twenty-point-font'>$PERFORMER_MESSAGE</p>";
      }
    }
  } else { // Performer list is null
    // This condition may be unreachable due to the wordpress
    //  function wpdb returning an empty array instead of NULL.
    $html = $html . "<p class='twenty-point-font'>$PERFORMER_MESSAGE</p>";
  }

  $html = $html . "</div> <!-- event-page-performer-listing -->";

  echo $html; // Display the list of performers
}

// Display the event location area
// location (string) - the event's location
function displayEventLocationArea($location)
{
  if ($location !== NULL) {
    $html = "<p class='twenty-point-font'>"
      . "Event Location: "
      . $location
      . "</p>";

    echo $html; // display the event location
  } // If the location is null, don't display location information
}

// Display the event description area
// description (string) - the event's description
function displayEventDescriptionArea($description)
{
  if ($description !== NULL) {
    $html = "<p class='reduced-top-margin'>"
      . $description
      . "</p>";

    echo $html; // display the event description
  } // If the description is null, don't display description information
}

// Display the performance area
// performance_results (array[string]) - A list of associated performances
function displayPeformanceArea($performance_results)
{
  $html = "<div class='line-above'>"
    . "<h3>Performances</h3>"
    . "<div><br>";

  // Append each performance to the html string of performances
  if ( $performance_results !== NULL and count($performance_results ) !== 0 ) {
    foreach ($performance_results as $row) {
      $perf_name = $row->name;
      $html = $html . "<p class='twenty-point-font'>$perf_name</p>";
    }
  } else {
    $html = $html . "<p class='twenty-point-font'>No performances are associated with this event.</p>";
  }

  $html = $html . "</div>" // inner div
    . "</div>"; // outer div

  echo $html; // display the performances
}

// Main
//NOTE: The special portion is $_GET[], which is pulling from the ? in the URL here
$event_id = $_GET[GET_RETRIEVE_CODE];
$sql = "SELECT * FROM Events WHERE event_id = $event_id";
$event_results = $wpdb->get_row($sql);
if ($event_results === NULL) {
  eventDoesNotExist();
} else {
  // Get the data needed for the form
  $id = $event_results->event_id;
  $name = stripslashes($event_results->name);
  $start_date = date(DATE_FORMAT, strtotime($event_results->start_date));
  $end_date_string = $event_results->end_date;
  $end_date = NULL;
  if($end_date_string !== NULL) {
    $end_date = date(DATE_FORMAT, strtotime($event_results->end_date));
  }
  $location = $event_results->location;
  $attendance = $event_results->attendance;
  $description = $event_results->description;

  $sql = "SELECT * FROM Performances WHERE event_id = $id";
  $performance_results = $wpdb->get_results($sql);
}
?>

<div id="primary" style="width:98%;" class="site-content center-text">
  <div id="content" role="main">

    <?php
    displayEventNameArea($name);
    displayDateTimeArea($start_date, $end_date);
    displayEventLocationArea($location);
    displayEventDescriptionArea($description);
    displayPerformersArea($performance_results);
    displayPeformanceArea($performance_results);
    ?>

  </div>
</div>

<?php
the_content();
get_footer(); // Invoke WordPress methods for footer display
?>
