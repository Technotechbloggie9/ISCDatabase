<?php
/*interface IKeeper 
is defined to allow a SessionKeeper similar to CookieKeeper
basically creating a generic format to do the same things
*/
interface IKeeper{
  function store($value);
  function retrieve();
  function kill();
}
?>