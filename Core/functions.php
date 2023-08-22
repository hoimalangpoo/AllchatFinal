<?php
function check($value){
   echo "<pre>";
   var_dump($value);
   echo "</pre>";

   die();    
 }

 function auth($condition){

  try {
    if (! $condition) {

      require "views/auth.view.php";
    }
  } catch (\Throwable $th) {
    $th;
  }
    
 }

 function base_path($path){
    return BASE_PATH . $path;
 }

 function view($path){
    require BASE_PATH('views/' . $path);
 }