
<?php
/**
*Function-name.
*eft_head
*Summary.
*A function to create the head for event_form_template.php
*Description.
*Using heredoc formatting (<<<_TAGNAME_) to
*format html head for later insertion
*Required by event_form_template.php
*
*/
function eft_head(){
  $headoutput = <<<_HEAD_
  <head>
  	<?php // head tag contains metadata for allowing use of calendars to pick start and end dates
  		  // SOURCE: https://jqueryui.com/datepicker/ ?>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<link rel="stylesheet" href="/resources/demos/style.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	<script>
  		// methods to display mini calendars on form when choosing start and end dates
  		$( function()
  		{
  			$( "#startdatepicker" ).datepicker();
  		} );

  		$( function()
  		{
  			$( "#enddatepicker" ).datepicker();
  		} );
  	</script>
  </head>
  _HEAD_;
  return $headoutput;
}
/**
*Function-name.
*eft_show_form
*Summary.
*A function to show the form for event_form_template.php
*Description.
*Using heredoc formatting (<<<_TAGNAME_) to
*format html form for display
*Required by event_form_template.php
*
*/

function eft_show_form(){
  $htmloutput = <<<_OUT_
    <div style="height: 100px;">
      <label style="font-size: 50px">Create Event</label>
      <hr>
    </div>

    <form method="POST" action="#">
      <p>
      <div class="row">
        <div class="column" style="float: left; width: 50%;">
          <div style="height: 130px;">
            <label for="txtName" style="font-size: 30px">Enter Event Name (required)</label>
            <div>
              <input type="text" id="txtName" name="txtName" size="60" maxlength="128" style="width:auto; box-shadow: 5px 5px 2px grey;" required />
            </div>
            <br>
          </div>

          <div style="height: 120px;">
            <label for="startdatepicker" style="font-size: 30px">Choose Start Date (required)</label>
            <div>
              <input type="text" id="startdatepicker" name="startdatepicker" autocomplete="off" size="60" style="width:auto; box-shadow: 5px 5px 2px grey;" required>
            </div>
            <br>
          </div>

          <div style="height: 320px;">
            <label for="txtDescription" style="font-size: 30px">Enter Description</label>
            <div>
              <textarea type="text" id="txtDescription" name="txtDescription" rows="8" cols="62" maxlength="250" style="width:auto; box-shadow: 5px 5px 2px grey;"></textarea>
            </div>
            <br>
          </div>

          <div style="height: 90px;">
            <div>
              <label for "checkpublic" style="font-size: 30px; margin-right: 20px;">Make Event Public</label>
              <input type="checkbox" id="checkpublic" name="checkpublic" style="width: 25px; height: 25px;"/>
            </div>
          </div>

          <input type="submit" name="submit" value="Submit" style="font-size: 25px;">

        </div>
        <div class="column" style="float: left; width: 50%;">
          <div style="height: 130px;">
            <label for="txtLocation" style="font-size: 30px">Enter Location</label>
            <div>
              <input type="text" id="txtLocation" name="txtLocation" size="60" maxlength="64" style="width:auto; box-shadow: 5px 5px 2px grey;"/>
            </div>
            <br>
          </div>

          <div style="height: 120px;">
            <label for="enddatepicker" style="font-size: 30px">Choose End Date</label>
            <div>
              <input type="text" id="enddatepicker" name="enddatepicker" autocomplete="off" size="60" style="width:auto; box-shadow: 5px 5px 2px grey;">
            </div>
            <br>
          </div>

          <div style="height: 290px;">
            <label for="txtKeywords" style="font-size: 30px">Enter Keywords</label>
            <div style="margin-top: -10px; margin-bottom: 5px;">
              <label for="txtKeywords" style="font-size: 15px; margin-top: 15px;">(enter a new line after each keyword to create multiple keywords)</label>
            </div>
            <div>
              <textarea type="text" id="txtKeywords" name="txtKeywords" rows="6" cols="62" maxlength="250" style="width:auto; box-shadow: 5px 5px 2px grey;"></textarea>
            </div>
            <br>
          </div>

          <div style="height: 130px;">
            <label for="numAttendance" style="font-size: 30px">Enter Approximate Attendance Count</label>
            <div>
              <input type="number" id="numAttendance" name="numAttendance" min="0" max="2147483648" style="font-size: 15px" />
            </div>
            <br>
          </div>
        </div>
      </div>
    </p>
  </form>
  _OUT_;
  return $htmloutput;
}
?>
