<?php

function require_all($path, $fileExt = 'php', $includeSelf = true){
  $routeFiles = glob($path . '/*'.$fileExt);
  foreach ($routeFiles as $file) {
      // prevents including file itself
      if($includeSelf){
        require($file);
      }else{
        if ($file != __FILE__) {
          require($file);
        }        
      }
  }
}