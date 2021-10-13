<?php
	/*
		Template Name: 	Event List Template
		Website: 		ISC
		Description:	PHP code to display list of events in the database
		Last Edited: 	6/18/2021
	*/
	//took out edit and delete for public facing option for this page
	// TODO: convert file to separate code into PHP and HTML/CSS sections instead of one PHP section with echoing HTML/CSS code

	// contains the domain/IP address of the website to redirect to
	//require "config.php"; //TODO:edit out to see if it breaks

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

	// set the total amount of events per page
	$total_events_per_page = 5;
	$offset = ($page_number-1) * $total_events_per_page;
	$prev_page = $page_number - 1;
	$next_page = $page_number + 1;

	// get the total number of pages for pagination by getting the total number of events public and dividing by
	//		events per page to view
	$total_events = $wpdb->get_var("SELECT COUNT(1) FROM Events WHERE is_public = 1");
	$total_page_number = ceil($total_events / $total_events_per_page);
	echo "<head>".
				"<style>".
				" body {font-family: Arial;}".
				" .table_container {padding: 0em 5em 0em 5em; margin: auto;}".
				" .table_container th { background-color: #8FA5FF; color: white; font-weight: bold; border-left: 1px solid white;}".
				" </style></head><body>";
	// display page title
	echo "<div style='height: 10em; width: 60%; margin-right: 30%; margin-left: 10%; margin-bottom: 2px;'>";
	echo "<span>&nbsp&nbsp&nbsp</span><br>";
	echo "<span style='font-size: 250%; float: none;'> Events </span><br>";
	echo "<span>&nbsp&nbsp&nbsp</span><br>";

	echo "<hr style='width:50%;'/>";
	echo "<br>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br></div><br>";
	echo "<div style='padding: 2em 2em 0px; text-align: center; height: 2em; width: 60%; margin-top: 2px; margin-right: 30%; margin-left: 10%; font-size: 100%; float: none;'>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>";
	echo "</div>";
	echo "<br>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>";
	echo "<br>";
	// show the current page number out of total pages available
	// show the current page number out of total pages available

	echo "<br>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>";
	echo "<br>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br></div><br>";
	echo "<div style='padding: 2em 2em 0px; text-align: center; height: 2em; width: 60%; margin-top: 2px; margin-right: 30%; margin-left: 10%; font-size: 100%; float: none;'>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>";
	echo "</div>";
	echo "<div style='padding: 2em 2em 0px; height: 4em; width: 60%; margin-top: 2px; margin-right: 30%; margin-left: 10%; font-size: 150%; float: none;'>";
	echo "<span>Page " .$page_number. " of " .$total_page_number. " </span><br>";
	echo "</div>";
	echo "<br>";
	echo "<span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span><br>";
	echo "<br>";
	// create the table of events
	$result = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT event_id, name, start_date, end_date, location FROM Events WHERE is_public = 1 LIMIT $offset, $total_events_per_page"
		));
	if(empty($result)) {
		echo '<script>alert("Result is empty");</script>';
	}

	// style the table


	// display each row of events in the table; event names redirect to that event page
	// TODO: links available to "edit" and "delete" event, but currently lead to pages that don't exist; need to provide functionality
	//			for editing and deleting events
	echo "<br><div class=\"table_container\"><table><tr><th style=\"padding-right:10px;\">Name</th><th>Duration</th><th>Location</th></tr>";
	//"<th>Settings</th></tr>";
	foreach ($result as $row){
		//replaced http//.ip_web_address segment with base_url function, more stable for migrations
		//may need to add /wordpress if this doesn't work at the other server
		//tried to make multiline statement... didn't work
		//echo '<script>alert("Event_ID: '. $row->event_id .' ");</script>';
		echo "<tr>";
		echo "<td><a href='".get_bloginfo('url'). "/event?id=" . $row->event_id . "' style='margin: 10px; text-decoration: underline;'>" . stripslashes($row->name) . "</td>";
		echo "<td>" . $row->start_date . " - " . $row->end_date . "</td>";
		echo "<td>" . $row->location . "</td>" . "</tr>";
		//"<td><a href='http://" . $ip_web_address . "/wordpress/edit-event?id=" . $row->event_id . "' style='text-decoration: underline;'>Edit</a>&nbsp&nbsp&nbsp&nbsp&nbsp" .
		//"<a href='http://" . $ip_web_address . "/wordpress/delete-event?id=" . $row->event_id . "' style='text-decoration: underline;'>Delete</td></tr>";
	}
	echo "</table></div>";

	//Create the pagination buttons for first, previous, first, and last pages based on current page number:
	echo "<div class='pagination' style='height: 8em; font-size: 150%; text-align: center;'>";

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
		echo "<a href='?page_number=$total_page_number' style='margin: 10px; text-decoration: underline; color=#5274FF;'>Last Page &rsaquo;&rsaquo;</a>";

	echo "</div>";

	// astra method to summon website style footer

	the_content();

	get_footer();

?>
