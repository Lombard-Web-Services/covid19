<?php
$host = "databasehost";
$username = "username";
$password = "password";
$dbname  = "dbname"; 
$tablename = "tablename";
// table name for standard deviation
$tablenameSD = "SD";
// configure the update hour of the CSSE DB import
$updatehour = 8;
// limit the result for a row request without grouping
$rowresultlimit = 10000;
ini_set("display_errors",1);
// setting up commandline args
$f = getopt(null, ["f:"]);
$folderwheresaved = $f["f"];
// the date today is
$date2= date('Y-m-d');
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

$htoday =  date("H");
if($htoday <$updatehour){
  $today = date("Y-m-d",strtotime(date("Y-m-d")." -2 day"));
 }else{
  $today = date("Y-m-d",strtotime(date("Y-m-d")." -1 day"));
}
$yesterday = date("Y-m-d",strtotime($today." -1 day"));
$d = $today;
$before = date("Y-m-d",strtotime($today." -32 day"));
$interval = dateDiff($before, $today);
$daterequest = "(DATE(`Last_Update`) BETWEEN '".$before."' AND '".$today."')";

//IDMC	FIPS	Admin2	Province_State	Country_Region	Country_Code	Country_CodeA3	Last_Update	Lat	Lon	Confirmed	Deaths	Recovered	Active	Combined_Key
$query = "SELECT * FROM `MC` WHERE ".$daterequest." ORDER BY Last_Update;\n";
//echo "debug : \n".$query."\n";
$result=mysqli_query($link,$query)or die( mysqli_error($link) );
$props = array();
$propspush=array();
// limit the number of results if the request is too big
$rowcount = mysqli_num_rows($result);
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
mysqli_free_result($result);  

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

}// fin foreach
return $groups;
}
// standard deviation and variation coefficient algorithm
// from a multidimensionnal array
// see regression tree algorithm for this kind of standard deviation.
function calculETCO($untableau, $unmontant){
$leffectiftotal = count($untableau);
$lamoyennedeleffectif = 0;
foreach ($untableau as $item) {
    $lamoyennedeleffectif += $item[$unmontant];
}
if($lamoyennedeleffectif != 0 && $lamoyennedeleffectif == is_numeric($lamoyennedeleffectif)&& $leffectiftotal !=0 && $leffectiftotal ==is_numeric($leffectiftotal))
{
$lamoyennedeleffectif2 = round(($lamoyennedeleffectif/$leffectiftotal),7);
}else{
$lamoyennedeleffectif2 = 0;
}
$lemeans = 0;
foreach ($untableau as $item) {
    $lemeans += pow(($item[$unmontant]-$lamoyennedeleffectif2),2);
}
if($lemeans == is_numeric($lemeans) && $leffectiftotal == is_numeric($leffectiftotal)){
$lecarttype =sqrt($lemeans/$leffectiftotal);
}else{
$lecarttype = 0;
}
if($lecarttype == is_numeric($lecarttype) && $lecarttype != 0 && $lamoyennedeleffectif2 == is_numeric($lamoyennedeleffectif2) && $lamoyennedeleffectif2 != 0){
$lecoeff = (($lecarttype / $lamoyennedeleffectif2) * 100);
}else {
$lecoeff = 0;
}
$ETCO =array(round($lecarttype,3),round($lecoeff,2));
return $ETCO;
}

$columnarray = array("IDMC","FIPS","Admin2","Province_State","Country_Region","Country_Code","Country_CodeA3","Last_Update","Lat","Lon","Confirmed","Deaths","Recovered","Active","Combined_Key","Ndate","NCCdate");
 $props2 = getgroup($props,"NCCdate");
 $nbkeys = count($props2);
array_unshift($props2,array("days"=>$interval,"count"=>$nbkeys,"baserowcount"=>$rowcount));

//retreive all the values without cumulative sums
function retreivevalbydays($multidimensionnalarray,$countrycodekey,$columnkeyConfirmed,$columnkeyDeaths,$columnkeyRecovered,$columnkeyActive){
 global $today;
 $allConfirmedbydays = array();
 $allDeathsbydays = array();
 $allRecoveredbydays = array();
 $allActivebydays = array();
 $NdatearrConfirmed = array();
 $NdatearrDeaths = array();
 $NdatearrRecovered = array();
 $NdatearrActive = array();
 
 // find the cumulative results
 foreach($multidimensionnalarray as $key3 => $val3){
  if(isset($val3["Country_Code"]) && $val3["Country_Code"] == $countrycodekey && $val3["Ndate"] == $today){
	 $totalConfirmed = $val3["Confirmed"];
	 $totalDeaths = $val3["Deaths"];
	 $totalRecovered = $val3["Recovered"];
	 $totalActive = $val3["Active"];
  }
 }
 // minus day befores ...
 foreach($multidimensionnalarray as $key4 => $val4){
  if(isset($val4["Country_Code"]) && $val4["Country_Code"] == $countrycodekey){
	$NdatearrConfirmed[$val4["Ndate"]] = $val4[$columnkeyConfirmed];
	$NdatearrDeaths[$val4["Ndate"]] = $val4[$columnkeyDeaths];
	$NdatearrRecovered[$val4["Ndate"]] = $val4[$columnkeyRecovered];
	$NdatearrActive[$val4["Ndate"]] = $val4[$columnkeyActive];
  }
 }
 $i = 0;
 foreach($NdatearrDeaths as $key => $val){
	$i++;
	$Deathsdate = date("Y-m-d",strtotime($key." -1 day"));
	if(isset($NdatearrDeaths[$Deathsdate])){
	$computerDeaths= $val - $NdatearrDeaths[$Deathsdate];
 if($computerDeaths>0){
	$allDeathsbydays[] = array("Deathsbydays"=>$computerDeaths);
 }
	}
 }
  $j = 0;
 foreach($NdatearrConfirmed as $key => $val){
	$j++;
	$Confirmeddate = date("Y-m-d",strtotime($key." -1 day"));
	if(isset($NdatearrConfirmed[$Confirmeddate])){
	$computerConfirmed= $val - $NdatearrConfirmed[$Confirmeddate];
	if($computerConfirmed>0){
 $allConfirmedbydays[] = array("Confirmedbydays"=>$computerConfirmed);
 }
	}
 }
  $k = 0;
 foreach($NdatearrRecovered as $key => $val){
	$k++;
	$Recovereddate = date("Y-m-d",strtotime($key." -1 day"));
	if(isset($NdatearrRecovered[$Recovereddate])){
	$computerRecovered= $val - $NdatearrRecovered[$Recovereddate];
 if($computerRecovered>0){
	$allRecoveredbydays[] = array("Recoveredbydays"=>$computerRecovered);
	}
 }
 }
  $l = 0;
 foreach($NdatearrActive as $key => $val){
	$l++;
	$Activedate = date("Y-m-d",strtotime($key." -1 day"));
	if(isset($NdatearrActive[$Activedate])){
	$computerActive= $val - $NdatearrActive[$Activedate];
 if($computerDeaths>0){
 $allActivebydays[] = array("Activebydays"=>$computerActive);
	}
 }
 }
$theresults = array("totalConfirmed"=>$totalConfirmed,"totalDeaths"=>$totalDeaths,"totalRecovered"=>$totalRecovered,"totalActive"=>$totalActive,"allConfirmedbydays"=>$allConfirmedbydays,"allDeathsbydays"=>$allDeathsbydays,"allRecoveredbydays"=>$allRecoveredbydays,"allActivebydays"=>$allActivebydays); 
 return $theresults;
}

// extract unique country code alpha2 from an array
function uniqueCC($thearray){
 foreach ($thearray as $key => $val4){
  if(isset($val4["Country_Code"])){
   $bycc[] = $val4["Country_Code"];
  }              
 }
$toreturn = array_unique($bycc);
return $toreturn;
}
// get the table segmented for the latest days
function sliced($anarray,$entries){
$count_until_end = count($anarray) - $entries;
$sliced = array_slice($anarray,$count_until_end);
return $sliced;
}
$these_countries = uniqueCC($props2);

function flattenarray($onearray,$thekey){
$arraytoreturn = array();
 foreach($onearray as $key => $val){
  $arraytoreturn[] = $val[$thekey];
 }
$flattenedarray = implode(",",$arraytoreturn);
return $flattenedarray;
}
foreach ($these_countries as $key => $val){
 if(isset($val) && $val != ""){
 $letableau = retreivevalbydays($props2,$val,"Confirmed","Deaths","Recovered","Active");
 $totalActive = $letableau["totalActive"];
 $totalConfirmed = $letableau["totalConfirmed"];
 $totalRecovered = $letableau["totalRecovered"];
 $totalDeaths = $letableau["totalDeaths"];
 $TableConfirmed = flattenarray($letableau["allConfirmedbydays"],"Confirmedbydays");
 $TableDeaths  = flattenarray($letableau["allDeathsbydays"],"Deathsbydays");
 $TableRecovered = flattenarray($letableau["allRecoveredbydays"],"Recoveredbydays");
 $TableActive = flattenarray($letableau["allActivebydays"],"Activebydays");
 //Confirmed","Deaths","Recovered","Active"
 $ETConfirmed = calculETCO($letableau["allConfirmedbydays"],"Confirmedbydays");
 $ETDeaths = calculETCO($letableau["allDeathsbydays"],"Deathsbydays");
 $ETRecovered = calculETCO($letableau["allRecoveredbydays"],"Recoveredbydays");
 $ETActive = calculETCO($letableau["allActivebydays"],"Activebydays");
 $ETConfirmedseven = calculETCO(sliced($letableau["allConfirmedbydays"],7),"Confirmedbydays");
 $ETDeathsseven = calculETCO(sliced($letableau["allDeathsbydays"],7),"Deathsbydays");
 $ETRecoveredseven = calculETCO(sliced($letableau["allRecoveredbydays"],7),"Recoveredbydays");
 $ETActiveseven = calculETCO(sliced($letableau["allActivebydays"],7),"Activebydays");
 $ETConfirmedfourteen = calculETCO(sliced($letableau["allConfirmedbydays"],14),"Confirmedbydays");
 $ETDeathsfourteen = calculETCO(sliced($letableau["allDeathsbydays"],14),"Deathsbydays");
 $ETRecoveredfourteen = calculETCO(sliced($letableau["allRecoveredbydays"],14),"Recoveredbydays");
 $ETActivefourteen = calculETCO(sliced($letableau["allActivebydays"],14),"Activebydays");

$sql = "INSERT INTO ".$tablenameSD." (
FromDate,
ToDate,
Country_Code,
Confirmed,
Deaths,
Recovered,
Active,
SDConfirmed,
SDDeaths,
SDRecovered,
SDActive,
SDConfirmed_seven,
SDDeaths_seven,
SDRecovered_seven,
SDActive_seven,
SDConfirmed_fourteen,
SDDeaths_fourteen,
SDRecovered_fourteen,
SDActive_fourteen,
TableConfirmed,
TableDeaths,
TableRecovered,
TableActive
) values ('".clean($before)."', '".clean($today)."', '".clean($val)."', '".clean($totalConfirmed)."', '".clean($totalDeaths)."', '".clean($totalRecovered)."', '".clean($totalActive)."', '".clean(implode(",",$ETConfirmed))."', '".clean(implode(",",$ETDeaths))."', '".clean(implode(",",$ETRecovered))."', '".clean(implode(",",$ETActive))."', '".clean(implode(",",$ETConfirmedseven))."', '".clean(implode(",",$ETDeathsseven))."', '".clean(implode(",",$ETRecoveredseven))."', '".clean(implode(",",$ETActiveseven))."', '".clean(implode(",",$ETConfirmedfourteen))."', '".clean(implode(",",$ETDeathsfourteen))."', '".clean(implode(",",$ETRecoveredfourteen))."', '".clean(implode(",",$ETActivefourteen))."', '".clean($TableConfirmed)."', '".clean($TableDeaths)."', '".clean($TableRecovered)."', '".clean($TableActive)."')";
$result = mysqli_query($link,$sql)or die( mysqli_error($link) );  
}
}
@mysqli_free_result($result);
$sql="SELECT * FROM `".$tablenameSD."`";
$rs =   mysqli_query($link,$sql) or die(mysqli_error($link));
$outputSD_Variation_Table = realpath(dirname($_SERVER['PHP_SELF']))."/".$folderwheresaved."/SD_Variation_Table_covid_19_daily_reports_FULL.csv"; 
$headersSD_Variation_Table = "IDSD,FromDate,ToDate,Country_Code,Confirmed,Deaths,Recovered,Active,SDConfirmed,SDDeaths,SDRecovered,SDActive,SDConfirmed_seven,SDDeaths_seven,SDRecovered_seven,SDActive_seven,SDConfirmed_fourteen,SDDeaths_fourteen,SDRecovered_fourteen,SDActive_fourteen,TableConfirmed,TableDeaths,TableRecovered,TableActive";
$fp = fopen($outputSD_Variation_Table, 'w');
// setup csv headers for full SD_Variation_Table John Hopkins daily updates database 
fputcsv($fp,explode(',', $headersSD_Variation_Table));
while($row = mysqli_fetch_array($rs, MYSQLI_ASSOC))
{
fputcsv($fp, $row);  
}
fclose($fp);
@mysqli_free_result($rs);
?>
