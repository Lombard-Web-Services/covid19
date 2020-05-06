#!/usr/bin/php
<?php
$host = "databasehost";
$username = "username";
$password = "password";
$dbname  = "dbname"; 
$tablename = "tablename";
// configure the update hour of the CSSE DB import
$updatehour = 8;
// limit the result for a row request without grouping
$rowresultlimit = 9999999;

ini_set("display_errors",1);
ini_set("memory_limit", "-1");
set_time_limit(0);

$f = getopt(null, ["f:"]);
$n = getopt(null, ["n:"]);
$g = getopt(null, ["g:"]);
if (!isset($argv[1])) {
echo "Could not get value of command line option\nf - folder where the datas are saved from the relative path of this script (without slash on start and in the end)\ng - For group request\nn - options for checking numbers of days between today\n\nExample for 15 days: \nphp ".basename(__FILE__)." --f=public_html/data --n=15 --g=NCCdate\n";
exit;
}
$folderwheresaved = $f["f"];
$numberofdays = $n["n"];
$groupselected = $g["g"];
// the date today is
$htoday =  date("H");
if($htoday < $updatehour){
	$today = date("Y-m-d",strtotime(date("Y-m-d")." -2 day"));
}else{
 $today = date("Y-m-d",strtotime(date("Y-m-d")." -1 day"));
}
$before = date("Y-m-d",strtotime($today." -".$numberofdays." day"));
$daterequest = "(DATE(`Last_Update`) BETWEEN '".$before."' AND '".$today."')";
echo "querying date from ".$today." to ".$before."\n";
// set up error management
$errflag = false;
$errmsg_arr = array();

//Connection mysqli
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
//be secured against cross site scripting attacks
function secu_txt($text) {
 return htmlentities(strip_tags($text), ENT_QUOTES, 'UTF-8');
}
//be secured against sql injections attacks
function clean($variable) {
global $link;
$variable2 = utf8_decode($variable);
if (get_magic_quotes_gpc())
	{
	$variable2 = stripslashes($variable2);
	}
$variable2 = mysqli_real_escape_string($link,$variable2);
$variable2 = utf8_encode($variable2);
return $variable2;	
}
function validateDate($date, $format = 'Y-m-d H:i:s')
{
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}

// calculate the number of days between the 2 dates
function dateDiff($date1, $date2){
	  $date1_ts = strtotime($date1);
	  $date2_ts = strtotime($date2);
	  $diff = $date2_ts - $date1_ts;
	  return round($diff / 86400);
}
$interval = dateDiff($before, $today);

//IDMC	FIPS	Admin2	Province_State	Country_Region	Country_Code	Country_CodeA3	Last_Update	Lat	Lon	Confirmed	Deaths	Recovered	Active	Combined_Key
$query = "SELECT * FROM `".$tablename."` WHERE ".$daterequest." ORDER BY Last_Update;\n";
//echo "debug : \n".$query."\n";
$result=mysqli_query($link,$query)or die( mysqli_error($link) );
$props = array();
$propspush=array();
// limit the number of results if the request is too big
$rowcount = mysqli_num_rows($result);
if(!isset($g) && $rowcount > $rowresultlimit){
echo json_encode(array("error"=>"request is too big"),JSON_PRETTY_PRINT);
exit;
}
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
{ 
 if(!isset($row["Country_Code"]) || $row["Country_Code"] == ""){
 // Debugging undefined row 
 $NCCdate = date("Y-m-d",strtotime($row["Last_Update"])).".undefined";
 $propspush =array("IDMC"=>$row["IDMC"],"Ndate"=>date("Y-m-d",strtotime($row["Last_Update"])),"NCCdate"=>$NCCdate, "FIPS"=>$row["FIPS"], "Admin2"=>$row["Admin2"], "Province_State"=>$row["Province_State"], "Country_Region"=>$row["Country_Region"], "Country_Code"=>"undefined", "Country_CodeA3"=>"undefined", "Last_Update"=>$row["Last_Update"], "Lat"=>$row["Lat"], "Lon"=>$row["Lon"], "Confirmed"=>$row["Confirmed"], "Deaths"=>$row["Deaths"], "Recovered"=>$row["Recovered"], "Active"=>$row["Active"], "Combined_Key"=>$row["Combined_Key"]);
  }else{
 $NCCdate = date("Y-m-d",strtotime($row["Last_Update"])).".".$row["Country_Code"];
 $propspush =array("IDMC"=>$row["IDMC"],"Ndate"=>date("Y-m-d",strtotime($row["Last_Update"])),"NCCdate"=>$NCCdate, "FIPS"=>$row["FIPS"], "Admin2"=>$row["Admin2"], "Province_State"=>$row["Province_State"], "Country_Region"=>$row["Country_Region"], "Country_Code"=>trim($row["Country_Code"]), "Country_CodeA3"=>$row["Country_CodeA3"], "Last_Update"=>$row["Last_Update"], "Lat"=>$row["Lat"], "Lon"=>$row["Lon"], "Confirmed"=>$row["Confirmed"], "Deaths"=>$row["Deaths"], "Recovered"=>$row["Recovered"], "Active"=>$row["Active"], "Combined_Key"=>$row["Combined_Key"]);
  }
	array_push($props,$propspush);  
}
function getgroup($data,$columnname) {
$groups = array();
$key = 0;
foreach ($data as $item) {
 $key = $item[$columnname];
 if (!array_key_exists($key, $groups)) {
  $groups[$key] = array(
   "IDMC" => $item["IDMC"],
   "Ndate" => $item["Ndate"],
   "FIPS" => $item["FIPS"],
   "Admin2" => $item["Admin2"],
   "Province_State" => $item["Province_State"],
   "Country_Region" => $item["Country_Region"],
   "Country_Code" => $item["Country_Code"],
   "Country_CodeA3" => $item["Country_CodeA3"],
   "Last_Update" => $item["Last_Update"],
   "Lat" => $item["Lat"],
   "Lon" => $item["Lon"],
   "Confirmed" => $item["Confirmed"],
   "Deaths" => $item["Deaths"],
   "Recovered" => $item["Recovered"],
   "Active" => $item["Active"],
   "Combined_Key" => $item["Combined_Key"] ,           
   );
 } else {
$groups[$key]["IDMC"] = $groups[$key]["IDMC"];
$groups[$key]["Ndate"] = $groups[$key]["Ndate"];
 $groups[$key]["FIPS"] = $groups[$key]["FIPS"];
 $groups[$key]["Admin2"] = $groups[$key]["Admin2"];
 $groups[$key]["Province_State"] = $groups[$key]["Province_State"];
 $groups[$key]["Country_Region"] = $groups[$key]["Country_Region"];
 $groups[$key]["Country_Code"] = $groups[$key]["Country_Code"];
 $groups[$key]["Country_CodeA3"] = $groups[$key]["Country_CodeA3"];
 $groups[$key]["Last_Update"] = $groups[$key]["Last_Update"];
 $groups[$key]["Lat"] = $groups[$key]["Lat"];
 $groups[$key]["Lon"] = $groups[$key]["Lon"];
 $groups[$key]["Confirmed"] = $groups[$key]["Confirmed"] + $item["Confirmed"];
 $groups[$key]["Deaths"] = $groups[$key]["Deaths"] + $item["Deaths"];
 $groups[$key]["Recovered"] = $groups[$key]["Recovered"] + $item["Recovered"];
 $groups[$key]["Active"] = $groups[$key]["Active"] + $item["Active"];
 $groups[$key]["Combined_Key"] = $groups[$key]["Combined_Key"];
 }
$key++;
}
return $groups;
}

$tmp = realpath(dirname($_SERVER['PHP_SELF']))."/".$folderwheresaved."/map_".$today.".json";

$columnarray = array("IDMC","FIPS","Admin2","Province_State","Country_Region","Country_Code","Country_CodeA3","Last_Update","Lat","Lon","Confirmed","Deaths","Recovered","Active","Combined_Key","Ndate","NCCdate");
if(isset($groupselected) && in_array($groupselected,$columnarray)){
 $props2 = getgroup($props,$groupselected);
 $nbkeys = count($props2);
 array_unshift($props2,array("days"=>$interval,"count"=>$nbkeys,"baserowcount"=>$rowcount));
$thecontent = json_encode($props2);
}else{
$nbkeys = count($props);
array_unshift($props,array("days"=>$interval,"count"=>$nbkeys,"baserowcount"=>$rowcount));
$thecontent = json_encode($props);
}
 $out = fopen($tmp, "w");
 fwrite($out, $thecontent);
 fclose($out);
mysqli_free_result($result);   
?>

