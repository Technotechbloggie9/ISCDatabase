<?php
/*
    Template Name:     Recording List Template
    Website:         ISC
    Description:    Template for the Recording Form
    Last Edited:     8/5/2021
*/
  //--call main function ---
  get_header();
  echo titlewrap_rl("Browse Narrative Media", mainreclist());
  the_content();
  get_footer();
  //------------------------
  function mainreclist() {
    global $wpdb;
    $htmloutput = "";
    $htmloutput = $htmloutput . "<div class='isctable topwidth normal1'><br>";
    $htmloutput = $htmloutput . tablehead_rl();
    $htmloutput = $htmloutput . tablerows_rl();
    $htmloutput = $htmloutput . "<br></div>";
    return $htmloutput;

  }
  function tablerows_rl(){
    global $wpdb;
    //--DB variables------------
    $releaseReady = 0;
    $releasePermission = 0;
    $recordingAV = "";
    $recordingPath = "#";
    $performance = "";
    $performanceID = 0;
    $eventID = 0;
    $event = "";
    $release_status = "ERROR";
    $linkLabel = "play recording";
    //---------------------------
    //--- release status setup ---
    $pending_release = false;
    $released = false;
    $no_release = false;
    $release_error = true;
    //----------------------------

    $sqlQuery = $wpdb->prepare("SELECT * FROM Performance_Recording ORDER BY performance_id");
    $results = $wpdb->get_results($sqlQuery);
    $htmloutput = "";
    foreach($results as $recRow){
      $recordingAV = $recRow->audio_or_video;
      $recordingPath = $recRow->recording_path;
      $releaseReady = $recRow->ready_for_release;
      $releasePermission = $recRow->permission_to_release;
      $released = ($releaseReady > 0 && $releasePermission > 0) ? true : false;
      /*
      NOTE:
      Nested ifs are for reliability here,
      Rationale: Some status check style logic has yielded surprising results
      during the course of this project
      */
      if($released == true){
        $release_status = "RELEASED";
        $release_error = false;
      }else{
        $pending_release = ($releaseReady > 0 && $releasePermission < 1) ? true : false;
        if($pending_release == true){
          $release_status = "PENDING";
          $release_error = false;
        }else{
          $no_release = ($releaseReady < 1 && $releasePermission < 1) ? true : false;
          if($no_release == true){
            $release_status = "NO";
            $release_error = false;
          }else{
            $release_status = "ERROR";
            $release_error = true;
          }
        }
      }
      $performanceID = intval($recRow->performance_id);
      $sqlQuery = $wpdb->prepare("SELECT * FROM Performances WHERE performance_id = %d", $performanceID);
      $performanceRow = $wpdb->get_row($sqlQuery);
      $performance = $performanceRow->name;
      $eventID = $performanceRow->event_id;
      if(!empty($eventID) AND $eventID > 0) {
        $sqlQuery = $wpdb->prepare("SELECT * FROM Events WHERE event_id = %d", $eventID);
        $eventRow = $wpdb->get_row($sqlQuery);
        $event = $eventRow->name;
      }else{
        $event = " ";
      }
      
      $htmloutput = $htmloutput . "<div class='iscrow topwidth'>";
      $colNum = altNum_rl($colNum);
      $colName = "isccol" .strval($colNum);
      $htmloutput = $htmloutput . numColDiv_rl($recordingAV, $colName);
      $colNum = altNum_rl($colNum);
      $colName = "isccol" .strval($colNum);
      $htmloutput = $htmloutput . numColDiv_rl(stripslashes($performance), $colName);
      $colNum = altNum_rl($colNum);
      $colName = "isccol" .strval($colNum);
      $htmloutput = $htmloutput . numColDiv_rl(stripslashes($event), $colName);
      $colNum = altNum_rl($colNum);
      $colName = "isccol" .strval($colNum);
      $htmloutput = $htmloutput . numColDiv_rl($release_status, $colName);
      $colNum = altNum_rl($colNum);
      $colName = "isccol" .strval($colNum);
      $view = "<a href='". $recordingPath ."'>Play Recording</a>";
      $htmloutput = $htmloutput . numColDiv_rl($view, $colName);

      $htmloutput = $htmloutput . "</div>";
    }
    return $htmloutput;
  }
  function tablehead_rl(){
    $htmloutput = "" .
    "  <div class='iscrow topwidth'>" .
    "    <div class='isctablehead'>Audio or Video</div>" .
    "    <div class='isctablehead'>Performance</div>" .
    "    <div class='isctablehead'>Event</div>" .
    "    <div class='isctablehead'>Released</div>".
    "    <div class='isctablehead'>Link</div>".
    "  </div>";
    return $htmloutput;
  }


  function numColDiv_rl($content, $colName){
    $htmloutput = "    <div class='". $colName ."'> ". $content ." </div>";
    return $htmloutput;
  }
  function altNum_rl($lastNum){
    if($lastNum == 1){
      $newNum = 2;
    }else{
      $newNum = 1;
    }
    return $newNum;
  }

 function titlewrap_rl($title, $content){
   $htmloutput = "";
   $htmloutput = $htmloutput . "<div class='topwidth'>";
   $htmloutput = $htmloutput . "<span class='titlerf'>";
   $htmloutput = $htmloutput . $title ."</span><br>";
   $htmloutput = $htmloutput . "<hr><br></div><br><br>";
   $htmloutput = $htmloutput . divwrap_rl($content, 'topwidth') .'<br><br>';
   $htmloutput = divwrap_rl($htmloutput, 'topwidth') .'<br><br>';
   return $htmloutput;
 }
 function divwrap_rl($content, $class){
   $htmloutput = "";
   $htmloutput = $htmloutput . "<br><div class='".$class."' >";
   $htmloutput = $htmloutput . $content;
   $htmloutput = $htmloutput . "</div><br><br>";
   return $htmloutput;
 }
 ?>