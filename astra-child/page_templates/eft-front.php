<?php
function divwrap1($innerCode, $heightStr){
  $divCode = "<br><div style='height: ". $heightStr .";'>".
  $innerCode . "</div><br>";
  return $divCode;
}
function labeledtxtinput1($gLabel, $gName, $gSize, $gReq = '', $gClass = 'medium1'){
  $gType = "text";
  $inputCode = "<label for='".$gName."' class='". $gClass ."' >". $gLabel . "</label>".
  "<div>".
  "  <input type='". $gType ."' class='". $gClass ."' id='". $gName ."' name='". $gName ."' size='". $gSize ."' maxlength='128' style='width:auto; box-shadow: 5px 5px 2px grey;' ".$gReq." />".
  "</div>";
  return $inputCode;
}
function labeledpicker1($gLabel, $gName, $gSize, $gReq = '', $gClass = 'medium1'){
  $gType = "text";
  $inputCode = "<label for='".$gName."' class='". $gClass ."' >". $gLabel . "</label>".
  "<div>".
  "  <input type='". $gType ."' class='". $gClass ."' id='". $gName ."' name='". $gName ."' autocomplete='off' size='". $gSize ."' maxlength='128' style='width:auto; box-shadow: 5px 5px 2px grey;' ".$gReq." />".
  "</div>";
  return $inputCode;
}
function eft_front_form(){
  $emSize = "22em";
  $titleCode = "".
    "<span class='title1'>Event Request</span>".
    "<br>".
    "<hr>";
  $scriptoutput = <<<_JSSCRIPT_
    <script>
      // methods to display mini calendars on form when choosing start and end dates
      //NOTE: despite YEARS of standardization of 'yyyy-mm-dd'
      //the same format is 'yy-mm-dd' in jQuery UI datepicker
      //do not change this value unless you want it to show 20212021
      //for the year 2021... it WILL do that if you do 'yyyy'


    </script>
_JSSCRIPT_;
  $htmloutput = $scriptoutput ."".
  divwrap1($titleCode, '2em') ."".
  "<form id='form_front' method='POST' action='#'>".
  "  <p>".
  "    <div class='row'>".
  "      <div class='column' style='width: 50%;'>".
  "<span class='normal1 mono1'>Do not leave form blank, as this process is intended to check for duplicates</span>".
  divwrap1(labeledtxtinput1("Enter Event Name (required)", "txtName2", $emSize, "required"),"10em") . "". //function labeledtxtinput($gLabel, $gName, $gSize, $gValue = "", $gReq = "", $gClass = "medium1")
  "          <span>&nbsp&nbsp&nbsp</span>".
  divwrap1(labeledpicker1("Choose Start Date (required)", "startdatepicker2", $emSize, "required"), "10em") . "".
  "          <span>&nbsp&nbsp&nbsp</span>".
  "    </div>".
  "  </div>".
  "</p>".
  "<input type='submit' id='submit_front' name='submit_front' value='Create/Edit' style='font-size: 200%; margin-top: 5px' /><br><br>".
  "<input type='submit' id='submit_delete' name='submit_delete' value='Delete' style='font-size: 200%; margin-top: 5px' />".
  "</form>";
  return $htmloutput;
}
 ?>