<?php
  interface IWorkflow{
    function doTrigger($triggername);
    //trigger should be string
    //trigger works with internal dispatch table
    function redefineWorkflow($triggerdispatcharray);
    //should work with array_replace()
    //redefines the dispatch table
    function checkState();
    //should return $currentState
    function doNext();
    //should perform the next trigger
    //hopefully everything is in order if this is used
    function setupError($infomessagearray);
    //setup the linkage of info and message if an error occurs
    function doError($info);
    //should display some formatted message, or put it in log
  }
?>