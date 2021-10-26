<?php 
interface IFormProcess{
  function process($infoarray);
  function processfinished($displaycode);
  function errorreached($errormessage);
}

 ?>