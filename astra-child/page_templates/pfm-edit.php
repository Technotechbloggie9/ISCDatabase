<?php
function pfm_edit_form($pfmID, $pfmName, $startDate, $endDate, $startTime, $endTime, $attendance, $eventName, $eventStartDate){
    $htmloutput = "".
    "<script>".
    "\r\n".    //methods to display time picker when choosing start and end times.
    "\r\n".   //possibly calling same library twice in two forms
    "\r\n".    //it was hard to find proper format for this timepicker 'hh:mm TT'
    "    $( function()"."\r\n".
    "    {"."\r\n".
    "      $( '#starttimepicker1' ).timepicker({timeFormat: 'hh:mm TT'});"."\r\n".
    "    } );"."\r\n".
    "\r\n".
    "    $( function()"."\r\n".
    "    {"."\r\n".
    "      $( '#endtimepicker1' ).timepicker({timeFormat: 'hh:mm TT'});"."\r\n".
    "    } );"."\r\n".
    "".    // methods to display mini calendars on form when choosing start and end dates
    "".    //NOTE:
    "".    //for 'yyyy-mm-dd'
    "".    //the same format is 'yy-mm-dd' in jQuery UI datepicker
    "".    //do not change this value unless you want it to show 20212021
    "".    //for the year 2021... it WILL do that if you do 'yyyy'
    "\r\n".
    "    $( function()"."\r\n".
    "    {"."\r\n".
    "      $( '#startdatepicker1' ).datepicker({dateFormat:'yy-mm-dd'});"."\r\n".
    "    } );"."\r\n".
    "    $( function()"."\r\n".
    "    {"."\r\n".
    "      $('#starteventdatepicker1' ).datepicker({dateFormat:'yy-mm-dd'});"."\r\n".
    "    } );"."\r\n".
    "    $( function()"."\r\n".
    "    {"."\r\n".
    "      $( '#enddatepicker1' ).datepicker({dateFormat:'yy-mm-dd'});"."\r\n".
    "    } );"."\r\n".
    "</script>".
    "<div style='height: 9em;'>".
    "  <span class='title1'>Edit Performance with ID: ". $pfmID ."</span>".
    "  <br>".
    "  <hr>".
    "</div>".
    "<span>&nbsp&nbsp&nbsp</span>".
    "<form id='form_createpm' method='POST' enctype='multipart/form-data' action='#'>".
    "<div style='height: 11em;'>".
    "  <label for='txtName1' class='medium1' >Edit Performance Name (required)</label>".
    "  <div>".
    "    <input type='text' class='medium1' id='txtName1' name='txtName1' value='". $pfmName ."' size='22em' maxlength='128' style='width:auto; box-shadow: 5px 5px 2px grey;' required />".
    "  </div>".
    "  <br>".
    "</div>".
    "    <br>".
    "    <span>&nbsp&nbsp&nbsp</span>".
    "    <div style='height: 10em;'>".
    "      <label for='startdatepicker1' class='medium1'>Choose Start Date</label>".
    "      <div>".
    "        <input type='text' class='medium1' id='startdatepicker1' name='startdatepicker1' value='". $startDate ."' autocomplete='off' size='22em' style='width:auto; box-shadow: 5px 5px 2px grey;'/>".
    "      </div>".
    "    </div>".
    "    <br>".
    "    <span>&nbsp&nbsp&nbsp</span>".
    "    <div style='height: 10em;'>".
    "          <label for='enddatepicker1' class='medium1'>Choose End Date</label>".
    "          <div>".
    "               <input type='text' class='medium1' id='enddatepicker1' value='". $endDate ."' name='enddatepicker1' autocomplete='off' size='22em' style='width:auto; box-shadow: 5px 5px 2px grey;'/>".
    "          </div>".
    "    </div>".
    "    <span>&nbsp&nbsp&nbsp</span>".
    "    <div style='height: 10em;'>".
    "      <label for='starttimepicker1' class='medium1'>Choose Start Time</label>".
    "      <div>".
    "        <input type='text' class='medium1' id='starttimepicker1' name='starttimepicker1' value='". $startTime ."' autocomplete='off' size='22em' style='width:auto; box-shadow: 5px 5px 2px grey;'/>".
    "      </div>".
    "    </div>".
    "    <span>&nbsp&nbsp&nbsp</span>".
    "    <div style='height: 10em;'>".
    "      <label for='endtimepicker1' class='medium1'>Choose End Time</label>".
    "      <div>".
    "        <input type='text' class='medium1' id='endtimepicker1' name='endtimepicker1' value='". $endTime ."'autocomplete='off' size='22em' style='width:auto; box-shadow: 5px 5px 2px grey;'/>".
    "      </div>".
    "    </div>".
    "    <div style='height: 11em;'>".
    "      <label for='numAttendance1' class='medium1'>Enter Approximate Attendance Count</label>".
    "      <div>".
    "        <input type='number' id='numAttendance1' name='numAttendance1' value='". $attendance ."' min='0' max='2147483648' style='font-size: 150%' />".
    "      </div>".
    "    </div>".
    "    <div style='height: 8em;'>".
    "      <div>".
    "        <label for 'checkpublic1' class='medium1' style='margin-right: 2em;'>Make Performance Public</label>".
    "        <span class='normal1 mono1'>(Will Not Override Private Event Setting)</span>".
    "        <input type='checkbox' id='checkpublic1' name='checkpublic1' style='width: 2em; height: 2em;'/>".
    "      </div>".
    "    </div>".
    "    <div style='height: 8em;'>".
    "      <div>".
    "        <label for 'checkadult1' class='medium1' style='margin-right: 2em;'>Contains Adult Content</label>".
    "        <input type='checkbox' id='checkadult1' name='checkadult1' style='width: 2em; height: 2em;'/>".
    "      </div>".
    "    </div>".
    "    <span>&nbsp&nbsp&nbsp</span>".
    "    <div style='height: 28em;'>".
    "        <label for='txtKeywords1' class='medium1'>Add Keywords</label>".
    "        <div style='margin-top: -10px; margin-bottom: 1em;'>".
    "            <span class='normal1 mono1' style='margin-top: 1em;'>".
    "            (enter a new line after each keyword to create multiple keywords)".
    "            </span>".
    "        </div>".
    "        <div>".
    "            <textarea type='text' id='txtKeywords1' name='txtKeywords' rows='11' cols='22' style='width:auto; box-shadow: 5px 5px 2px grey;''></textarea>".
    "        </div>".
    "    </div>".
    "    <br>".
    "    <span>&nbsp&nbsp&nbsp</span>".
    "    <div>".
    "      <hr>".
    "      <br>".
    "      <span class='title1'>Associate With Event</span>".
    "      <br>".
    "      <hr>".
    "    </div>".
    "    <br>".
    "    <div style='height: 10em;'>".
    "      <label for='txtEventName1' class='medium1'>Enter Event Name</label>".
    "      <div>".
    "        <input type='text' class='medium1' id='txtEventName1' name='txtEventName' value='". $eventName ."' size='22em' />".
    "      </div>".
    "    </div>".
    "    <span>&nbsp&nbsp&nbsp</span>".
    "    <div style='height: 10em;'>".
    "      <label for='starteventdatepicker1' class='medium1'>Choose Event Start Date</label>".
    "      <div>".
    "        <input type='text' class='medium1' id='starteventdatepicker1' name='starteventdatepicker1' value='". $eventStartDate ."' autocomplete='off' size='22em' style='width:auto; box-shadow: 5px 5px 2px grey;'/>".
    "      </div>".
    "    </div>".
    "    <span>&nbsp&nbsp&nbsp</span>".
    "    <br>".
    "    <input type='submit' id='submit_createpm' name='submit_createpm' value='Submit' style='font-size: 200%;'/>".
    "    </input>".
    "</form>";

    return $htmloutput;
  }
 ?>