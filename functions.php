<?php

include_once 'connection/config.php';

session_start();

function test_input($text){ 
 $text = trim($text);
  $text = strip_tags($text);
 $text = stripslashes($text);
  return $text;
}

?>