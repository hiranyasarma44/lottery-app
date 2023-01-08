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

if(!function_exists('dump')){
  function dump($data){
    echo '<pre>';
    var_dump($data);
    exit();
  }
}