<?php
/*
    Template Name:     Performance Page Template
    Website:         ISC
    Description:    Template for the Performance Page
    Last Edited:     6/15/2021
*/
    //pfm-show.php is used for the function pfm_head
    require 'pfm-show.php';
    //utility.php is used for the function from_military_time
    require 'utility.php';
    // access WordPress's database management
    global $wpdb;
    echo pfm_head();
    // astra method to summon website styled header
    get_header();
    //--Declaration of Constants-----
    const GET_RETRIEVE_CODE = "id";
    const DATE_FORMAT = "m/d/y";
    //-------------------------------

    // astra methods to summon website styled pages
    astra_primary_content_top();
    astra_primary_content_bottom();
?>
<div class='row'>
  <div class='column' style='width: 80%;'>
<?php
    /*NOTE:
    Height sizes in em
    S/M/L like T-shirt sizes
    Small/Medium/Large
    */
    $emXXS = "1em";
    $emXS = "2em";
    $emS = "5em";
    $emM = "11em";
    $emL = "19em";
    //NOTE: The special portion is $_GET[], which is pulling from the ? in the URL here
    $pfmID = intval(sanitize_text_field($_GET[GET_RETRIEVE_CODE]));
    //--Row query for Performances---------------------------------------------------------
    $pfmTable = "Performances";
    $sqlQuery = $wpdb->prepare("SELECT * FROM $pfmTable WHERE performance_id = %d", $pfmID);
    $pfmRow = $wpdb->get_row($sqlQuery, ARRAY_A);
    //Define main variables
    $pfmName = stripslashes($pfmRow['name']);
    //$pfmName = deslash($pfmName);
    $pfmSDate = $pfmRow['start_date'];
    $pfmEDate = $pfmRow['end_date'];
    $pfmSTime = $pfmRow['start_time'];
    $pfmETime = $pfmRow['end_time'];
    $pfmAttendance = strval($pfmRow['attendance']);
    $adult = intval($pfmRow['has_adult_content']);
    if($adult > 0) {
      $adultMessage = "For Adult Audience Only";
    }else{
      $adultMessage = "For All Audiences";
    }
    $isPublic = intval($pfmRow['is_public']);
    if($isPublic > 0) {
      $publicMessage = "Public Performance";
    }else{
      $publicMessage = "Private Performance";
    }
    //--Row query for Events----------------------------------------------------------------
    $eventID = intval($pfmRow['event_id']);
    if(!empty($eventID) AND $eventID > 0) {
      $eventTable = "Events";
      $sqlQuery = $wpdb->prepare("SELECT * FROM $eventTable WHERE event_id = %d", $eventID);
      $eventRow = $wpdb->get_row($sqlQuery, ARRAY_A);
      if(!empty($eventRow['name'])) {
        //Define Event Variables
        $hasEvent = true;
        $eventName = $eventRow['name'];
        $eventSDate = $eventRow['start_date'];
        $eventEDate = $eventRow['end_date'];
        $location = $eventRow['location'];
        //Overrides the Performance Public Setting if the Event is Private
        $eventIsPublic = intval($eventRow['is_public']);
        if($isPublic > 0 AND $eventIsPublic > 0) {
          $publicMessage = "Public Performance";
        }else{
          $publicMessage = "Private Performance";
        }
      }else{
        $hasEvent = false;
      }
    }
    $titleCode = "".
      "<span class='title1 center-text' >Performance</span>".
      "<br>".
      "<hr><br>";
    //---------- MAIN BODY ----------------
    $nameString = "Name: ". $pfmName ." ID: ". $pfmID ."";
    $filler = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
    $filler2 = "<div><br><hr><br>".
               "&#10;&#13;</div><br>";
    //title
    echo divwrap(divwrap($titleCode, $emXS),$emXS);
    echo divwrap($filler1, $emXS);
    //name and // id
    echo divwrap(centerspan($nameString), $emXS);
    echo divwrap($filler2, $emXS);
    //date
    $dateString = "Performance Dates: ".
    strval(date(DATE_FORMAT, strtotime($pfmSDate))) ." - ".
    strval(date(DATE_FORMAT, strtotime($pfmEDate)));
    echo divwrap(centerspan($dateString), $emXS);
    echo divwrap($filler2, $emXS);
    //time
    $timeString = "Performance Times: ".
    from_military_time($pfmSTime) . " - ".
    from_military_time($pfmETime);
    echo divwrap(centerspan($timeString), $emXS);
    echo divwrap($filler2, $emXS);
    //attendance
    $attendanceString = "Estimated Attendance: ". $pfmAttendance;
    echo divwrap(centerspan($attendanceString),$emXS);
    echo divwrap($filler2, $emXS);
    $adultString = "Intended Audience: ". $adultMessage;
    echo divwrap(centerspan($adultString),$emXXS);
    echo divwrap($filler2, $emXS);
    $publicString = "Performance Entry: ". $publicMessage;
    echo divwrap(centerspan($publicString),$emXS);
    echo divwrap($filler2, $emXS);
    if($hasEvent == true) {
      $eventString = "Associated Event: ". $eventName;
      echo divwrap(centerspan($eventString), $emXS);
      echo divwrap($filler2, $emXS);
      $eventDateString = "Event Dates: ".
      strval(date(DATE_FORMAT, strtotime($eventSDate))) ." - ".
      strval(date(DATE_FORMAT, strtotime($eventEDate)));
      echo divwrap(centerspan($eventDateString), $emXS);
      echo divwrap($filler2, $emXS);
      $locationString = "Location: ". $location;
      echo divwrap(centerspan($locationString), $emXS);
      echo divwrap($filler2, $emXS);
    }else{
      echo divwrap(centerspan($filler), $emXXS);
      $eventString = "No Associated Event";
      echo divwrap(centerspan($eventString), $emXS);
      echo divwrap($filler2, $emXS);
    }

    //--------END MAIN BODY----------------
    function divwrap($innerCode, $heightStr){
      $divCode = "<br><div class='squareup' style='height: ". $heightStr .";'>".
      $innerCode . "</div><br>";
      return $divCode;
    }
    function centerspan($innerMessage){
      $spanCode = "<br><span class='medium1 center-text' style='width: 50%'>". $innerMessage ."</span><br>";
      return $spanCode;
    }
/*
+-------------------+--------------+------+-----+---------+----------------+
| Field             | Type         | Null | Key | Default | Extra          |
+-------------------+--------------+------+-----+---------+----------------+
| performance_id    | int(11)      | NO   | PRI | NULL    | auto_increment |
| event_id          | int(11)      | YES  | MUL | NULL    |                |
| name              | varchar(128) | NO   |     | NULL    |                |
| start_date        | date         | YES  |     | NULL    |                |
| end_date          | date         | YES  |     | NULL    |                |
| start_time        | time         | YES  |     | NULL    |                |
| end_time          | time         | YES  |     | NULL    |                |
| has_adult_content | tinyint(1)   | YES  |     | NULL    |                |
| attendance        | int(11)      | YES  |     | NULL    |                |
| is_public         | tinyint(1)   | YES  |     | NULL    |                |
+-------------------+--------------+------+-----+---------+----------------+
+-------------+--------------+------+-----+---------+----------------+
| Field       | Type         | Null | Key | Default | Extra          |
+-------------+--------------+------+-----+---------+----------------+
| event_id    | int(11)      | NO   | PRI | NULL    | auto_increment |
| name        | varchar(128) | NO   |     | NULL    |                |
| start_date  | date         | NO   |     | NULL    |                |
| end_date    | date         | YES  |     | NULL    |                |
| description | varchar(600) | YES  |     | NULL    |                |
| location    | varchar(64)  | YES  |     | NULL    |                |
| attendance  | int(11)      | YES  |     | NULL    |                |
| is_public   | tinyint(1)   | NO   |     | 0       |                |
+-------------+--------------+------+-----+---------+----------------+

*/
?>
 </div>
</div>
<?php
    the_content();

    get_footer();

 ?>