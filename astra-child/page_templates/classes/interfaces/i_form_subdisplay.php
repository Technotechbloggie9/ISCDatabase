<?php 
/*
$options is assumed to be array of text
like simple list instead of associative
*/
interface ISubDisplay{
  function setupsub($options);
  function displaysub($options);
}
 ?>