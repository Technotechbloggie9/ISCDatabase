<?php
/**
*Function-name.
*pfm_head
*Summary.
*A function to create the head for event_form_template.php
*Description.
*Using heredoc formatting (<<<_TAGNAME_) to
*format html head for later insertion
*Required by performer_form_template.php
*
*/
/*
enqueue example external script
add_action('wp_enqueue_scripts', 'test');
function test() {
  wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?&sensor=false', array(), '3', true);
}
problem specific, but internal script
add_action('wp_enqueue_scripts', 'custom_datepicker');
function custom_datepicker() {
    //wp_enqueue_script('jquery-ui-datepicker');
    //wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-timepicker-addon',get_stylesheet_directory_uri().'/js/jquery-ui-timepicker-addon.js',array());
    wp_enqueue_style('jquery-ui-timepicker-addon',get_stylesheet_directory_uri().'/css/jquery-ui-timepicker-addon.css',array());
    wp_enqueue_style('jquery-ui',get_stylesheet_directory_uri().'/css/jquery-ui.css',array());
}
calling script for custom datetimepicker
<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#datetime').datetimepicker({
          timeFormat: "hh:mm",
          dateFormat : 'yy-mm-dd'
        });
    });
</script>
relevant addresses
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
*/

function pfm_head(){


  $headoutput = <<<_HEAD_
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link rel="stylesheet" href="/resources/demos/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.5.5/jquery-ui-timepicker-addon.min.css">
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.5.5/jquery-ui-timepicker-addon.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.5.5/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.5.5/jquery-ui-sliderAccess.min.js"></script>

      <style>
        .title1{
          font-size: 250%;
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
          font-family: "Apple Chancery", "Monotype Corsiva", cursive;
        }
        .mono1{
          font-family: "Mono", Mono, monospace;
        }
        label.official1{
          font-family: "Times New Roman", Times, serif;
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
        span.medium1{
          font-size: 150%;
        }
        .normal1{
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
    function pfm_show_form(){
        $htmloutput = <<<_OUT_
        <script>
            //methods to display time picker when choosing start and end times
            //possibly calling same library twice in two forms
            //it was hard to find proper format for this timepicker 'hh:mm TT'
            $( function()
            {
              $( "#starttimepicker" ).timepicker({timeFormat: 'hh:mm TT'});
            } );

            $( function()
            {
              $( "#endtimepicker" ).timepicker({timeFormat: 'hh:mm TT'});
            } );



            // methods to display mini calendars on form when choosing start and end dates
            //NOTE:
            //for 'yyyy-mm-dd'
            //the same format is 'yy-mm-dd' in jQuery UI datepicker
            //do not change this value unless you want it to show 20212021
            //for the year 2021... it WILL do that if you do 'yyyy'
            $( function()
            {
              $( "#startdatepicker" ).datepicker({dateFormat:'yy-mm-dd'});
            } );
            $( function()
            {
              $( "#starteventdatepicker" ).datepicker({dateFormat:'yy-mm-dd'});
            } );
            $( function()
            {
              $( "#enddatepicker" ).datepicker({dateFormat:'yy-mm-dd'});
            } );
        </script>
        <div style="height: 9em;">
          <span class="title1">Create Performance</span>
          <br>
          <hr>
        </div>
        <span>&nbsp&nbsp&nbsp</span>
        <form id="form_createpm" method="POST" enctype="multipart/form-data" action="#">
        <div style="height: 11em;">
          <label for="txtName" class="medium1" >Enter Performance Name (required)</label>
          <div>
            <input type="text" class="medium1" id="txtName" name="txtName" size="22em" maxlength="128" style="width:auto; box-shadow: 5px 5px 2px grey;" required />
          </div>
          <br>
        </div>
            <br>
            <span>&nbsp&nbsp&nbsp</span>
            <div style="height: 10em;">
              <label for="startdatepicker" class="medium1">Choose Start Date</label>
              <div>
                <input type="text" class="medium1" id="startdatepicker" name="startdatepicker" autocomplete="off" size="22em" style="width:auto; box-shadow: 5px 5px 2px grey;"/>
              </div>
            </div>
            <br>
            <span>&nbsp&nbsp&nbsp</span>
            <div style="height: 10em;">
                  <label for="enddatepicker" class="medium1">Choose End Date</label>
                  <div>
                       <input type="text" class="medium1" id="enddatepicker" name="enddatepicker" autocomplete="off" size="22em" style="width:auto; box-shadow: 5px 5px 2px grey;"/>
                  </div>
            </div>
            <span>&nbsp&nbsp&nbsp</span>
            <div style="height: 10em;">
              <label for="starttimepicker" class="medium1">Choose Start Time</label>
              <div>
                <input type="text" class="medium1" id="starttimepicker" name="starttimepicker" autocomplete="off" size="22em" style="width:auto; box-shadow: 5px 5px 2px grey;"/>
              </div>
            </div>
            <span>&nbsp&nbsp&nbsp</span>
            <div style="height: 10em;">
              <label for="endtimepicker" class="medium1">Choose End Time</label>
              <div>
                <input type="text" class="medium1" id="endtimepicker" name="endtimepicker" autocomplete="off" size="22em" style="width:auto; box-shadow: 5px 5px 2px grey;"/>
              </div>
            </div>
            <div style="height: 11em;">
              <label for="numAttendance" class="medium1">Enter Approximate Attendance Count</label>
              <div>
                <input type="number" id="numAttendance" name="numAttendance" min="0" max="2147483648" style="font-size: 150%" />
              </div>
            </div>
            <div style="height: 8em;">
              <div>
                <label for "checkpublic" class="medium1" style="margin-right: 2em;">Make Performance Public</label>
                <span class="normal1 mono1">(Will Not Override Private Event Setting)</span>
                <input type="checkbox" id="checkpublic" name="checkpublic" style="width: 2em; height: 2em;"/>
              </div>
            </div>
            <div style="height: 8em;">
              <div>
                <label for "checkadult" class="medium1" style="margin-right: 2em;">Contains Adult Content</label>
                <input type="checkbox" id="checkadult" name="checkadult" style="width: 2em; height: 2em;"/>
              </div>
            </div>
            <span>&nbsp&nbsp&nbsp</span>
            <div style="height: 28em;">
                <label for="txtKeywords" class="medium1">Enter Keywords</label>
                <div style="margin-top: -10px; margin-bottom: 1em;">
                    <span class="normal1 mono1" style="margin-top: 1em;">
                    (enter a new line after each keyword to create multiple keywords)
                    </span>
                </div>
                <div>
                    <textarea type="text" id="txtKeywords" name="txtKeywords" rows="11" cols="22" style="width:auto; box-shadow: 5px 5px 2px grey;"></textarea>
                </div>
            </div>
            <br>
            <span>&nbsp&nbsp&nbsp</span>
            <div>
              <hr>
              <br>
              <span class="title1">Associate With Event</span>
              <br>
              <hr>
            </div>
            <br>
            <div style="height: 10em;">
              <label for="txtEventName" class="medium1">Enter Event Name</label>
              <div>
                <input type="text" class="medium1" id="txtEventName" name="txtEventName" size="22em" />
              </div>
            </div>
            <span>&nbsp&nbsp&nbsp</span>
            <div style="height: 10em;">
              <label for="starteventdatepicker" class="medium1">Choose Event Start Date</label>
              <div>
                <input type="text" class="medium1" id="starteventdatepicker" name="starteventdatepicker" autocomplete="off" size="22em" style="width:auto; box-shadow: 5px 5px 2px grey;"/>
              </div>
            </div>
            <span>&nbsp&nbsp&nbsp</span>
            <br>
            <input type="submit" id="submit_createpm" name="submit_createpm" value="Submit" style="font-size: 200%;"/>
            </input>
        </form>
        _OUT_;
        return $htmloutput;
        /*
        NOTE:
        Form: form_createpm
        Submit: submit_createpm
        Outputs:
        txtName,
        startdatepicker,
        enddatepicker,
        starttimepicker,
        endtimepicker,
        numAttendance,
        checkpublic,
        checkadult,
        txtKeywords,
        txtEventName,
        starteventdatepicker
        */
    }


?>