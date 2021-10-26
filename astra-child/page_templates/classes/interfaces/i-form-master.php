<?php 
/*
...
some types have JQuery picker

this may present some difficulty 
(depending on how it is done)
as the picker
must be added as a script in the head of the html
perhaps a define record
then invoke pickers
then invoke the form after the main formatting code
the formatting code anticipates the 
css for the form being in place
the abstact AStandardFormMaster
may contain simple methods that are used by
the define record loop
loop (until end of array)
  make form... perhaps by a dispatch table
  example loop through associative array
  foreach($age as $x => $x_value) {
  echo "Key=" . $x . ", Value=" . $x_value;
  echo "<br>";
  }
  where the array is defined like
  $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");
  to create unique names may need to fetch the uvalues
end loop
...
record types
------------
text
textarea
date
time
number
tinyint

*/
/* NOTE:
use of array_combine to create associative arrays
is implied in how to setup forms,
there must be some way to create hidden feedback
*/
interface IFormMaster{
  function buildform($elementnames, $elementtypes);
  function prefillelements($elementnames, $recordnames);
  function displayform();
  function displayprefilled();
  function setupprocess($recordnames, $recordtypes);
  function setupfeedback($elementnames, $recordnames);
}
 ?>