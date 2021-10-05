<?php
/*
    Template Name:     Recording Page Template
    Website:         ISC
    Description:    Template for the Recording Form
    Last Edited:     7/29/2021
*/
require_once "utility.php";
/*
NOTE: This page is not currently used because media playback can be done directly via URL link to media
There is better control with the html5 video tag however,
and there may be reason to use a page to show other aspects of the media not shown on the browse page.
Needs URL $_GET and sanitize_text_field for each variable
*/

function displayvideo($width, $height, $source, $type, $altsource, $alttype){
  $htmloutput = ''.
  '<video width="'.$width.'" height="'. $height .'" controls>'.
   '<source src="'. $source .'" type="'. $type .'"'.
   '<source src="'. $altsource .'" type="'. $alttype .'"'.
  'Your browser does not support the video tag.'.
  '</video>';
  return $htmloutput;
}
function displayaudio(){
  $htmloutput = ''.
  '<audio width="'.$width.'" height="'. $height .'" controls>'.
   '<source src="'. $source .'" type="'. $type .'"'.
   '<source src="'. $altsource .'" type="'. $alttype .'"'.
  'Your browser does not support the video tag.'.
  '</audio>';
  return $htmloutput;
}
 ?>