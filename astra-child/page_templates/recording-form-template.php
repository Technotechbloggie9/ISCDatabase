<?php

/*
    Template Name:     Recording Form Template
    Website:         ISC
    Description:    Template for the Recording Form
    Last Edited:     8/4/2021
*/
/*NOTE:
Created 7/29
Worked on until 8/4
Although the video and audio portions of
media selection forms, both work in similar ways,
load the same form building function,
each ends up with a different logical outcome,
audio works as intended,
but video ends up in error-catching,
with the submit button titled "Add Recording"
and with the name and id of "submit_create_rec"
not being recognized as being set.
The true point of origin of this error
has not been found despite diligent review.

No indicators of this error are found in debug.log

It may be possible to create a workaround for the damaged logic with cookies
Cookies are added on 8/4

*/
get_header();
//---Ternaries & variable declaration---

if(!isset($_COOKIE['displayer']) OR empty(getmediainfo())) {
  $showfrontform = true;
  setdisplay('frontform');
}
$form_posted = ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
$videoSupportOn = true; //turns off video support if set to false
$submit_is_set = isset($_POST['submit_create_rec']);
$front_submit_is_set = isset($_POST['submit_av']);
$showform = ($front_submit_is_set == true && $submit_is_set !== true) ? true : false;
$showfrontform = ($form_posted !== true && $front_submit_is_set !== true) ? true : false;
$displayError = false;
if($videoSupportOn == false){
  $front_submit_is_set = true;
  $showform = ($submit_is_set !== false) ? true : false;
  $showfrontform = false;
  setdisplay('mainform');
}
$performancePicked = !empty($_POST['select_performance']);
$showprocessing = ($submit_is_set !== true && $performancePicked !== true) ? false : true;
if($showprocessing == true OR $submit_is_set){
  alertrf("either submit_is_set or showprocessing is set true");
  $showprocessing = true;
  $submit_is_set = true;
  $showform = false;
  $showfrontform = false;
  if(!setdisplay('processing')) {
    setdisplay('processing');
  }
}else if($showform == true OR $showfrontform == true) {
  alertrf("a display form is enabled");
}else{
  $showform = ($_COOKIE['displayer'] == "mainform") ? true : false;
  $showfrontform = ($_COOKIE['displayer'] == "frontform") ? true : false;
  $showprocessing = ($_COOKIE['displayer'] == "processing") ? true : false;
  $submit_is_set = ($_COOKIE['displayer'] == "processing") ? true : false;

}
//--------------------------------------

//---Main if statement----------
  $pageTitle = "Add Recording";
  //echo titledisplayrf($pageTitle); made titlewraprf to fix display issues
if ($showform == true OR $_COOKIE['displayer'] == 'mainform'){
  if ($videoSupportOn == true) {
    $audiovideo = sanitize_text_field($_POST['select_av']);
    setmediainfo($audiovideo);
  }else{
    $audiovideo = 'A';
    setmediainfo($audiovideo);
  }
  //$audiovideo = getmediainfo();
  if(!empty($audiovideo)) {
    alertrf("Audio or video:". $audiovideo);
    $rfMain = mainbodyrf($audiovideo);
    echo titlewraprf($pageTitle, $rfMain);
  }else{
    echo "<p> Error establishing correct parameters. </p>";
  }
  setdisplay("processing");
}else if($showfrontform == true AND $videoSupportOn == true){
  echo titlewraprf($pageTitle, frontformrf());
  setdisplay("mainform");
}else if($showprocessing == true OR $_COOKIE['displayer'] == "processing") {
  echo processrfform();
  echo ($submit_is_set == true) ? " Submitted from form. " : " Not submitted from form. ";
  echo "<p>" . $_POST['txtAV'] . "</p>";
  echo "<p>" . $_POST['select_performance'] . "</p>";
  echo "<p>" . $_FILES['fileAV']['name'] . "</p>";
  killdisplay();
  killmediainfo();
}else if($displayError == true AND !isset($_COOKIE['displayer'])){
  echo "<p>Fallback to front form due to error.</p>";
  echo titlewraprf($pageTitle, frontformrf());
  setdisplay("mainform");
}else{
  if ($videoSupportOn == true) {
    $audiovideo = sanitize_text_field($_POST['select_av']);
    if(empty($audiovideo)) {
      $audiovideo = 'V';
    }
    setmediainfo($audiovideo);
  }else{
    $audiovideo = 'A';
    setmediainfo($audiovideo);
  }
  //$audiovideo = getmediainfo();
  if(!empty($audiovideo)) {
    alertrf("Audio or video:". $audiovideo);
    $rfMain = mainbodyrf($audiovideo);
    echo titlewraprf($pageTitle, $rfMain);
  }else{
    echo "<p> Error establishing correct parameters. </p>";
  }
  setdisplay("processing");
}
the_content();
get_footer();
//------------------------------
/*

ready_for_release should be set in main form,
while permission_to_release should be on another page
video ended up being a hard feature to support
play_count may end up being a misnomer, and will end up being an access count,
if supported at all, this will be on page view,
format
Due to a variety of underlying issues with the technologies involved,
not all video or audio formats can be guaranteed for playback for all users,
Playback varies by browser, below are common video types
--------------------------------------------------------
video/3gpp 	.3gp
video/mp4 	.mp4, .m4a, .m4p, .m4b, .m4r, .m4v
video/mpeg 	.m1v
video/ogg 	.ogg
video/quicktime 	.mov, .qt
video/webm 	.webm
video/x-m4v 	.m4v
video/ms-asf 	.asf, .wma, .wmv
video/x-ms-wmv 	.wmv
video/x-msvideo 	.avi
----------------------------------------------------------
Audio mime types (common)
----------------------------------------------------------
File Extension 	  MIME Type 	   RFC
au 	              audio/basic 	 RFC 2046
snd 	            audio/basic
Linear PCM 	      audio/L24 	   RFC 3190
mid 	            audio/mid
rmi 	            audio/mid
mp3 	            audio/mpeg 	   RFC 3003
mp4 audio 	      audio/mp4
aif 	            audio/x-aiff
aifc 	            audio/x-aiff
aiff 	            audio/x-aiff
m3u 	            audio/x-mpegurl
ra 	              audio/vnd.rn-realaudio
ram 	            audio/vnd.rn-realaudio
Ogg Vorbis 	      audio/ogg 	    RFC 5334
Vorbis 	          audio/vorbis 	  RFC 5215
wav 	            audio/vnd.wav 	RFC 2361
Of the audio types listed those under RFC (au, ogg, vorbis, wav) or
common use (mid, mpg3, mp4, aif variants on Apple technology)
should be targeted
L24 is not considered due to the RTP use case, which doesn't apply here
M3U is apparently a playlist format for audio, there are security issues with it as well,
-------
Targets
-------

--------------------------------------------------------
This is still a lot of formats
(18 headings, presumed codecs, with roughly 30 extensions),
(the mime types should cover file picker support, and appropriate codec loading)
so most will not be tested (in terms of playback, which is the uncertainty)
Access to the video/audio or video/audio creation technology is key
to testing.



*/
/*
On front page:
Select: audio or video
Submit: Next (select_av)
On main page:
Title: Add Recording
File Input: Choose Video File OR
File Input: Choose Audeo File
Select Performance
Hidden Textbox: txtAV (stores A or V for audio or video)

*/
function frontformrf(){
  $frontform = ''.
  '<br><br><label for="select_av" class="mediumrf">Select Media Type : </label>'.
  '<select id="select_av" name="select_av">'.
  ' <option value=""> </option>'.
  ' <option value="A">Audio</option>'.
  ' <option value="V">Video</option>'.
  '</select><br><br>';
  $frontcontent = ''. formwraprf($frontform, 'form_av', 'submit_av', 'Next');
  $frontbody = divwraprf($frontcontent, "squareup");
  $frontbody = divwraprf($frontbody, "fullwidth");
  return $frontbody;
}
function mainbodyrf($audiovideo) {
  if(empty($audiovideo)) {
    $audiovideo = getmediainfo();
  }
  //titledisplayrf($title); //will be needed if the title is different in processing
  $videoaccept = "accept='video/3gpp,video/mp4,video/mpeg,video/ogg,video/quicktime,video/webm,video/x-m4v,video/ms-asf,video/x-ms-wmv,video/x-msvideo'";
  $videoacceptfallback = "accept='video/*'";
  $audioaccept = "accept='audio/basic,audio/mid,audio/mpeg,audio/mp4,audio/x-aiff,audio/ogg,audio/vnd.wav,audio/vorbis'";
  $audioacceptfallback = "accept='audio/*'";
  $mediachoicelabel = ($audiovideo == 'V') ? 'Choose video file' : 'Choose audio file:' ;
  $accept = ($audiovideo == 'V') ? $videoaccept : $audioaccept;
  //function labeledtxtinputrf($label, $name, $gReq = '', $class = 'mediumrf', $value = '')
  $mainform = ''.
  ''. labeledtxtinputrf('', 'txtAV', 'hidden', 'mediumrf', $audiovideo) .''.
  ''. divwraprf('&nbsp;', 'squareup') .'<br>'.
  ''. labeledfilesinputrf($mediachoicelabel, 'fileAV', $accept) .''.
  ''. divwraprf('&nbsp;', 'squareup') .'<br>'.
  ''. performance_select_rf() .''.
  ''. divwraprf('&nbsp;', 'squareup') .'<br>'.
  ''. checkboxrf('Ready for release', 'checkReady') .'<br>';
  $maincontent = ''. formwraprf($mainform, 'form_create_rec', 'submit_create_rec', 'Add Recording');
  $mainbody = divwraprf($maincontent, "squareup");
  $mainbody = divwraprf($mainbody, "topwidth");
  return $mainbody;
}
function processrfform(){
  //titledisplayrf($title); //will be needed if the title is different in main
  /*
  audio/basic
  audio/mid
  audio/mpeg
  audio/mp4
  audio/x-aiff
  audio/ogg
  audio/vnd.wav
  audio/vorbis
  --------------------------------------------------------
  video/3gpp 	(included because of smartphones)
  video/mp4
  video/mpeg
  video/ogg
  video/quicktime
  video/webm
  video/x-m4v
  video/ms-asf
  video/x-ms-wmv
  video/x-msvideo
  mime_content_type

  (PHP 4 >= 4.3.0, PHP 5, PHP 7, PHP 8)

  mime_content_type — Detect MIME Content-type for a file
  Description ¶
  mime_content_type(resource|string $filename): string|false

  Returns the MIME content type for a file as determined by using information from the magic.mime file.
  Parameters ¶

  filename

      Path to the tested file.
      +--------------------------+--------------+------+-----+---------+----------------+
      | Field                    | Type         | Null | Key | Default | Extra          |
      +--------------------------+--------------+------+-----+---------+----------------+
      | performance_recording_id | int(11)      | NO   | PRI | NULL    | auto_increment |
      | performance_id           | int(11)      | NO   | MUL | NULL    |                |
      | recording_name           | varchar(255) | YES  |     | NULL    |                |
      | recording_path           | varchar(255) | YES  |     | NULL    |                |
      | format                   | varchar(20)  | YES  |     | NULL    |                |
      | play_count               | int(11)      | NO   |     | 0       |                |
      | runtime                  | time         | YES  |     | NULL    |                |
      | sequence_number          | int(11)      | YES  |     | NULL    |                |
      | permission_to_release    | tinyint(1)   | NO   |     | NULL    |                |
      | ready_for_release        | tinyint(1)   | NO   |     | NULL    |                |
      | audio_or_video           | char(1)      | NO   |     | A       |                |
      +--------------------------+--------------+------+-----+---------+----------------+

  */
  global $wpdb;
  $audiotargets = array(
    "audio/basic",
    "audio/mid",
    "audio/mpeg",
    "audio/mp4",
    "audio/x-aiff",
    "audio/ogg",
    "audio/vnd.wav",
    "audio/vorbis"
  );
  $videotargets = array(
    "video/3gpp",
    "video/mp4",
    "video/mpeg",
    "video/ogg",
    "video/quicktime",
    "video/webm",
    "video/x-m4v",
    "video/ms-asf",
    "video/x-ms-wmv",
    "video/x-msvideo"
  );
  $upload_dir = wp_upload_dir();
  //---Path Check/Make -----------------------------------
  $path_created = false;
  $path_existed = false;
  if(!empty($upload_dir['basedir'])) {
      $rec_dir = strval($upload_dir['basedir']).'/narrativemedia/';
      if(!file_exists($rec_dir)) {
          wp_mkdir_p($rec_dir);
          $path_created = true;
      }else{
          $path_existed = true;
      }
  }
  //--------------------------------------------------------
  //----Variable Setup--------------------------------------
  $performanceID = intval($_POST['select_performance']);
  $recordingName = strval(basename($_FILES["fileAV"]["name"]));
  $path_valid = ($path_created == true || $path_existed == true) ? true : false;
  $path_invalid = ($path_created !== true && $path_existed !== true) ? true : false;
  $playcount = 0;
  $releasePermission = 0;
  $checkboxset = (bool) isset($_POST['checkReady']);
  $releaseReady = ($checkboxset == true) ? 1 : 0;
  $audiovideo = sanitize_text_field($_POST['txtAV']);
  if(empty($audiovideo) AND isset($_COOKIE['mediainfo'])) {
    $audiovideo = getmediainfo();
  }
  $result = "<p>Unknown. </p>";
  //---------------------------------------------------------

  if($path_valid == true){
    //Path is taken to be URL, as this works best against the uses of the database
    //Dir is taken to be file directory path, which will help with the move_uploaded_file function

    $recordingDir = $upload_dir['basedir'] . '/narrativemedia/' . $performanceID . "_" . $recordingName;
    alertrf($recordingDir);
    $recordingPath = get_bloginfo('url') . '/wp-content/uploads/narrativemedia/' . $performanceID . "_" . $recordingName;
    /*
    mime_content_type worked differently than expected,
    due to this,
    file is uploaded without full check (poor practice, insecure)
    then the file is checked and deleted.
    This only will provide seconds if attack is to be performed.
    This code is not ideally secure, as of yet.
    */
    $fileStored = move_uploaded_file($_FILES["fileAV"]["tmp_name"], $recordingDir);
    $format = mime_content_type($recordingDir);//changed due to string type argument issue: ($_FILES["fileAV"]["tmp_name"]);
    alertrf($format);
    if($audiovideo == 'A') {
      //$supported = in_array($format, $audiotargets);
      $supported = true; //not a safe setting
    }else if($audiovideo == 'V' ){
      //alertrf($audiovideo);
      //$supported =  in_array($format, $videotargets);
      $supported = true; //not a safe setting
    }else{
      alertrf("Audio or Video: " . $audiovideo);
      echo "<p> Error: some setting is missing </p>";
      $supported = false;
    }
    if($supported == true){
      $deleted = false;
    }else{
      $deleted = unlink($recordingDir);

      $fileStored = false;
      alertrf("The file type ". $format ." is not supported. ");
    }
    if($fileStored == false){
      alertrf("The file was not stored");
    }else{
      $sqlQuery = $wpdb->prepare("INSERT INTO Performance_Recording".
        "(performance_id, recording_name, recording_path, format, play_count,".
        "permission_to_release, ready_for_release, audio_or_video)".
        "VALUES(%d, %s, %s, %s, %d, %d, %d, %s)", $performanceID, $recordingName, $recordingPath, $format, $playcount, $releasePermission, $releaseReady, $audiovideo);
      $done = $wpdb->query($sqlQuery);
      if (is_int($done) AND ($done > 0)) {
          $result = '<br><br><p>Database submission success (Performance_Recording), '. $done .' rows inserted. </p><br>';
          if($audiovideo == 'A'){
            $result = $result . '<br><br>'. audiocontainer($recordingPath, $format);
          }else if($audiovideo == 'V'){
            $result = $result . '<br><br>'. videocontainer($recordingPath, $format);
          }else{
            $result = "<p> Error. </p>";
          }
      }else{
          echo '<script>alert(" Result of submission unknown. "</script>';
      }//else $done
    }
  }else if($path_invalid == true){
    alertrf(" Error: File-path does not exist. ");
  }else{
    alertrf(" Error: Unknown if file-path exists. ");
  }
  return $result;
}
function videocontainer($videoPath, $format){
$htmloutput = ''.
    '<div class="video-container">'.
      '<video controls>'.
        '<source src="'. $videoPath .'" type="'.$format.'" />'.
        ' Your browser does not support the video tag. '.
      '</video>'.
    '</div>';
    return $htmloutput;
}
function audiocontainer($audioPath, $format){
  $htmloutput = ''.
  '<div class="squareup">'.
  '<video controls>'.
    '<source src="'. $audioPath .'" type="'.$format.'" />'.
    ' Your browser does not support the audio tag. '.
  '</video></div>';
  return $htmloutput;
}
function titlewraprf($title, $content){
  $htmloutput = "";
  $htmloutput = $htmloutput . "<div class='squareup'>";
  $htmloutput = $htmloutput . "<span class='titlerf' style='font-size: 300%; height: 3em;'>";
  $htmloutput = $htmloutput . $title ."</span><br>";
  $htmloutput = $htmloutput . "<hr><br></div><br><br>";
  $htmloutput = $htmloutput . divwraprf($content, 'topwidth') .'<br><br>';
  $htmloutput = divwraprf($htmloutput, 'topwidth') .'<br><br>';
  return $htmloutput;
}
function checkboxrf($label, $name, $checked = "checked"){
  $htmloutput = '';
  $htmloutput = $htmloutput . '<div>';
  $htmloutput = $htmloutput . '<input type="checkbox" id="'.$name.'" name="'. $name .'" '.$checked.' class="mediumrf">';
  $htmloutput = $htmloutput . '<label for="'. $name .'" class="mediumrf">'. $label .'</label></div><br><br>';
  return $htmloutput;
}
function formwraprf($content, $form_name, $submit_name, $btn_label){
  $htmloutput = '';
  $htmloutput = $htmloutput . '<form id="'. $form_name .'" method="POST" enctype="multipart/form-data" action="#">';
  $htmloutput = $htmloutput . $content;
  $htmloutput = $htmloutput . '<br><br><input type="submit" id="'. $submit_name .'" name="'. $submit_name .'" value="'. $btn_label .'"/><br><br>';
  $htmloutput = $htmloutput . '</form><br><br>';
  return $htmloutput;
}
function divwraprf($content, $class){
  $htmloutput = "";
  $htmloutput = $htmloutput . "<br><div class='".$class."' >";
  $htmloutput = $htmloutput . $content;
  $htmloutput = $htmloutput . "</div><br><br>";
  return $htmloutput;
}
function labeledfilesinputrf($label, $name, $accept){
  $value = "";
  $type = "file";
  $gSize = "22em";
  $gReq = "required";
  $class = "mediumrf";
  $inputCode = "<label for='".$name."' class='". $class ."' >". $label . "</label>".
  "<div>".
  "  <input type='". $type ."' class='". $class ."' id='". $name ."'".
  " name='". $name ."' size='".$gSize ."' ".
  "maxlength='128' style='width:auto; box-shadow: 5px 5px 2px grey;' ".
  $accept ." ".$gReq." />".
  "</div>";
  return $inputCode;
}
function alertrf($content){
  $htmloutput = '<script>alert("'.$content.'")</script>';
  echo $htmloutput;
}
function performance_select_rf(){
  global $wpdb;
  $sqlQuery = "SELECT * from Performances";
  $results = $wpdb->get_results($sqlQuery);
  $htmloutput = "";
  $htmloutput = $htmloutput . "<label for='select_performance' class='mediumrf'>Performance to Add Recording To: </label>";
  $htmloutput = $htmloutput . "<select name='select_performance' id='select_performance'>";
  foreach($results as $performance){
      $htmloutput = $htmloutput .  "<option value='". $performance->performance_id ."'> ". stripslashes($performance->name) . " (" . $performance->start_date." ) </option>";
  }
  $htmloutput = $htmloutput . "</select>";
  return $htmloutput;
}
function labeledtxtinputrf($label, $name, $gReq = '', $class = 'mediumrf', $value = ''){
  $type = "text";
  $gSize = "22em";
  $inputCode = "<label for='".$name."' class='". $class ."' >". $label . "</label>".
  "<div>".
  "  <input type='". $type ."' class='". $class ."' id='". $name ."' name='". $name ."' value='". $value ."' size='". $gSize ."' maxlength='128' style='width:auto; box-shadow: 5px 5px 2px grey;' ".$gReq." />".
  "</div>";
  return $inputCode;
}
/*
Function Name: setdisplay
Parameters: $displayvalue (string)

*/
function setdisplay($displayvalue){
  $expires = (1/48); //approximately 30 minutes, or 1800 seconds
  $cookie_name = "displayer"; //changed name due to error
  $currentexpiration = time () + (86400 * $expires);
  $allowedpath = "/";//the backslash indicates that this cookie is accessible across the entire server
  setcookie($cookie_name, $displayvalue, $currentexpiration, $allowedpath);
  $display_is_set = isset($_COOKIE['displayer']);
  return $display_is_set;
}
function getdisplay(){
  return $_COOKIE['displayer'];
}
function killdisplay(){
  $cookie_name = "displayer";
  $displayvalue = "";
  $currentexpiration = time () - 3600;
  $allowedpath = "";//the backslash indicates that this cookie is accessible across the entire server
  setcookie($cookie_name, $displayvalue, $currentexpiration, $allowedpath);
  $display_is_set = !isset($_COOKIE['displayer']);
  return $display_is_set;
}
function setmediainfo($displayvalue){
  $expires = (1/48); //approximately 30 minutes, or 1800 seconds
  $cookie_name = "mediainfo";
  $currentexpiration = time () + (86400 * $expires);
  $allowedpath = "/";//the backslash indicates that this cookie is accessible across the entire server
  setcookie($cookie_name, $displayvalue, $currentexpiration, $allowedpath);
  $media_is_set = isset($_COOKIE['mediainfo']);
  return $media_is_set;
}
function getmediainfo(){
  return $_COOKIE['mediainfo'];
}
function killmediainfo(){
  $cookie_name = "mediainfo";
  $displayvalue = "";
  $currentexpiration = time () - 3600;
  $allowedpath = "";//the backslash indicates that this cookie is accessible across the entire server
  setcookie($cookie_name, $displayvalue, $currentexpiration, $allowedpath);
  $media_is_set = !isset($_COOKIE['mediainfo']);
  return $media_is_set;
}
 ?>