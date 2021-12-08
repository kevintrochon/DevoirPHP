<?php

function dateDuJour():String {
  $date = getdate();
  if ($date['mday'] < 10) {
    $date = $date['year'].'-'.$date['mon'].'-0'.$date['mday'];
  }else {
    $date = $date['year'].'-'.$date['mon'].'-'.$date['mday'];
  }
  return $date;
}

function download($filePath){
  
  header('Content-Type: application/octet-stream');
  
  header('Content-Transfert-Encoding: Binary');

  header('Content-Length: ' . filesize($filePath));
  
  header('Content-disposition: attachment; filename="'. basename($filePath) .'"');
  
  echo readfile($filePath);
}