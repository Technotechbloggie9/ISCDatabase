<?php
    /*
        Template Name:     Event Form Template
        Website:         ISC
        Description:    Template for the Event creation form
        Last Edited:     6/8/2021
    */
    // TODO: section tag styling into separate CSS file
    // TODO: test the refactor, this *should* work without config.php
    // which contains database connection code, and the domain/IP address of the website to redirect to
    /*
    require
    --------
    eft-show
        contains display functions for this Template
        these are formatted and returned as strings
    ----------------------------------------------------------
    utility
        contains useful functions for this and other templates
        mk_sanitize_date is a custom function that uses regex preg_replace
        to remove extra characters from date
    */
    require "eft-show.php";
    require "eft-edit.php";
    require "eft-front.php";
    require "utility.php";
    /*global object
    ---------------
    $wpdb
      used to interact with database for WordPress
      tends to be stable in migration
      has useful built-in methods
      derived from msqli but simplifies
      its operations
    ----------------
    Forms Processing
    	if form_is_not_submitted
		show_the_form()
	if form_is_submitted
		process_the_form() //via the database
    */



            // duplication checking
            // TODO: check database to see if event already exists by checking event name and start date
            //            if it exists, display both that events's name and start/end dates AND that of the
            //            event user attempted to enter by a popup dialog box, and let the user chose which
            //            event to keep and which to discard.
            //            when implemented, an if/else needs to surround the rest of the code below, so if the user
            //            decides to keep what's already in the database, a new event wouldnt need to be inputted.
            //TODO: put into function, develop source for variables
            //-------- $WPBD prepare and query ---------------------------
            // create event entry to insert into database:
            // Prepare an insert statement to insert an event into the database

    $headvar = eft_head();
    echo $headvar;
    // astra method to summon website styled header
    get_header();
?>

<div id="primary" class="site-content-fullwidth">
<?php
    global $wpdb;
    // astra methods to summon website styled pages
    astra_primary_content_top();
    astra_primary_content_bottom();
    //refactored form starting from 5/31/2021
    //initialize errorMessage to NULL
    $errorMessage = NULL;
    //processing logic, if posted do process
    //if not posted (default) show form
    //forgot the underscore in $_SERVER... caused a lot of grief

//----------  MAIN BODY  -----------

    $count1 = 0;
    if($_SERVER['REQUEST_METHOD'] == 'POST'
    AND isset($_POST['submit_create1'])
    ) {
        //AND $serviceRequest == 'CREATE'
        //echo '<script>alert("The post method has been used");</script>';
        $event_ID = process_create1($errorMessage);
            //sleep(20);
        //echo '<script>alert("we are back in the MAIN");</script>';
        //header("Location:" . get_bloginfo('url') . "/event?id=" . $event_ID);
        //exit();
        echo "<a href='". get_bloginfo('url')."/event?id=" . $event_ID . "' style='margin: 10px; text-decoration: underline;'>View Result</a>";
    }else if($_SERVER['REQUEST_METHOD'] == 'POST'
    AND isset($_POST['submit_front'])) {
    //AND $serviceRequest == 'NONE') {
        //--Initialize to Default-------------
        $eventID = $attendance = 0;
        $eventName = $location = "";
        $startDate = $endDate = "0000-00-00";
        //------------------------------------

        $findResult = find_event();
        $returnedResult = $findResult['RESULT'];
        echo '<script>alert("'. $returnedResult .'");</script>';
        if ($returnedResult == "FOUND") {
          //echo '<script>alert("still alive 1");</script>';
          $eventID = $findResult['ID'];

          $eventName = $findResult['NAME'];
          //echo '<script>alert("still alive 3");</script>';
          $startDate = $findResult['SDATE'];
          //echo '<script>alert("still alive 4");</script>';
          $endDate = $findResult['EDATE'];
          //echo '<script>alert("still alive 5");</script>';
          $description = $findResult['DESCRIBE'];
          //echo '<script>alert("still alive 6");</script>';
          $location = $findResult['LOC'];
          //echo '<script>alert("still alive 7");</script>';
          $attendance = $findResult['ATTEND'];
          //echo '<script>alert("still alive 8");</script>';
          $display_event_form = eft_edit_form($eventID, $eventName, $startDate, $endDate, $description, $location, $attendance);
          //echo '<script>alert("still alive 9");</script>';
          $serviceRequest = 'EDIT';
          echo $display_event_form;


        }else if ($returnedResult == "NOTFOUND"){
          $display_event_form = eft_show_form();
          $serviceRequest = 'CREATE';
          echo $display_event_form;
        }else if ($returnedResult == "DUPLICATE"){
          echo '<script>alert("Delete this record, as it has been duplicated");</script>';
          $serviceRequest = 'DEL';
        }else{
          echo '<script>alert("An error has occurred");</script>';
        }
    }else if($_SERVER['REQUEST_METHOD'] == 'POST'
    AND isset($_POST['submit_edit1'])) {
        //AND $serviceRequest == 'EDIT')
        $eventID = $_POST["txtID1"];
        //echo alert_st("Processing is occurring");
        //echo '<script>alert("Event ID : '. $eventID .'");</script>';
        process_edit1($eventID);

    }else if((($_SERVER['REQUEST_METHOD'] == 'POST') AND isset($_POST['submit_delete'])) OR ($serviceRequest == 'DEL' AND isset($_POST['DELETECONFIRM']))) {
        $serviceRequest = 'DEL';
        $findResult = find_event();
        $isfound = $findResult['RESULT'];

        if( $isfound == 'FOUND') {
          $eventID = $findResult['ID'];
          echo '<script>alert("Event ID: '.$eventID.' is '. $isfound .'");</script>';
        }else{
          echo '<script>alert("This event was not found.")</script>';

        }
          //rewritten as jQuery
          /*
          $jsConfirm = <<<_JSBOX_
                      <script>
                      let response = 'NO';
                      let confirmAction = confirm("Are you sure you want to delete this record?");
                      let response = confirmAction ? 'YES': 'NO';
                      var xhttp = new XMLHttpRequest();
                      xhttp.open("POST", "", true);
                      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                      xhttp.send("DELETECONFIRM=YES");
                      </script>"
         _JSBOX_;

          echo $jsConfirm;
          */
          //echo alert_st($_POST['DELETECONFIRM']);
          //if($_SERVER['REQUEST_METHOD'] == 'POST' AND $_POST['DELETECONFIRM'] == 'YES') {
        $count1 = 1;
        $sqlQuery = $wpdb->prepare("DELETE from Events WHERE event_id = %d", $eventID);
        $done = $wpdb->delete('Events', array('event_id' => $eventID) );
        //$done = $wpdb->query($sqlQuery);
        if(is_int($done)) {
          echo '<script>alert("Event with ID: '. $eventID .' was deleted successfully.");</script>';

        }else{
          echo '<script>alert("No record to delete.");</script>';
        }
        $display_front_form = eft_front_form();
        echo $display_front_form;
    }elseif((empty($_POST['txtName']) AND $serviceRequest == "CREATE") OR (empty($_POST['startdatepicker']) AND $serviceRequest == "CREATE")) {
        $errorMessage = "<p>You must enter an event name and its start date.</p>";
        echo $errorMessage;
        $display_event_form = eft_show_form();
        echo $display_event_form;
    }else{
        $serviceRequest = "NONE";
        //echo alert_st("start or else condition");
        $display_front_form = eft_front_form();
        echo $display_front_form;
    }//else
    //elementor function
    the_content();
//-------  END MAIN BODY -------------
/*
Function: process_create1
Description:
            Used to validate form
            and to perform sql queries
*/
        function process_create1($errorMessage)
        {
            //required for each function
            global $wpdb;
            //pre-initialize variables
            $name = $description = $location = "";
            $start_date = $end_date = "";
            $attendance = null;
            $is_public = 0;
            //echo '<script>alert("The create process has been called");</script>';
            $errorMessage = null;
            /*NOTE:
            added sanitization on 6/10/2021
            */
            // variables to pass the information to the database:
            // name and start date of the event
            //------------------get posted information, or set null----------------------------------------------
            $name = sanitize_text_field($_POST['txtName']);
            echo '<script>alert("value for name may shown");</script>';
            $namescript = '<script>alert(" ' . $name . ' ");</script>';
            echo $namescript;

            /*NOTE:
            the conversion to timestamp as shown here:
            date("Y-m-d", strtotime($_POST["startdatepicker"]))
            is no longer needed,
            since datepicker has a working function for dateFormat
            this was not simple to find,
            as most tutorials show format...
            [which does not work]
            w/o this issue,
            the format can be corrected in the datepicker itself
            now $_POST["startdatepicker"] can be used with no issues
            */
            //the script went silent here... why?
            $start_date = mk_sanitize_date($_POST["startdatepicker"]);
            // end date, description, location, attendance, and public if available
            $end_date = mk_sanitize_date($_POST["enddatepicker"]);
            $description = sanitize_text_field(strval($_POST["txtDescription"]));
            $location = sanitize_text_field(strval($_POST["txtLocation"]));
            $attendance = intval(sanitize_text_field($_POST['numAttendance']));
            if(!empty($_POST['checkpublic'])) {
              $is_public = 1;
            }
            //---------------------------------------------------------------------------------------------------
            /*NOTE:
            prefix may not be needed, depends on settings
            this results in usage of brackets,
            if the current code fails, this will be removed
            */
            //----process query if not empty

            $event_table = "Events";
            //"{$wpdb->prefix}Events";
            $sqlQuery = $wpdb->prepare(
            "INSERT INTO $event_table (name, start_date, end_date, description, location, attendance, is_public)
						values (%s, %s, %s, %s, %s, %d, %d)", $name, $start_date, $end_date, $description, $location, $attendance, $is_public
            );
            //$wpdb->showerrors();
            //echo '<script>alert(" Query is:'. $sqlQuery .'");</script>';
            $done = $wpdb->query($sqlQuery);

                //check for some result of query
                /*NOTE:
                Date is in string format 'yyyy-mm-dd'
                This is the format that mariadb accepts
                eft_head handles most of formatting with the datepicker
                mk_sanitize_date is to prevent injection code
                */
                //one of these *should* fire, unless php has crashed
                //the use of && vs and may be to blame for non-eval condition
                if (is_int($done) AND ($done > 0)) {
                    echo '<script>alert("Submission success (Events).");</script>';
                    $donescript = '<script>alert(" '. $done . ' rows inserted ");</script>';
                    echo $donescript;
                }else{
                    echo '<script>alert("Result of submission unknown.");</script>';
                }//else
                //insert_id is not a function
                $event_ID = $wpdb->insert_id;
                if(!empty($_POST['txtKeywords'])) {
                    process_keywords($event_ID);
                }//if
                return $event_ID;


            //check for any logical faux pas
            //some steps are not the same in sanitized version


        }//function
        /*
        Function Name: process_edit1
        Function Purpose:
        processes the form generated by eft_edit_form
        using SQL UPDATE
        */
        function process_edit1($eventID)
        {
            //required for each function
            global $wpdb;
            echo alert_st("Processing the edit request for Event ID: ". $eventID .".");
            $name = $description = $location = "";
            $start_date = $end_date = "";
            $attendance = null;
            $is_public = 0;
            //echo '<script>alert("The create process has been called");</script>';
            $errorMessage = null;
            /*NOTE:
            added sanitization on 6/10/2021
            */
            // variables to pass the information to the database:
            // name and start date of the event
            //------------------get posted information, or set null----------------------------------------------
            /*
            Submit:
            submit_edit1
            Outputs:
            txtName1, startdatepicker1, enddatepicker1,
            txtLocation1, txtDescription1, txtKeywords,
            numAttendance1, checkpublic1

            */
            $name = sanitize_text_field($_POST['txtName1']);
            echo alert_st("Name posted: ". $name);
            $start_date = mk_sanitize_date($_POST["startdatepicker1"]);
            // end date, description, location, attendance, and public if available
            $end_date = mk_sanitize_date($_POST["enddatepicker1"]);
            $description = sanitize_text_field(strval($_POST["txtDescription1"]));
            $location = sanitize_text_field(strval($_POST["txtLocation1"]));
            $attendance = intval($_POST['numAttendance1']);
            if(!empty($_POST['checkpublic1'])) {
              $is_public = 1;
            }
            //---------------------------------------------------------------------------------------------------

            $event_table = "Events";

            //echo '<script>alert("Event ID is '.$eventID.'");</script>';
            $sqlQuery = $wpdb->prepare("UPDATE Events SET name = %s WHERE event_id = %d", $name, $eventID);
            $sqlQuery2 = $wpdb->prepare("UPDATE Events SET start_date = %s WHERE event_id = %d", $start_date, $eventID);
            $sqlQuery3 = $wpdb->prepare("UPDATE Events SET end_date = %s WHERE event_id = %d", $end_date, $eventID);
            $sqlQuery4 = $wpdb->prepare("UPDATE Events SET description = %s WHERE event_id = %d", $description, $eventID);
            $sqlQuery5 = $wpdb->prepare("UPDATE Events SET location = %s WHERE event_id = %d", $location, $eventID);
            $sqlQuery6 = $wpdb->prepare("UPDATE Events SET attendance = %d WHERE event_id = %d", $attendance, $eventID);
            $sqlQuery7 = $wpdb->prepare("UPDATE Events SET is_public = %d WHERE event_id = %d",   $is_public, $eventID);
            $done = $wpdb->query($sqlQuery);
            $done2 = $wpdb->query($sqlQuery2);
            $done3 = $wpdb->query($sqlQuery3);
            $done4 = $wpdb->query($sqlQuery4);
            $done5 = $wpdb->query($sqlQuery5);
            $done6 = $wpdb->query($sqlQuery6);
            $done7 = $wpdb->query($sqlQuery7);
            if (is_int($done)) {

                  $donescript = '<script>alert(For [Events.name]," ('. $done . ' to 1) rows updated ");</script>';
                  echo $donescript;
            }
            if (is_int($done2)) {

                  $donescript = '<script>alert("For [Events.start_date] ('. $done . ' to 1) rows updated ");</script>';
                  echo $donescript;
            }
            if (is_int($done3)) {
                  $donescript = '<script>alert("For [Events.end_date] ('. $done . ' to 1) rows updated ");</script>';
                  echo $donescript;
            }
            if (is_int($done4)) {

                  $donescript = '<script>alert("For [Events.description] ('. $done . ' to 1) rows updated ");</script>';
                  echo $donescript;
            }
            if (is_int($done5)) {

                  $donescript = '<script>alert("For [Events.location] ('. $done . ' to 1) rows updated ");</script>';
                  echo $donescript;
            }
            if (is_int($done6)) {

                  $donescript = '<script>alert("For [Events.attendance] ('. $done . ' to 1) rows updated ");</script>';
                  echo $donescript;
            }
            if (is_int($done7)) {

                  $donescript = '<script>alert("For [Events.is_public] ('. $done . ' to 1) rows updated ");</script>';
                  echo $donescript;
            }
            if (is_int($done) AND is_int($done2) AND is_int($done3) AND is_int($done4) AND is_int($done5) AND is_int($done6) AND is_int($done7)) {
                  echo '<script>alert("Submission success (All from Events).");</script>';
                  $donescript = '<script>alert("Check for changes by Browsing Events");</script>';
                  echo $donescript;
            }else{
                  echo '<script>alert("Result of submission unknown.");</script>';
                  $donescript = '<script>alert("Check for changes by Browsing Events");</script>';
                  echo $donescript;
            }//else
            //insert_id is not a function

            if(!empty($_POST['txtKeywords'])) {
                  process_keywords($eventID);
            }//if
            return $eventID;

            //TODO not used yet
        }//function
        /*
        Function: process_keywords($event_ID)
        Parameters: $event_ID int
        Description:
                    Performs keyword related sql
                    For finding existing Keywords
                    Adding new Keywords
                    and Associating keywords with events
         */
         function process_keywords($eventID)
         {
             //required for each function
             global $wpdb;
             //echo '<script>alert("In keywords processing function")</script>';
             $kws = explode("\n", $_POST["txtKeywords"]);
             $keywords = array_filter($kws, fn($value) => $value !== "");
             // separate keywords into new and already existing:
             // arrays to keep keywords separate
             $existing_keywords = array();
             $new_keywords = array();
             // loop through keywords
             foreach ($keywords as $k){
                 // remove any extra spaces or tabs at the beginning and end of the keyword
                 $keyword = ltrim($k, " \r\t\v");
                 $keyword = rtrim($keyword, " \r\t\v");

                 // search Keywords table in database for the key
                 $sqlQuery = $wpdb->prepare("SELECT * FROM Keywords WHERE keyword=%s LIMIT 1", $keyword);
                 $result = $wpdb->get_results($sqlQuery);
                 $row = $wpdb->get_row($sqlQuery, ARRAY_A);
                 $keyword_to_compare = strval($row['keyword']);
                 //$result = mysqli_query($connection, $sql);
                 //$row = mysqli_fetch_assoc($result); fetchs as associative array...
                 //bit of a rare knowledge for $wpdb, but seems to need to use ARRAY_A

                 $key_ID = intval($row['keyword_id']);
                 // if the keyword exists, save its ID. else, save the keyword name itself
                 // thus existing_keywords ONLY contains IDs, but new_keywords ONLY contains strings of keywords
                 if (!empty($row) AND $keyword_to_compare == $keyword AND $key_ID > 0)
                 {
                   array_push($existing_keywords, $row['keyword_id']);

                   $ev_keyword_table = "Event_Keywords";
                   $sqlQuery = $wpdb->prepare(
                       "INSERT INTO $ev_keyword_table (event_id, keyword_id)
           						values (%d, %d)", $eventID, $key_ID
                   );
                   $done = $wpdb->query($sqlQuery);
                   if (is_int($done) AND ($done > 0)) {
                       echo '<script>alert("Submission success (Event_Keywords), '. $done . ' rows inserted");</script>';
                   }else{
                       echo '<script>alert("Result of submission unknown.");</script>';
                   }//else
                 } else if (empty($row) AND empty($keyword_to_compare) AND !empty($keyword)){
                   array_push($new_keywords, $keyword);
                   $keyword_table = "Keywords";
                   $sqlQuery = $wpdb->prepare(
                       "INSERT INTO $keyword_table (keyword)
           						values (%s)", $keyword
                   );
                   $done = $wpdb->query($sqlQuery);
                   if (is_int($done)
                   AND ($done > 0)
                   AND ($eventID > 0)) {
                       echo '<script>alert("Submission success (Keywords), '. $done . ' rows inserted");</script>';
                       $keyword_ID = (int)$wpdb->insert_id;
                       $ev_keyword_table = "Event_Keywords";
                       // insert the new event keyword association into the database
                       $sqlQuery = $wpdb->prepare("INSERT INTO $ev_keyword_table (event_id, keyword_id) values (%d, %d)", $eventID, $keyword_ID);
                       $done = $wpdb->query($sqlQuery);
                       if (is_int($done) AND ($done > 0)) {
                           echo '<script>alert("Submission success (Event_Keywords), '. $done . ' rows inserted");</script>';
                       }else{
                           echo '<script>alert("Result of submission unknown.");</script>';
                       }
                   }else{
                       echo '<script>alert("Result of submission unknown.");</script>';
                   }
                 }else{
                       echo '<script>alert("Something went wrong.");</script>';
                 }
             }

             // loop through new keywords that don't exist in the database
             /*foreach ($new_keywords as &$keyword)
             {
                 // insert the new keyword into the database

                 //else echo "Error: " . $sql . "<br>" . mysqli_error($connection);

                 // retrieve new keyword ID created from the insert statement

             }
             */
             // loop through existing keyword IDs
             /*
             foreach ($existing_keywords as &$key_ID)
             {
                 // NOTE: existing_keywords ONLY contains IDs
                 // since the keyword already exists in the database, skip the step to insert the
                 // keyword, and insert the new event keyword association into the database
                 // insert the new event keyword association into the database

             }//foreach
             */
         }//function
        function find_event() {
          global $wpdb;
          //Initialize--------------------------
          $eventID = 0;
          $name2 = $location2 = $description2 = "";
          $startDate2 = $endDate2 = "0000-00-00";
          $attendance2 = $ispublic2 = 0;
          //------------------------------------
        if(isset($_POST['txtName2'])) {
            $eventName = sanitize_text_field($_POST['txtName2']);
            $name2 = $eventName;
            //$innerMessage = "Event Name: " . $eventName;
            //$popup = alert_st($innerMessage);
            echo $popup;
            if(isset($_POST['startdatepicker2'])) {
                $eventStartDate = mk_sanitize_date($_POST['startdatepicker2']);
                $startDate2 = strval($eventStartDate);
                //echo alert_st($eventStartDate);
                $sqlQuery = $wpdb->prepare(
                  "SELECT * FROM Events WHERE name = %s AND start_date = %s",$name2, $startDate2);
                $countQuery = $wpdb->prepare(
                  "SELECT COUNT FROM Events WHERE name = %s AND start_date = %s",$name2, $startDate2);
                $countVar = $wpdb->get_var($countQuery);
                $eventRow = $wpdb->get_row($sqlQuery, ARRAY_A);

                //echo alert_st("still alive after query");
                //$accum = 0;
                /*
                NOTE:
                Logic rewritten to be more reliable,
                too many failures on original version
                */
                if(!empty($eventRow['event_id'])) {
                  //echo alert_st("event result is not empty");
                  $event_ID = intval($eventRow['event_id']);
                  $innerMessage = 'Result is'. $event_ID . '.';
                  //$popup = alert_st($innerMessage);
                  echo $popup;
                  if($countVar > 1 AND $event_ID > 1){
                    $errorMessage = alert_st("Duplicate Events found!");
                    echo $errorMessage;
                    $findEvent = "DUPLICATE";
                  }else if($countVar < 1 AND $event_ID < 1){
                    $errorMessage = alert_st("Event not found!");
                    //echo alert_st("Event ID: ". $event_ID);
                    echo $errorMessage;
                    $event_ID = 0;
                    $findEvent = "NOTFOUND";
                  }else{
                    $location2 = $eventRow['location'];
                    $endDate2 = $eventRow['end_date'];
                    $description2 = $eventRow['description'];
                    $attendance2 = intval($eventRow['attendance']);
                    $findEvent = "FOUND";
                  }
                }else{
                  $errorMessage = alert_st("Event not found!");
                  //echo alert_st("Event ID: ". $event_ID);
                  echo $errorMessage;
                  $event_ID = 0;
                  $findEvent = "NOTFOUND";

                }

              }else{
                $event_ID = 0;
                $findEvent = "NOTFOUND";
              }
            }else{
              $event_ID = 0;
              $findEvent = "NOTFOUND";
            }
              $findResult = array(
                'ID' => $event_ID,
                'RESULT' => $findEvent,
                'NAME' => $name2,
                'SDATE' => $startDate2,
                'EDATE' => $endDate2,
                'DESCRIBE' => $description2,
                'LOC' => $location2,
                'ATTEND' => $attendance2,
              );
              return $findResult;
              /*
              name        | varchar(128) | NO   |     | NULL    |
              start_date  | date         | NO   |     | NULL    |                |
              end_date    | date         | YES  |     | NULL    |                |
              description | varchar(600) | YES  |     | NULL    |                |
              location    | varchar(64)  | YES  |     | NULL    |                |
              attendance  | int(11)      | YES  |     | NULL    |                |
              is_public   | tinyint(1)   | NO   |     | 0
              */
        }//function
        ?>


    </div>

<?php

    // astra method to summon website style footer
    get_footer();
    //possible eof error in this file
    //shows in php -l linter
?>
