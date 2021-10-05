<?php
    require_once "roletable.php";
    //start by listing user-login, display name from wp-users
    //next add in roles
    //View link is shown to get more information
    function userBrowsePage(){
      global $wpdb;
      //if (isset($_GET['page_number']) && $_GET['page_number']!="") {$page_number = $_GET['page_number'];}
	    //else {$page_number = 1;}
      $roleTable = getRoleTable();
      $count = 0;
      $allRole = ' ';
      $colNum = 1;
      //$total_users_per_page = 20;
	    //$offset = ($page_number-1) * $total_users_per_page;
	    //$prev_page = $page_number - 1;
	    //$next_page = $page_number + 1;
      echo "<link rel='stylesheet' href='". get_bloginfo('url'). "/wp-content/plugins/ISCTestCode/css/style.css" ."'>";

      echo "<div class='cmdscreen mono1 topwidth' style='height: 10em;'><br><br>";
      echo "<span class='title1'> Browse Users </span> </div><br><br>";
	    // get the total number of pages for pagination by getting the total number of events public and dividing by
	    //		events per page to view
	    //$total_users = $wpdb->get_var("SELECT COUNT(*) FROM wp_users");
	    //$total_page_number = ceil($total_users / $total_users_per_page);
      $sqlQuery = $wpdb->prepare("SELECT * FROM wp_users ORDER BY user_login");
      //LIMIT $offset, $total_user_per_page");
      $results = $wpdb->get_results($sqlQuery);
      echo "<span class='medium1 mono1'></span><br><br>";
      //columns and headings should be forced to be odd numbered for ideal display
      echo "<div class='isctable topwidth normal1'>";
      echo "  <div class='iscrow topwidth'>";
      echo "    <div class='isctablehead'>Username</div>";
      echo "    <div class='isctablehead'>Name</div>";
      echo "    <div class='isctablehead'>Role(s)</div>";
      echo "    <div class='isctablehead'>Email</div>";
      echo "    <div class='isctablehead'>Link</div>";
      echo "  </div>";

      foreach($results as $row){
        $count = 0;
        $allRole = ' ';
        $userID = $row->ID;
        $userDisplay = strval($row->display_name) . " ";
        $username = strval($row->user_login) . " ";
        $userEmail = strval($row->user_email) . " ";
        $user = get_user_by('id', $userID);
        $roles = ( array ) $user->roles;
        $viewhref = "admin.php?page=user_manage&id=". $userID;
        foreach($roles as $userRole){
          $count = $count + 1;
          $rolekey = array_search($userRole, $roleTable);
          if($count > 1){
            $allRole = $allRole . " , " . strval($rolekey);
          }else{
            $allRole = $allRole . strval($rolekey) . " ";
          }

        }
        //display the rows and columns for the data
        echo "<div class='iscrow topwidth'>";
        $colNum = altNum($colNum);
        $colName = "isccol" .strval($colNum);
        echo numColDiv($username, $colName);
        $colNum = altNum($colNum);
        $colName = "isccol" .strval($colNum);
        echo numColDiv($userDisplay, $colName);
        $colNum = altNum($colNum);
        $colName = "isccol" .strval($colNum);
        echo numColDiv($allRole, $colName);
        $colNum = altNum($colNum);
        $colName = "isccol" .strval($colNum);
        echo numColDiv($userEmail, $colName);
        $colNum = altNum($colNum);
        $colName = "isccol" .strval($colNum);
        $view = "<a href='". $viewhref ."'>View User</a>";
        echo numColDiv($view, $colName);

        echo "</div>";
      }
      echo "</div>";
      //echo "<div style='padding: 2em 2em 0px; height: 4em; width: 60%; margin-top: 2px; margin-right: 30%; margin-left: 10%; font-size: 150%; float: none;'>";
	    //echo "<span>Page " .$page_number. " of " .$total_page_number. " </span><br>";
	    //echo "</div>";
      //echo "<div class='pagination' style='height: 8em; font-size: 150%; text-align: center;'>";

	     // displaying "Previous" and "First Page" in separate if statements due to issue with "Previous" displaying even on the very first page
	     // TODO: figure out how to fix this issue
       /*
	     if($page_number > 1) {
		     echo "<a href='?page_number=1' style='margin: 10px; text-decoration: underline; color=#5274FF;'>&lsaquo;&lsaquo; First Page</a>";
       }
       if($page_number > 1) {
		     echo "<a href='?page_number=$prev_page' style='margin: 10px; text-decoration: underline; color=#5274FF;'>Previous</a>";
       }
       */
	// displaying "Next" and "Last Page" in separate if statements due to issue with "Last Page" displaying even on the last page
	// TODO: figure out how to fix this issue
	/*if($page_number < $total_page_number)
		echo "<a href='?page_number=$next_page' style='margin: 10px; text-decoration: underline; color=#5274FF;'>Next</a>";
	if($page_number < $total_page_number)
		echo "<a href='?page_number=$total_page_number' style='margin: 10px; text-decoration: underline; color=#5274FF;'>Last Page &rsaquo;&rsaquo;</a>";
  */
	echo "</div>";
    }
    function numColDiv($content, $colName){
      $htmloutput = "    <div class='". $colName ."'> ". $content ." </div>";
      return $htmloutput;
    }
    function altNum($lastNum){
      if($lastNum == 1){
        $newNum = 2;
      }else{
        $newNum = 1;
      }
      return $newNum;
    }


 ?>