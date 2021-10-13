<?php
function ISCDB_script_load() {


	 global $wpdb;
	 //register actions for the functions in addmenuadmin.php

	 //This line tries to fetch the ISCDB.JS file and prove that it is readable and exists

   $urlBase = get_bloginfo("url"). "/wp-content/plugins/ISCTestCode/js/";
   $dirBase = __DIR__ . "/js/";
   $filename = "ISCDB.js";
   $filePath = $dirBase . "" . $filename;
   $fileURL = $urlBase . "" . $filename;
   /*NOTE:
   previous code did not take into account
   the needs of file_exists require a directory path
   but the needs of wp_enqueue_script require
   a URL path
   */
	 //check if the file exists
	 if(file_exists($filePath)){
		//check if the file can be read when it exists
		if(is_readable($filePath)){
			//echo sprintf('file %s exists and readable',$filename);


			//going to attempt an SQL query
			$Table_Name    = 'Performances';
			$TableResults = $wpdb->get_results("SELECT * FROM $Table_Name");

			//this foreach builds a table for the query done aboce
			//As it iterates, it adds table rows to the table for each SQL entry
			$html = "<table>";
			foreach ($TableResults as $row){
				$html = $html .
				"<tr><td>" . $row->performance_id . "</td><td>" . $row->event_id ."</td><td>" . $row->name . "</td><td>" . $row->start_date        ."</td><td>" . $row->end_date . "</td><td>" . $row->end_time . "</td><td>" . $row->has_adult_content . "</td><td>" . $row->attendance . "</td><td>" . $row->is_public . "</td></tr>"
				;
			}//end of foreach for table rows

			$html = $html."</table>";
			//$html should now have a full table of data from the SQL query
			//it needs this link rel to be included for the ISCDB.js file





			//Passing the html from php to javascript by using script type = text
			echo "<script type = 'text/html' id = 'TableData'>$html</script>";
			//calling the javascript through php by echoing an html script tag which runs the javascript
			echo "<script>PrintTable();</script>";

		}//end of readable condition

		else{
			echo sprintf('file %s exists but not readable',$filename);
		}

	 }//end file_exists if condition

	 //if file does not exist
	 else{
		 echo sprintf('file %s does not exist',$filename);
	 }

			wp_enqueue_script( 'ISCDB-script', $fileURL, array( 'jquery' ), '1.0.0', true );
}//end of ISCDB Script Load function Def

add_action( 'wp_enqueue_scripts', 'ISCDB_script_load' );
//Create Database table function takes two arguments
//table name is the name of the table one wishes to create
//Attribute string are the SQL lines for attributes found in an SQL statement
function create_db_table($tableName, $AttributeString){

//forces the table name to be formatted into a wordpress table name with prefix attached
$table_name = $wpdb->prefix . "$tableName";

//prepare the sql statement
$sql = "CREATE TABLE $table_name (
$AttributesString
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

}//end create_db_table
//This function was made to attempt a regular expression vs. using javascript
//this attempts to read through the html on a page
//It uses regular expression matching to find a div with an ID one specifies in the divID parameter
//The tableName is used for choosing which table to pull from.
function printTableEntriesToDiv($tableName, $divID){

$table = $wpdb->get_results("SELECT * FROM $tableName;");
$content = get_the_content();

if (preg_match('/<div id="$divID">([^<]*)<\/div>/', $content, $matches) ) {
    echo $matches[1]; //This is the div with id tag
}

echo $table;


}//end printTableEntriesToDiv
?>