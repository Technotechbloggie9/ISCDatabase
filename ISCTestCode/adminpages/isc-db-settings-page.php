<?php
require ABSPATH . "wp-content/plugins/ISCTestCode/shell-functions/process-settings.php";

function isc_db_settings_page(){
    echo "<link rel='stylesheet' href='". get_bloginfo('url'). "/wp-content/plugins/ISCTestCode/css/style.css" ."'>";
    if($_SERVER['REQUEST_METHOD'] == 'POST' AND isset($_POST['submit_options'])) {
        echo process_db_settings($_POST['db_options']);
    }else{
        echo show_db_settings_form();
    }
}
function show_db_settings_form(){
  $htmloutput = '';
  $htmloutput = $htmloutput . '<br><br><div class="cmdscreen mono1 topwidth" style="height: 10em;"><br><br><span class="title1">Options for Database Recovery:</span></div><br><br>';
  $htmloutput = $htmloutput . '<span class="mono1 normal1">(either of these options will run a shell script)</span><br><br>';
  $htmloutput = $htmloutput . '<span class="mono1 normal1">(permissions/configuration issues may result in no result being affected, with no error generated and normal feedback)</span><br><br>';
  $htmloutput = $htmloutput . '<form method="POST" action="#">';
  $htmloutput = $htmloutput . '<div>';
  $htmloutput = $htmloutput .  '<input type="radio" id="select_backup" name="db_options" value="select_backup" checked>';
  $htmloutput = $htmloutput . '<label for="select_backup" class="medium1">Backup Database</label>';
  $htmloutput = $htmloutput . '</div><br><br>';
  $htmloutput = $htmloutput . '<div>';
  $htmloutput = $htmloutput . '<input type="radio" id="select_reset" name="db_options" value="select_reset">';
  $htmloutput = $htmloutput . '<label for="select_reset" class="medium1">Reset Database</label>';
  $htmloutput = $htmloutput . '</div><br><br>';
  $htmloutput = $htmloutput . '<input type="submit" id="submit_options" name="submit_options" value="Submit">';
  $htmloutput = $htmloutput . '</form>';
  return $htmloutput;
}


 ?>