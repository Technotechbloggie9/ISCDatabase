
<?php
/**
 * Function-name.
 * eft_head
 * Summary.
 * A function to create the head for event_form_template.php
 * Description.
 * Using heredoc formatting (<<<_TAGNAME_) to
 * format html head for later insertion
 * Required by event_form_template.php
 */
//just testing the save: no issues
//TODO: fix for enqueue
function eft_head()
{
    $headoutput = <<<_HEAD_
  <head>
  	<?php // head tag contains metadata for allowing use of calendars to pick start and end dates
  		  // SOURCE: https://jqueryui.com/datepicker/ ?>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
    // ...........dependency notice ...................
    //css and jquery libraries... unknown if jquery ui is built into remove_wordpress_version
    //must be in similar versions to work together
    //..................................................
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<link rel="stylesheet" href="/resources/demos/style.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
  		// methods to display mini calendars on form when choosing start and end dates
      //NOTE: despite YEARS of standardization of 'yyyy-mm-dd'
      //the same format is 'yy-mm-dd' in jQuery UI datepicker
      //do not change this value unless you want it to show 20212021
      //for the year 2021... it WILL do that if you do 'yyyy'
      $( function()
      {
        $( "#startdatepicker1" ).datepicker({dateFormat:'yy-mm-dd'});
      } );

      $( function()
      {
        $( "#enddatepicker1" ).datepicker({dateFormat:'yy-mm-dd'});
      } );
      $( function()
      {
        $( "#startdatepicker2" ).datepicker({dateFormat:'yy-mm-dd'});
      } );
      $( function()
  		{
  			$( "#startdatepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  		} );

  		$( function()
  		{
  			$( "#enddatepicker" ).datepicker({dateFormat:'yy-mm-dd'});
  		} );
  	</script>
    <style>
        .title1{
          font-size: 300%;
        }
        input.big1{
          line-height: 200%;
        }
        input.medium1{
          line-height: 150%;
        }
        input.normal1{
          line-height: 100%;
        }
        input.small1{
          line-height: 80%;
        }
        label.fancy1{

        }
        label.mono1{

        }
        label.official1{

        }
        label.hbig1{
          font-size: 300%;
        }
        label.big1{
          font-size: 200%;
        }
        label.medium1{
          font-size: 150%;
        }
        label.normal1{
          font-size: 100%;
        }
        label.small1{
          font-size: 80%;
        }
        .fltright{
          float: right;
        }
        .fltleft{
          float: left;
        }
    </style>
  </head>
  _HEAD_;
    return $headoutput;
}
/**
 * Function-name.
 * eft_show_form
 * Summary.
 * A function to show the form for event_form_template.php
 * Description.
 * Using heredoc formatting (<<<_TAGNAME_) to
 * format html form for display
 * Required by event_form_template.php
 */
// currently looks bad... needs updated
// may at least work better on mobile
function eft_show_form()
{
    $htmloutput = <<<_OUT_
  <div style="height: 9em;">
    <span class="title1" >Create Event</span>
    <br>
    <hr>
  </div>

  <form id="form_create1" method="POST" action="#">
    <p>
      <div class="row">
        <div class="column" style="width: 50%;">
          <div style="height: 11em;">
            <label for="txtName" class="medium1" >Enter Event Name (required)</label>
            <div>
              <input type="text" class="medium1" id="txtName" name="txtName" size="22em" maxlength="128" style="width:auto; box-shadow: 5px 5px 2px grey;" required />
            </div>
            <br>
          </div>
          <span>&nbsp&nbsp&nbsp</span>
          <div style="height: 10em;">
            <label for="startdatepicker" class="medium1">Choose Start Date (required)</label>
            <div>
              <input type="text" class="medium1" id="startdatepicker" name="startdatepicker" autocomplete="off" size="22em" style="width:auto; box-shadow: 5px 5px 2px grey;" required />
            </div>
          </div>
          <span>&nbsp&nbsp&nbsp</span>
          <div style="height: 10em;">
            <label for="enddatepicker" class="medium1">Choose End Date</label>
            <div>
              <input type="text" class="medium1" id="enddatepicker" name="enddatepicker" autocomplete="off" size="22em" style="width:auto; box-shadow: 5px 5px 2px grey;" />
            </div>
        </div>
        <span>&nbsp&nbsp&nbsp</span>
        <div class="column" style="width: 50%;">
          <div style="height: 11em;">
            <label for="txtLocation" class="medium1">Enter Location</label>
            <div>
              <input type="text" class="medium1" id="txtLocation" name="txtLocation" size="22em" maxlength="64" style="width:auto; box-shadow: 5px 5px 2px grey;" />
            </div>
            <br>
          </div>
          <span>&nbsp&nbsp&nbsp</span>

          </div>
          <span>&nbsp&nbsp&nbsp</span>
          <div style="height: 27em; margin-bottom: 3px;">
            <label for="txtDescription" class="medium1">Enter Description</label>
            <div>
              <textarea type="text" id="txtDescription" name="txtDescription" rows="11" cols="22" maxlength="250" style="width:auto; box-shadow: 5px 5px 2px grey;"></textarea>
            </div>
            <br>
          </div>
          <span>&nbsp&nbsp&nbsp</span>
          <br>
          <div style="height: 24em;">
            <label for="txtKeywords" class="medium1">Enter Keywords</label>
            <div style="margin-top: 0px; margin-bottom: 5px;">
              <label for="txtKeywords" class="normal1" style="margin-top: 15px; margin-bottom: 5px;">(enter a new line after each keyword to create multiple keywords)</label>
            </div>
            <div>
              <textarea type="text" id="txtKeywords" name="txtKeywords" rows="11" cols="22" maxlength="250" style="width:auto; box-shadow: 5px 5px 2px grey;"></textarea>
            </div>
            <br>
          </div>
          <br>
          <span>&nbsp&nbsp&nbsp</span>
          <br>
          <div style="height: 11em; margin-top: 3px; margin-bottom: 5px;">
            <label for="numAttendance" class="medium1">Enter Approximate Attendance Count</label>
            <div>
              <input type="number" id="numAttendance" name="numAttendance" min="0" max="2147483648" style="font-size: 150%" />
            </div>
            <br>
            <span>&nbsp&nbsp&nbsp</span>
          <div style="height: 8em; margin-top: 5px; margin-bottom: 5px;">
            <div>
              <label for "checkpublic" class="medium1" style="margin-right: 2em;">Make Event Public</label>
              <input type="checkbox" id="checkpublic" name="checkpublic" style="width: 2em; height: 2em;" />
            </div>
          </div>
          <span>&nbsp&nbsp&nbsp</span>
          </div>
        </div>
      </div>
    </p>

    <input type="submit" id="submit_create1" name="submit_create1" value="Submit" style="font-size: 200%; margin-top: 5px" />
  </form>
  _OUT_;
    return $htmloutput;
}
//form id = "form_create1"
//outputs:
//submit name: submit_create1
//input names: txtName, startdatepicker, txtDescription, checkpublic, txtLocation, txtKeywords, numAttendance
//input ids: same
// />/>
?>
