<?php

function divwrap($innerCode, $heightStr){
  $divCode = "<br><div style='height: ". $heightStr .";'>".
  $innerCode . "</div><br>";
  return $divCode;
}
function labeledtxtinput($gLabel, $gName, $gSize, $gValue = '', $gReq = '', $gClass = 'medium1'){
  $gType = "text";
  $inputCode = "<label for='".$gName."' class='". $gClass ."' >". $gLabel . "</label>".
  "<div>".
  "  <input type='". $gType ."' class='". $gClass ."' id='". $gName ."' name='". $gName ."' value='". $gValue ."' size='". $gSize ."' maxlength='128' style='width:auto; box-shadow: 5px 5px 2px grey;' ".$gReq." />".
  "</div>";
  return $inputCode;
}
function labeledpicker($gLabel, $gName, $gSize, $gValue = '', $gReq = '', $gClass = 'medium1'){
  $gType = "text";
  $inputCode = "<label for='".$gName."' class='". $gClass ."' >". $gLabel . "</label>".
  "<div>".
  "  <input type='". $gType ."' class='". $gClass ."' id='". $gName ."' name='". $gName ."' value='". $gValue ."' autocomplete='off' size='". $gSize ."' maxlength='128' style='width:auto; box-shadow: 5px 5px 2px grey;' ".$gReq." />".
  "</div>";
  return $inputCode;
}
function labelednuminput($gLabel, $gName, $gValue = "", $gClass = "medium1"){
  $gType = "number";

  $inputCode  = "<label for='".$gName."' class='". $gClass ."' >". $gLabel . "</label>".
  "<div>".
  "  <input type='". $gType ."' id='". $gName ."' name='". $gName ."' value='". $gValue ."' min='0' max='2147483648' style='font-size: 150%' />".
  "</div>";
  return $inputCode;
}

function eft_edit_form($eventID, $eventName, $startDate, $endDate, $description, $location, $attendance)
{

  $titleCode = "".
    "<span class='title1' >Edit Event with ID: ". $eventID ."</span>".
    "<br>".
    "<hr>";
  $emSize = "22em";
  $idCode = divwrap(labeledtxtinput("", "txtID1", $emSize, $eventID, "hidden"),"2em");
  $eventCode = divwrap(labeledtxtinput("Edit Event Name (required)", "txtName1", $emSize, $eventName, "required"),"10em");
  $sDateCode = divwrap(labeledpicker("Choose Start Date (required)", "startdatepicker1", $emSize, $startDate, "required"), "10em");
  $eDateCode = divwrap(labeledpicker("Choose End Date", "enddatepicker1", $emSize, $endDate), "10em");
  $locCode = divwrap(labeledtxtinput("Edit Location", "txtLocation1", $emSize, $location),"10em");
  $descCode = "".
  "      <div style='height: 27em; margin-bottom: 3px;'>".
  "        <label for='txtDescription1' class='medium1'>Edit Description</label>".
  "        <div>".
  "          <textarea type='text' id='txtDescription1' name='txtDescription1' rows='11' cols='22' maxlength='250' style='width:auto; box-shadow: 5px 5px 2px grey;'>". $description ."</textarea>".
  "        </div>".
  "        <br>".
  "      </div>";
  $keyCode = "".
  "      <div style='height: 24em;'>".
  "        <label for='txtKeywords' class='medium1'>Add Keywords</label>".
  "        <div style='margin-top: 0px; margin-bottom: 5px;'>".
  "          <span class='normal1' style='margin-top: 15px; margin-bottom: 5px;'>(enter a new line after each keyword to create multiple keywords)</span>".
  "        </div>".
  "        <div>".
  "          <textarea type='text' id='txtKeywords' name='txtKeywords' rows='11' cols='22' maxlength='250' style='width:auto; box-shadow: 5px 5px 2px grey;'></textarea>".
  "        </div>".
  "        <br>".
  "      </div>";
  $attendCode = labelednuminput("Enter Approximate Attendance Count", "numAttendance1", $attendance);
  $htmloutput = "".
      divwrap($titleCode, '2em') ."".
      "<form id='form_edit1' method='POST' action='#'>".
      "  <p>".
      "    <div class='row'>".
      "      <div class='column' style='width: 50%;'>".
      $eventCode . "".
      "          <span>&nbsp&nbsp&nbsp</span>".
      $sDateCode . "".
      "          <span>&nbsp&nbsp&nbsp</span>".
      $eDateCode . "".
      "          <span>&nbsp&nbsp&nbsp</span>".
      "      <div class='column' style='width: 50%;'>".
      $locCode . "".
      "          <span>&nbsp&nbsp&nbsp</span>".
      "      </div>".
      "      <span>&nbsp&nbsp&nbsp</span>".
      $descCode . "".
      "      <span>&nbsp&nbsp&nbsp</span>".
      "      <br>".
      $keyCode . "".
      "      <br>".
      "      <span>&nbsp&nbsp&nbsp</span>".
      "      <br>".
      "      <div style='height: 11em; margin-top: 3px; margin-bottom: 5px;'>".
      $attendCode . "".
      "      </div>".
      "      <br>".
      "      <span>&nbsp&nbsp&nbsp</span>".
      "      <div style='height: 8em; margin-top: 5px; margin-bottom: 5px;'>".
      "        <div>".
      "          <label for 'checkpublic1' class='medium1' style='margin-right: 2em;'>Make Event Public</label>".
      "          <input type='checkbox' id='checkpublic1' name='checkpublic1' style='width: 2em; height: 2em;' />".
      "        </div>".
      "      </div>".
      "      <span>&nbsp&nbsp&nbsp</span>".
      "    </div>".
      "  </div>".
      $idCode . "".
      "</p>".
      "<input type='submit' id='submit_edit1' name='submit_edit1' value='Submit' style='font-size: 200%; margin-top: 5px' />".
      "</form>";

  return $htmloutput;
}
/*
Submit:
submit_edit1
Outputs:
txtName1, startdatepicker1, enddatepicker1,
txtLocation1, txtDescription1, txtKeywords,
numAttendance1, checkpublic1

*/
?>