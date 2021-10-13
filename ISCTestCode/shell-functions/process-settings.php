<?php

function process_db_settings($dbOption){
    $jumpdir = ABSPATH . "wp-content/plugins/ISCTestCode/shell-functions";
    $old_path = getcwd();
    $output = '';
    if($dbOption == 'select_reset') {
      //$command = 'cd '. $jumpdir .' &&
      chdir($jumpdir);
      if(current_user_can('promote_users')){
        $command = 'ls';
        $output = $output .'<br><br>Terminal:' . shell_exec($command);
        $command = 'whoami';
        $output = $output .'<br><br>Terminal:' . shell_exec($command);
      }
      $command = 'bash '. $jumpdir .'/reloadwordpress.sh -u nextdev -p admin52';
      $output = $output .'<br><br>Terminal: ' . shell_exec($command);
      $formattedoutput = "<p class='cmdscreen mono1'>". $output ."</p>";

    }else if($dbOption == 'select_backup') {
      //

      chdir($jumpdir);
      if(current_user_can('promote_users')){
        $command = 'ls';
        $output = $output .'<br><br>Terminal: ' . shell_exec($command);
        $command = 'whoami';
        $output = $output .'<br><br>Terminal:' . shell_exec($command);
      }
      $command = 'bash '. $jumpdir .'/backupwordpress.sh -u nextdev -p admin52';
      $output = $output .'<br><br> Terminal: ' . shell_exec($command);
      $formattedoutput = "<p class='cmdscreen mono1'>". $output ."</p>";

    }else{
      //error
      $output = "Terminal: This action resulted in an error";
      $formattedoutput = "<p class='cmdscreen mono1'>". strval($output) ."</p>";

    }
    chdir($old_path);
    return $formattedoutput;
}
 ?>