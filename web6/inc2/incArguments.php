<?php

  class Arguments {
    
    function arguments() {
      $arguments = array();
        $matches = array();
      foreach ($_SERVER['argv'] AS $argument) {
        if (preg_match('#^-{1,2}([a-zA-Z0-9]*)=?(.*)$#', $argument, $matches)) {
          $key = $matches[1];
          switch ($matches[2]) {
            case '':
            case 'true':
              $argument = true;
              break;
            case 'false':
              $argument = false;
              break;
            default:
              $argument = $matches[2];
          }
          
          if (preg_match("/^-([a-zA-Z0-9]+)/", $matches[0], $match)) {
            $string = $match[1];
            for ($i = 0; strlen($string) > $i; $i++) {
              $_ARG[$string[$i]] = true;
            }
          } else {
            $arguments[$key] = $argument;
          }
          
         } else {
           $arguments['standard'][] = $argument;
         }
      }
      
      return $arguments;
    }
    
  }


?>