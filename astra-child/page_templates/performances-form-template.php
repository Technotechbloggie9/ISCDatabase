<?php
/*
    Template Name:     Performance Form Template
    Website:         ISC
    Description:    Template for the Performance creation form
    Last Edited:     6/15/2021
*/
//
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
checkpublic,
checkadult,
txtKeywords, --in keywords function
txtEventName,
starteventdatepicker
*/
/*
  Required
  --------
  pft-show.php
    functions used: pft_head()
    usage description:
      used to modify page specific css
  performances-show-forms
    functions used: show_form()
    usage description:
      used for form display code
  utility
    functions used: mk_sanitize_date()
                    alert_st()
    usage description:
      date sanitization
      simplify js alerts
*/
    require "pfm-show.php";
    require "utility.php";
    global $wpdb;

    // astra method to summon website styled header
    $headvar = pfm_head();
    echo $headvar;
    get_header();

?>
<div id="primary" class="site-content-fullwidth">
<?php
    // astra methods to summon website styled pages
    global $wpdb;
    astra_primary_content_top();
    astra_primary_content_bottom();
    //$popup = '<script>alert("alert_st() function is not working as expected")</script>';
    //do not echo $popup here... this is a default
    $performances_form = '1';
    $performance_ID = NULL;
//-------------MAIN BODY --------------------------------------------------
    if($_SERVER['REQUEST_METHOD'] == 'POST'
    AND isset($_POST['submit_createpm'])
    ) {

        if(empty($_POST['txtName'])) {
            $popup = alert_st("Please enter the name of the performance.");
            echo $popup;
            $performances_form = pfm_show_form();
            echo $performances_form;
        }else{
            //do form processing
            //initialize variables
            //$popup = alert_st("Form is ready to be processed");
            echo $popup;
            //process_createpm();
            $performance_ID = process_createpm();
            if($performance_ID > 0 AND !empty($_POST['txtKeywords'])) {
                //$popup = alert_st("Keywords are ready to be processed");
                echo $popup;
                process_keywordspmf($performance_ID);
            }//inner if
            echo "<a href='". get_bloginfo('url')."/performance?id=" . $performance_ID . "' style='margin: 10px; text-decoration: underline;'>View Result</a>";
        }//else 73
    }else{
        //display code called
        $performances_form = pfm_show_form();
        echo $performances_form;
    }//else 87
//-----------END MAIN BODY --------------------------------------------------
    function process_createpm() {
        global $wpdb;
        //$popup = alert_st("in process...");
        echo $popup;
        //----Set Defaults -------------------
        $done = 0;
        $event_ID = 0;
        //$popup = alert_st("still alive...1");
        //echo $popup;
        $eventStartDate = $endDate = $startDate = '0000-00-00';
        $startTime = $endTime = "00:00 AM";
        //$popup = alert_st("still alive...2");
        //echo $popup;
        $name1 = '';
        //$popup = alert_st("still alive...3");
        //echo $popup;
        $eventName = '';
        //$popup = alert_st("still alive...4");
        //echo $popup;
        $isPublic = $attendance = $adultContent = 0;
        //$popup = alert_st("still alive...5");
        echo $popup;
        //------------------------------------
        //name was checked before the function was called
        $name1 = sanitize_text_field($_POST['txtName']);
        //$popup = alert_st($name1);
        echo $popup;
        //checkadult and checkpublic are checkboxes
        //checkboxes do not need sanitization
        //converted !empty condition to isset
        if(isset($_POST['checkpublic'])) {
            $isPublic = 1;

        }
        //echo alert_st($isPublic);
        if(isset($_POST['checkadult'])){
            $adultContent = 1;

        }
        //echo alert_st($isPublic);
        //-----SANITIZE STRINGS ---------------
        //except for event strings which follow insert
        if(isset($_POST['starttimepicker'])) {
            $startTime = to_military_time(
                mk_sanitize_time(
                    $_POST['starttimepicker']));
                //echo alert_st("time after sanitized:" . $startTime);
        }
        if(isset($_POST['endtimepicker'])) {
            $endTime = to_military_time(
                mk_sanitize_time(
                    $_POST['endtimepicker']));
        }
        if(isset($_POST['startdatepicker'])) {
            $startDate = mk_sanitize_date($_POST['startdatepicker']);
        }
        if(isset($_POST['enddatepicker'])) {
            $endDate = mk_sanitize_date($_POST['enddatepicker']);
        }

        //--------Insert name and default has_adult_content into database
        $performance_table = "Performances";
        $sqlQuery = $wpdb->prepare(
        "INSERT INTO $performance_table (name, start_date, end_date, start_time, end_time, has_adult_content, is_public)
        values (%s, %s, %s, %s, %s, %d, %d)", $name1, $startDate, $endDate, $startTime, $endTime, $adultContent, $isPublic);
        $done = $wpdb->query($sqlQuery);
        //echo alert_st("still alive after add");
        //goes silent here
        $performance_ID = $wpdb->insert_id;
        //echo alert_st("still alive after fetch id");
        if(is_int($performance_ID)) {
          $popup = alert_st("Performance ID successfully fetched as: " . $performance_ID);
          echo $popup;
        }else{
          $popup = alert_st("Performance ID fetch failed, setting to 0");
          echo $popup;
          $performance_ID = 0;
        }

        /*NOTE:
        unusual level of difficulty in getting correct insert into this table
        this resulted in many rewrites, and inevitably the insert/update format
        which is seen here
        */
        //-----Verify that it was inserted--------------------------------
        if (is_int($done)) {
          //just in case comparison was causing crash, it was separated
          if($done > 0) {
            echo '<script>alert("Submission success (Performances), '. $done . ' rows inserted");</script>';

          }else{
            echo '<script>alert("Result of submission unknown.");</script>';

          }
        }else{
            echo '<script>alert("Result of submission unknown.");</script>';

        }
        //-----Attendance-------------------------------------------------
        if(!empty($_POST['numAttendance'])) {
            $attendance = intval(sanitize_text_field($_POST['numAttendance']));
        }

        //$popup = alert_st("Attendance: ". $attendance);
        //should be a number
        echo $popup;
        //-----Event Logic -----------------------------------------------
        if(isset($_POST['txtEventName'])) {
            $eventName = sanitize_text_field($_POST['txtEventName']);
            $innerMessage = "Event Name: " . $eventName;
            $popup = alert_st($innerMessage);
            echo $popup;
            if(isset($_POST['starteventdatepicker'])) {
                $eventStartDate = mk_sanitize_date($_POST['starteventdatepicker']);
                echo alert_st("starteventdatepicker is not empty");
                $sqlQuery = $wpdb->prepare(
                  "SELECT * FROM Events WHERE name = %s AND start_date = %s LIMIT 1",$eventName, $eventStartDate);
                $countQuery = $wpdb->prepare(
                  "SELECT COUNT FROM Events WHERE name = %s AND start_date = %s",$eventName, $eventStartDate);
                $countVar = $wpdb->get_var($countQuery);
                $eventRow = $wpdb->get_row($sqlQuery);
                //$results = $wpdb->get_results($sqlQuery, ARRAY_A);

                //$accum = 0;
                /*
                NOTE:
                Logic rewritten to be more reliable,
                too many failures on original version
                */
                if(!empty($eventRow)) {
                  echo alert_st("event result is not empty");
                  $event_ID = intval($eventRow['event_id']);
                  $innerMessage = 'Result is'. $event_ID . '.';
                  $popup = alert_st($innerMessage);
                  echo $popup;
                  if($countVar > 1){
                    $errorMessage = alert_st("Duplicate Events found!");
                    echo $errorMessage;
                    $event_ID = 0;
                  }else if($countVar < 1 OR $event_ID < 1){
                    $errorMessage = alert_st("Event not found!");
                    echo alert_st($event_ID);
                    echo $errorMessage;
                    $event_ID = 0;
                  }else{
                    $innerMessage = 'Result is'. $event_ID . '.';
                    $popup = alert_st($innerMessage);
                    echo $popup;
                    $table = 'Performances';
                    $data = array('event_id'=>intval($event_ID));
                    $format = array('%d');
                    $where = array('performance_id'=>$performance_ID);
                    $whereformat = array('%d');
                    $done = $wpdb->update($table, $data, $where, $format, $whereformat);
                    if (!is_int($done)) {
                        echo '<script>alert("Result of update submission unknown, or not found.");</script>';
                    }else{
                        echo '<script>alert("Update submission success (Performances), '. $done . ' rows inserted");</script>';
                    }//else
                  }

                }
            }//if starteventdatepicker
        }//if txtEventName
        //--------End Event Logic ----------------------
        //echo alert_st("still alive after event logic");
        //prepare doesn't support NULL values apparently

        //$sqlQuery =

        //);

        //$done = $wpdb->insert("Performances",
        $table = 'Performances';
        $data = array('attendance'=>intval($attendance));
        $format = array('%d');
        $where = array('performance_id'=>$performance_ID);
        $whereformat = array('%d');
        //I made the following *look* like the documentation for a greater chance of success
        $done = $wpdb->update($table, $data, $where, $format, $whereformat);
        if ($done === false) {
            echo '<script>alert("Result of update submission unknown, or not found.");</script>';
        }else{
            echo '<script>alert("Update submission success (Performances), '. $done . ' rows inserted");</script>';
        }//else


        //$popup = alert_st($sqlQuery);
        //echo $popup;

        return $performance_ID;
      }//function 93

    function process_keywordspmf($performance_ID)
    {
        //required for each function
        global $wpdb;
        //echo '<script>alert("In keywords processing function")</script>';
        $keywords = array_filter(explode("\n", $_POST["txtKeywords"]), fn($value) => $value !== "");
        // separate keywords into new and already existing:
        // arrays to keep keywords separate
        $existing_keywords = array();
        $new_keywords = array();
        // loop through keywords
        foreach ($keywords as &$k){
            // remove any extra spaces or tabs at the beginning and end of the keyword
            $keyword = ltrim($k, " \r\t\v");
            $keyword = rtrim($keyword, " \r\t\v");

            // search Keywords table in database for the key
            $sqlQuery = $wpdb->prepare("SELECT keyword_id, keyword FROM Keywords WHERE keyword = %s limit 1",
            $keyword);
            $result = $wpdb->get_results($sqlQuery);
            $row = $wpdb->get_row($sqlQuery, ARRAY_A);
            $keyword_to_compare = $row['keyword'];
            //$result = mysqli_query($connection, $sql);
            //$row = mysqli_fetch_assoc($result); fetchs as associative array...
            //bit of a rare knowledge for $wpdb, but seems to need to use ARRAY_A


            // if the keyword exists, save its ID. else, save the keyword name itself
            // thus existing_keywords ONLY contains IDs, but new_keywords ONLY contains strings of keywords
            if ($keyword_to_compare == $keyword) { array_push($existing_keywords, $row['keyword_id']);
            } else { array_push($new_keywords, $keyword);
            }
        }

        // loop through new keywords that don't exist in the database
        foreach ($new_keywords as $keyword)
        {
            // insert the new keyword into the database
            $keyword_table = "Keywords (keyword)";
            $sqlQuery = $wpdb->prepare(
                "INSERT INTO $keyword_table
    						values (%s)", $keyword
            );
            $done = $wpdb->query($sqlQuery);
            if (is_int($done) AND ($done > 0)) {
                echo '<script>alert("Submission success (Keywords), '. $done . ' rows inserted");</script>';
                $keyword_ID = $wpdb->insert_id;
                $pf_keyword_table = "Performance_Keywords (performance_id, keyword_id)";
                $sqlQuery = $wpdb->prepare("INSERT INTO $pf_keyword_table values (%d, %d)", $performance_ID, $keyword_ID);
                $done = $wpdb->query($sqlQuery);
                if (is_int($done) AND ($done > 0)) {
                    echo '<script>alert("Submission success (Performance_Keywords), '. $done . ' rows inserted");</script>';
                }else{
                    echo '<script>alert("Result of submission unknown.");</script>';
                }
            }else{
                echo '<script>alert("Result of submission unknown.");</script>';
            }
            //else echo "Error: " . $sql . "<br>" . mysqli_error($connection);

            // retrieve new keyword ID created from the insert statement

            // insert the new performer keyword association into the database

        }

        // loop through existing keyword IDs
        foreach ($existing_keywords as $key_ID)
        {
            // NOTE: existing_keywords ONLY contains IDs
            // since the keyword already exists in the database, skip the step to insert the
            // keyword, and insert the new performer keyword association into the database
            // insert the new performer keyword association into the database
            $pf_keyword_table = "Performance_Keywords (performance_id, keyword_id)";
            $sqlQuery = $wpdb->prepare(
                "INSERT INTO $pf_keyword_table
    						values (%d, %d)", $performance_ID, $key_ID
            );
            $done = $wpdb->query($sqlQuery);
            if (is_int($done) AND ($done > 0)) {
                echo '<script>alert("Submission success (Performance_Keywords), '. $done . ' rows inserted");</script>';
            }else{
                echo '<script>alert("Result of submission unknown.");</script>';
            }//else
        }//foreach
    }//function
/*NOTE:
    The structure of Performances is as follows
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
    | has_adult_content | bit(1)       | NO   |     | NULL    |                |
    | attendance        | int(11)      | YES  |     | NULL    |                |
    | is_public         | bit(1)       | YES  |     | NULL    |                |
    +-------------------+--------------+------+-----+---------+----------------+
    It may need to search events for event_id
    This is done with event_name and event_start_date
    Selection may be an issue if more than one
    Numerical feedback may be a way to do this
    Performance recording should be a separate page
*/
/*
NOTE:
Unknown factors include whether attendance is tracked separately
than for Events
Attendance value may not make sense if greater than associated event
In this condition, perhaps it makes sense to adjust the performance
attendance down to the event attendance
(add as TODO)
There is always a chance to lose data in such conditions,
Additional logic is needed to handle user feedback for this
*/

 ?>

</div>

<?php
    the_content();
    // astra method to summon website style footer
    get_footer();
 ?>