<?php 
/*
TODO: parameters need type hints
*/
interface IRecordTable{
  function buildtable($recordname, $recordelementnames, $recordtypes);
  function displaytable();
  /*
  this function is used internally, but is public for testing purposes
  */
  function buildrow($recordvalues);
}
 ?>