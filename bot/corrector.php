#!/usr/bin/php
<?php
//credentials to fill
$host = "";
$username = "";
$password = "";
$dbname  = ""; 
$tablename = "";

function correct($host,$username,$password,$dbname,$tablename,$fieldtocorrect,$valuetocorrect,$datewherecorrect,$countrycodewherecorrect,$columnpattern,$valuepattern){
 $link = mysqli_connect($host,$username,$password,$dbname);
 if (!$link->set_charset("utf8")) {
  printf("Error loading character set utf8: %s\n", $con->error);
 }
 if (!$link) {
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;
 }
 $sql= "UPDATE `".$tablename."` SET ".$fieldtocorrect."='".$valuetocorrect."' WHERE (DATE(`Last_Update`)='".$datewherecorrect."' AND Country_Code='".$countrycodewherecorrect."' AND ".$columnpattern."='".$valuepattern."');"; 
 $result = mysqli_query($link,$sql)or die( mysqli_error($link) );
  echo "\nCorrection of : ".$fieldtocorrect." with value : ".$valuetocorrect." , Date : ".$datewherecorrect." , CC: ".$countrycodewherecorrect." , pattern : ".$columnpattern." => ".$valuepattern."\n";   
 @mysqli_free_result($result);
}
//correct($host,$username,$password,$dbname,$tablename,$fieldtocorrect,$valuetocorrect,$datewherecorrect,$countrycodewherecorrect,$columnpattern,$valuepattern)
correct($host,$username,$password,$dbname,$tablename,"Deaths","27952","2020-05-18","FR","Combined_Key","France");
?>
