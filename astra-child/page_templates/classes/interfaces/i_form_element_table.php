<?php 
/*
Display Elements, SubDisplay Elements, and Feedback Elements should
all be able to use this basic interface, each function wrapped should have 
a return... and this is used with the return statement of the dispatch function

*/
interface IFormElementTable {
  /*NOTE:
  as $keyvaluepair = ["name" => function(
  secondaryfunctioncall($parameters)
  )
  ]
  the reason this is done is to hide the 
  parameters from those using the class*/
  function addelementfunction($keyvaluepair);
  function elementdisplay($keyname);
}
 ?>