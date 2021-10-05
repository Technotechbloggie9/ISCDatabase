<?php
/*  
Properties (all should be protected access)
•	$sourcefield
•	$filename
•	$filedir
•	$fileurl
•	$fallbackfiledir
•	$fallbackfileurl
•	$displaystep
•	$audiovideo
•	$metadataArray
•	$mimetype
Methods (public)
•	detecttype($filename)
•	setup_upload($configarray)
•	uploadmedia()
•	displaymedia(optional $fileurl)
•	makemediarecord($dataArray)
•	persistmediaselect($audiovideo)
•	persistflow($step)
•	persistmime($mime)
•	getmime()
•	getflow()
•	getmediaselect()
Methods (protected)
•	uploadvideo()
•	uploadaudio()
•	displayhtml5audio()
•	displayhtml5video()
•	displaywpvideo()
•	displaywpaudio()
•	persistmetadata()
•	getmetadata()
*/
interface IMediaMaster {
  function detecttype($filename);
  function setup_upload($configarray);
  function uploadmedia();
  function displaymedia($fileurl);
  function makemediarecord($dataArray);
  function persistmediaselect($audiovideo);
  function persistflow($step);
  function persistmime($mime);
  function getmediaselect();
  function getflow();
  function getmime();
  function cleanup();
}
?>