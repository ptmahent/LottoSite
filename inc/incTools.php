<?php

class gTools {
  
  static public function getIsset($key)
  {
    if (!isset($key) OR empty($key) OR !is_string($key))
      return false;
    return isset($_POST[$key]) ? true : (isset($_GET[$key]) ? true : false);
  }
  
  static public function isEmpty($field)
  {
    return $field === '' OR $field === NULL;
  }
  
}



?>