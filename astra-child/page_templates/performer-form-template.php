<?php
    /*
        Template Name:     Performer Form Template
        Website:           ISC
        Description:       Template for the Performer creation form
        Last Edited:       6/12/2021
    */
    // TODO:
    //section tag styling into separate CSS file
    /*NOTE: was never done as internal CSS
     so the creation of logical CSS classes
      will be needed to control display here*/

    /*NOTE:
    Refactoring
    -----------------
    What was done:
    ------------------
    •removed config.php
    •now has externalized form for display
    •$wpdb does what config was doing with less problems
    •improved program maintainability
    •better support for images
    ----------------
    Rationale:
      Problems
        [the main problem being that database details
        were stored in two places rather than one,
        and that access is less well managed for themes
        vs. internal wordpress files]
      Solutions
        $wpdb is WordPress standard function
        functions are used instead of boilerplate procedural code
        business logic should be improved overall
    */
require "pft-show.php";
require "utility.php";
global $wpdb;
// if user somehow tries to submit a form without entering a first name, last name, email, and/or profile image,
//        prepare error message to display to the user
// if error message is empty, continue with the processing and inserting of user data
// duplication checking
// TODO: check database to see if user already exists by checking first/last names and profile image
//            if it exists, display both that user's first/last name and profile image AND that of the
            //            performer user attempted to enter by a popup dialog box, and let the user chose which
            //            performer to keep and which to discard.
            //            when implemented, an if/else needs to surround the rest of the code below, so if the user
            //            decides to keep what's already in the database, a new performer wouldnt need to be inputted.

            /*NOTE:
            previously worked like comment below
            // take image uploaded and insert as profile image in database
            //     currently converting images to BLOBs to store it and its image type in the database.
            //     This method of saving images is not complete, will be open to better methods in the future
            this has been updated as of 6/10/2021
            /*NOTE:
            File should be saved to disk ONLY and referenced by path in database
            Implementation is in img_processpf() function
            */

            // wp_users table:
            // create new user with minimal information, for displaying as performer only

                // fake password for now until user account functionality is complete
                //$userPass = strval(bin2hex(random_bytes(20)));
                //all use default password 'Default1' currently
                //password change procedure will be implemented later
//DONE: Keywords Refactor 6/10/2021
    // astra method to summon website styled header
    $headsetting = pft_head();
    echo $headsetting;
    get_header();

?>

<div id="primary" class="site-content-fullwidth">

<?php
// astra methods to summon website styled pages
astra_primary_content_top();
astra_primary_content_bottom();
//echo '<script>alert("main started")</script>';
// if user clicks submit:
// remember $_SERVER
$errorMessage = '';
/*NOTE:
undeclared variables just make the script go silent
this is probably a soft crash
*/
if ($_SERVER['REQUEST_METHOD'] == 'POST'
AND isset($_POST['submit_createpf'])) {
    //if getimagesize fails it usually implies that it is not an image
    //echo '<script>alert("Submit has occurred")</script>';
    $errorMessage = "";
    //echo '<script>alert("alive 1")</script>';
    $check = getimagesize($_FILES['imgpfp']['tmp_name']);
    //echo '<script>alert("Check:'.strval(intval($check)).'")</script>';
    //header(get_bloginfo('url') . "/performer?id=" . $user_ID);
    //exit();
    /*NOTE:

        // exit the code
        //took out exit, just in case

    /*
    If statement
    ------------
    Description:
    Checks for variety of errors,
    if none exist, then the processing occurs
    */
    if(empty($_POST['txtFirstName']) || empty($_POST['txtLastName']) || empty($_POST['txtEmail'])) {
        //Maybe? -> OR (count(array_filter($_FILES['imgpfp']['tmp_name'])) < 1)) {
        //This was also bad -> OR (count(array_filter($_FILES['imgpfp']['name'])) < 1)) {
        //This was the bad code here -> || (count($_FILES) < 1)) {
        $errorMessage = "You must enter a performer's first and last name, their email, and their profile picture.";
        echo '<script>alert("Error: '. $errorMessage .' ")</script';
        $display_pf_form = pft_show_form();
        echo $display_pf_form;
    }elseif ($check == false) {
        $errorMessage .="The file chosen is not an image.";
        echo '<script>alert("Error: '. $errorMessage .' ")</script';
        $display_pf_form = pft_show_form();
        echo $display_pf_form;
    }elseif (intval($check) > 5000) {
        $errorMessage .="The file chosen is too large.";
        echo '<script>alert("Error: '. $errorMessage .' ")</script';
        $display_pf_form = pft_show_form();
        echo $display_pf_form;
    }else{
        //where the actual processing occurs
        //echo '<script>alert("processing should start");</script>';
        //accidentally put $user_ID in wrong function definition
        $user_ID = process_createpf();
        if(is_int($user_ID) AND $user_ID > 0) {
          img_processpf($user_ID);
          process_rolepf($user_ID);
          if(!empty($_POST["txtKeywords"])) {
              process_keywordspf($user_ID);
          }
          echo "<a href='". get_bloginfo('url')."/wordpress/performer?id=" . $user_ID . "' style='margin: 10px; text-decoration: underline;'>View Result</a>";
        }

    }
}else{
    //echo '<script>alert("default presentation");</script>';
    $display_pf_form = pft_show_form();
    echo $display_pf_form;
}

function process_createpf()
{
    //required for each function
    global $wpdb;
    //echo '<script>alert("In process function");</script>';
    $uniqueNumString = uquery();
    $userRole = 'performer';
    if(checkIfRoleExists($userRole) == FALSE){
      $userRole = 'subscriber';
    }
    $bio = $userWebsite = $userEmail = '';
    $firstName = $lastName = $userName = $displayName = '';
    $firstName = sanitize_text_field($_POST['txtFirstName']);
    $lastName = sanitize_text_field($_POST['txtLastName']);
    //-strlen($firstName)
    $userName = strtolower($lastName) . strtolower(substr($firstName,0,1)) . $uniqueNumString;
    // user email and user website if available
    $userEmail = $_POST["txtEmail"];
    //sanitize_url is deprecated
    //... suggested that esc_url_raw is used instead
    $userWebsite = esc_url_raw($_POST['txtWebsite']);
    // display name, which is a combination of first and last name to create full name
    $displayName = $firstName . " " . $lastName;
    $bio = sanitize_text_field($_POST["txtBio"]);
    //image properties and mime type obtained from file
    // 'ID'                    => 0,    //(int) User ID. If supplied, the user will be updated.
    // 'show_admin_bar_front'  => False,   //(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
    //adapted from https://developer.wordpress.org/reference/functions/wp_insert_user/
    $userdata = array(
        'user_pass'             => 'Default1',   //(string) The plain-text user password.Gave a default to override later.
        'user_login'            => $userName,   //(string) The user's login username.
        'user_nicename'         => $userName,   //(string) The URL-friendly user name.
        'user_url'              => $userWebsite,   //(string) The user URL.
        'user_email'            => $userEmail,   //(string) The user email address.
        'display_name'          => $displayName,   //(string) The user's display name. Default is the user's username.
        'nickname'              => $userName,   //(string) The user's nickname. Default is the user's username.
        'first_name'            => $firstName,   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
        'last_name'             => $lastName,   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
        'description'           => $bio,   //(string) The user's biographical description
        'role'                  => $userRole
    );
    //NOTE: wp_users is a user table... so a user creation function is used
    if(!empty($userdata))
    {
      echo '<script>alert("User data has been initialized for use in database")</script>';
    }else{
      echo '<script>alert("Error: user data has NOT been initialized for use in database")</script>';
    }
    $pf_ID = wp_insert_user($userdata);
    echo alert_st("User created : ". strval($pf_ID));
    // On success.
    /*
    if ( ! is_wp_error( $user_id ) ) {
      echo alert_st("User created : ". $user_id);
    }else{
      echo alert_st("Some error occurred");
      $pf_ID = 0;
    }
    */
    if(is_int($pf_ID) AND $pf_ID > 0) {
        echo '<script>alert("Successful performer creation.")</script>';

    }else{
        //if it is not an int for an id, it's an error
        echo '<script>alert("Something went wrong.")</script>';
        $pf_ID = 0;
    }//else
    echo '<script>alert("ID is: '. $pf_ID .' ")</script>';
    return $pf_ID;

                //values (%s, %s, %s, %s, %s, %s, %s, %d)
                //($userName, $userPass, $userName, $userEmail, $userWebsite, $displayName, $bio, $imgid);
}
function img_processpf($user_ID)
{
    //required for each function
    global $wpdb;
    //echo '<script>alert("In image processing function")</script>';
    $imageProperties = getimageSize($_FILES['imgpfp']['tmp_name']);
    $img_type = $imageProperties['mime'];
    $img_name = basename($_FILES["imgpfp"]["name"]);
    //the wp_upload_dir() function returns an array
    $upload_dir = wp_upload_dir();
    //prepare the imgprofile directory in uploads if it doesn't exist
    //and if the upload directory is defined in wordpress
    if(!empty($upload_dir['basedir'])) {
        $img_dir = $upload_dir['basedir'].'/imgprofile/';
        if(!file_exists($img_dir)) {
            wp_mkdir_p($img_dir);
        }

        $img_path = $img_dir . $user_ID . "_" . $img_name;
        $img_path2 = get_bloginfo('url') . '/wp-content/uploads/imgprofile/' . $user_ID . "_" . $img_name;
        //does the actual upload, moves from the tmp folder to target
        if(move_uploaded_file($_FILES["imgpfp"]["tmp_name"], $img_path)) {
            echo '<script>alert("The image has been stored to '. $img_path .' ");</script>';
            echo '<script>alert("The image can accessed from '. $img_path2 .' ");</script>';
            $img_table = "Profile_Images";
            update_user_meta($user_ID, 'profile_image', $img_path2);
            $sqlQuery = $wpdb->prepare(
                "INSERT INTO $img_table (image_name, image_path, image_type, profile_id)".
						"values (%s, %s, %s, %d)", $img_name, $img_path2, $img_type, $user_ID
            );
            $done = $wpdb->query($sqlQuery);
            if (is_int($done) AND ($done > 0)) {
                echo '<script>alert("Submission success (Profile_Images), '. $done .' rows inserted");</script>';
                echo '<img src="'.$img_path2.'" alt="Profile Image" height="120px" width="120px" />';
            }else{
                echo '<script>alert("Result of submission unknown."</script>';
            }//else $done
        } else {
            echo '<script>alert("Error uploading file")</script>';
        }//else move_uploaded_file
    }else{
        echo '<script>alert("Error: Directory /UPLOADS/ is undefined");</script>';
    }//else
    //TODO
}
function process_keywordspf($user_ID)
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

          $pf_keyword_table = "Performer_Keywords";
          $sqlQuery = $wpdb->prepare(
              "INSERT INTO $pf_keyword_table (performer_id, keyword_id)
  						values (%d, %d)", $user_ID, $key_ID
          );
          $done = $wpdb->query($sqlQuery);
          if (is_int($done) AND ($done > 0)) {
              echo '<script>alert("Submission success (Performer_Keywords), '. $done . ' rows inserted");</script>';
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
          AND ($user_ID > 0)) {
              echo '<script>alert("Submission success (Keywords), '. $done . ' rows inserted");</script>';
              $keyword_ID = (int)$wpdb->insert_id;
              $pf_keyword_table = "Performer_Keywords";
              // insert the new performer keyword association into the database
              $sqlQuery = $wpdb->prepare("INSERT INTO $pf_keyword_table (performer_id, keyword_id) values (%d, %d)", $user_ID, $keyword_ID);
              $done = $wpdb->query($sqlQuery);
              if (is_int($done) AND ($done > 0)) {
                  echo '<script>alert("Submission success (Performer_Keywords), '. $done . ' rows inserted");</script>';
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
        // keyword, and insert the new performer keyword association into the database
        // insert the new performer keyword association into the database

    }//foreach
    */
}//function
function process_rolepf($user_ID)
{
    //required for each function
    global $wpdb;
    // User_Roles table: associate new user with performer role to identify them as a performer
    //$popup = alert_st("Processing User Role");
    echo $popup;
    // get ID of performer role
    //role_type_id
    $wherep = "Performer";
    $limit1 = 1;
    $sqlQuery = $wpdb->prepare("SELECT * FROM Role_Type WHERE name=%s LIMIT %d", $wherep, $limit1);
    $row = $wpdb->get_row($sqlQuery, ARRAY_A);
    if(empty($row)) {
      //temporarily set to 1 to help get a better result
      $role_ID = 1;
      //echo alert_st("Temporary measure taken");
    }else{
      $role_ID = intval($row['role_type_id']);
      //echo alert_st("Role ID:" . $role_ID);
    }
    // fixed this (hopefully), since query should only give 1 row
    // current date as first day of user existence with this role
    // fixed... y to Y... full year is more reliable
    // than the yy that shows with y
    $startTime = strval(date("Y-m-d"));
    //echo alert_st("Start-Time:".$startTime);
    //echo alert_st("User ID:".$user_ID);
    //$endTime = NULL;
    // Prepare an insert statement to insert the new user as a performer
    $role_table = "User_Roles (user_id, role_id, start_time)";
    if($user_ID > 0){
      $sqlQuery = $wpdb->prepare("INSERT INTO $role_table values (%d, %d, %s)", $user_ID, $role_ID, $startTime);
      $done = $wpdb->query($sqlQuery);
      if (is_int($done) AND ($done > 0)) {
        echo '<script>alert("Submission success (User_Roles), '. $done .' rows inserted.");</script>';
      }else{
        echo '<script>alert("Result of submission unknown (User_Roles).");</script>';
      }//else
    }else{
      echo '<script>alert("Invalid user ID.");</script>';
    }
}
?>
</div>
<?php
    the_content();
    // astra method to summon website style footer
    get_footer();
?>
