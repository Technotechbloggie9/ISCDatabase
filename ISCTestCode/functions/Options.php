<?php
// creates custom plugin settings menu
// This menu shows up on the wordpress dashboard
// This can be expanded for making plugin settings
// If admin wishes to create configuration pages

// this action executes the create_menu function when
// the admin loads the dashboard menu



//the Create_Menu function runs the wordpress function for creating



// registers the settings so that they can be used on wordpress
// this is required for all settings
function register_isc_database_creation_settings() {
	//register our settings
	register_setting( 'isc-database-creation-group', 'Backup ISC Database' );
	register_setting( 'isc-database-creation-group', 'Reset ISC database' );
}


// this function creates the html and formatting for the menu on the page
// to modify options one would need to change the table rows and table cells
// to handle the settings, one would need to POST the form and write php code to handle said POST
// this currently is not operable one would need to make the php handling side of this form
// note that the value of each input type goes back into php
// this allows one to echo  a php function to fetch the needed value for the input type
// This goes back to the registering of settings in the earlier function
// it looks into the option group and fetches one with inputted name
 ?>
