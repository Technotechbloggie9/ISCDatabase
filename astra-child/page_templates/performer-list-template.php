<?php
	/*
		Template Name:	Performer List Template
		Website: 		ISC
		Description:	PHP snippet code for the Performer List page
		Last Edited: 	5/06/2021
	*/
	// TODO: convert file to separate code into PHP and HTML/CSS sections instead of one PHP section with echoing HTML/CSS code

	// contains the domain/IP address of the website to redirect to
	//require "config.php";

	// access WordPress's database management
	global $wpdb;

	// astra method to summon website styled header
	get_header();

	// astra methods to summon website styled pages
	astra_primary_content_top();
	astra_primary_content_bottom();

	// get the current page number either from previous list page accessed or assigned as 1 if
	//		it's user's first time accessing the page
	if (isset($_GET['page_number']) && $_GET['page_number']!="") {$page_number = $_GET['page_number'];}
	else {$page_number = 1;}

	// set the total amount of performers per page
	$total_performers_per_page = 5;
	$offset = ($page_number-1) * $total_performers_per_page;
	$prev_page = $page_number - 1;
	$next_page = $page_number + 1;

	// get the total number of pages for pagination by getting the total number of performers public and dividing by
	//		performers per page to view
	$total_performers = $wpdb->get_var("SELECT COUNT(1) FROM User_Roles WHERE role_id = 1");
	$total_page_number = ceil($total_performers / $total_performers_per_page);
	echo "<head><style> body {font-family: Arial;} .table_container {padding: 0px 35px 0px 35px; margin: auto;}".
			 " .table_container th { background-color: #8FA5FF; color: white; font-weight: bold; border-left: 1px solid white;}".
			 " </style></head><body>";
	// display page title
	echo "<div style='height: 5em; width: 60%; margin-right: 30%; margin-left: 10%; margin-bottom: 2px;'>".
			 "<span style='font-size: 250%; float: none;'>Performers</span>".
			 "<br>".
			 "<hr style='width:50%;'/>".
			 "<br>".
			 "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>".
			 "</div><br>";
	echo "<br>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>";

	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br></div><br>";


		 	// show the current page number out of total pages available
		 	// show the current page number out of total pages available

	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>";
	echo "<br>";
	echo "<div style='padding: 1em 1em 0px; text-align: center; height: 2em; width: 60%; margin-top: 2px; margin-right: 30%; margin-left: 10%; font-size: 100%; float: none;'>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>";
	echo "</div>";
	echo "<div style='padding: 2em 2em 0px; height: 4em; width: 60%; margin-top: 2px; margin-right: 30%; margin-left: 10%; font-size: 150%; float: none;'>";
	echo "<span>Page " .$page_number. " of " .$total_page_number. " </span><br>";
	echo "</div>";
	echo "<br>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>";
	echo "<br>";
	// depends on User_Roles table
	// create the table of performers
	// get users from wp_users where their roles are performers
	$result = $wpdb->get_results(
		$wpdb->prepare("SELECT user_id, display_name, user_url FROM User_Roles INNER JOIN wp_users ON user_id = wp_users.ID WHERE role_id = 1 LIMIT %d, %d",$offset, $total_performers_per_page));

	// style the table


	// display each row of performers in the table; performer names redirect to that performer page
	// TODO: links available to "edit" and "delete" performer, but currently lead to pages that don't exist; need to provide functionality
	//			for editing and deleting performers.
	//			also, display profile images in table.
	echo "<div class=\"table_container\"><table><tr><th style=\"padding-left:10px;\">Image</th><th>Name</th><th>Website</th></tr>";
	foreach ($result as $row){
		$profileID = $row->user_id;
		$userURL = strval($row->user_url);
		$displayName = strval($row->display_name);
		$sqlQuery = $wpdb->prepare("SELECT * from wp_users WHERE ID = %d LIMIT 1", $profileID);
		$profilerow = $wpdb->get_row($sqlQuery, ARRAY_A);
		if(empty($userURL)) {
			$userURL = strval($profilerow['user_url']);
			if(empty($userURL)) {
				$userURL = "ErrorNotFound";
			}
		}
		if(empty($displayName)) {
			$displayName = strval($profilerow['display_name']);
			if(empty($displayName)) {
				$displayName = "ErrorNotFound";
			}
		}
		$sqlQuery = $wpdb->prepare("SELECT * from Profile_Images WHERE profile_id = %d LIMIT 1", $profileID);
		$imagerow = $wpdb->get_row($sqlQuery, ARRAY_A);
		if(!empty($imagerow)) {
			$imagePath = strval($imagerow['image_path']);
		}else{

			$imagePath = strval(get_user_meta($userID, 'profile_image', true));
      if(empty($imagePath)) {
        $imagePath = "";
      }
		}
		echo "<tr>";
		echo "<td><img src='". $imagePath ."' alt='no display' height ='60px' width ='60px' /></td>";
		echo "<td><a href='" . get_bloginfo('url') . "/wordpress/performer?id=" . $profileID . "' style='margin: 10px; text-decoration: underline;'>" . $displayName . "</a></td>";
		echo "<td><span>" . $userURL . "</span></td>";
		echo "</tr>";

	}
	echo "</table></div>";
	//echo '<script>alert("URL: ' . $userURL .' and displayName: '. $profileID .'");</script>';
	//Create the pagination buttons for first, previous, first, and last pages based on current page number:
	echo "<div class='pagination' style='height: 100px; font-size: 18px; text-align: center;'>";

	// displaying "Previous" and "First Page" in separate if statements due to issue with "Previous" displaying even on the very first page
	// TODO: figure out how to fix this issue
	if($page_number > 1)
		echo "<a href='?page_number=1' style='margin: 10px; text-decoration: underline; color=#5274FF;'>&lsaquo;&lsaquo; First Page</a>";
	if($page_number > 1)
		echo "<a href='?page_number=$prev_page' style='margin: 10px; text-decoration: underline; color=#5274FF;'>Previous</a>";

	// displaying "Next" and "Last Page" in separate if statements due to issue with "Last Page" displaying even on the last page
	// TODO: figure out how to fix this issue
	if($page_number < $total_page_number)
		echo "<a href='?page_number=$next_page' style='margin: 10px; text-decoration: underline; color=#5274FF;'>Next</a>";
	if($page_number < $total_page_number)
		echo "<a href='?page_number=$total_page_number' style='margin: 10px; text-decoration: underline; color=#5274FF;'>Last &rsaquo;&rsaquo;</a>";

	echo "</div>";

	// astra method to summon website style footer
	the_content();
	get_footer();
?>
