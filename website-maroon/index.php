<?php
$host = "";
$username = "";
$password = "";
$dbname  = ""; 
$tablename = "";
$updatehour = 8;
// countries list
require_once("cc.php");
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
function expl($data){
 $toexplode = explode(",",$data);
 return $toexplode;
}
$htoday =  date("H");
if($htoday <$updatehour){
  $today = date("Y-m-d",strtotime(date("Y-m-d")." -2 day"));
 }else{
  $today = date("Y-m-d",strtotime(date("Y-m-d")." -1 day"));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=900">
	<link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
	<link rel="manifest" href="images/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- favicon -->
 <meta name="description" content="COVID 19 Map & Numbers">
 <meta name="author" content="COVID-19 LOMBARD WEB SERVICES">
 <meta name="keywords" content="Look backward, to better see tomorrow..">
	<meta name="robots" content="index,follow">
	<meta name="copyright" content="Lombard Web Services">   
	<meta property="og:title" content="COVID19 Standard Deviation, Variations, and maps Lombard Web Services" />
	<meta property="og:site_name" content="covid19.lombard-web-services.com"/>
	<meta property="og:url" content="https://covid19.lombard-web-services.com/" />
	<meta property="og:description" content="Covid 19 Stats" />
	<meta property="og:locale" content="fr_FR" />
	<meta property="article:author" content="https://www.linkedin.com/in/thibautlombard/" />
	<meta property="og:image" content="https://covid19.lombard-web-services.com/images/og.png" />
	<!-- SEO Twitter -->
	<meta name="twitter:card" content="summary_large_image"/>
	<meta name="twitter:description" content="COVID 19 Standard Deviation, Variations, and Map data, stats and infographics"/>
	<meta name="twitter:title" content="COVID 19 Standard Deviation, Variations, and Map , the dashboard with useful stats"/>
	<meta name="twitter:domain" content="https://covid19.lombard-web-services.com"/>
	<meta name="twitter:image" content="https://covid19.lombard-web-services.com/images/ogtw.png"/>

 <title>COVID19 Standard Deviation, Variations, and Map</title>
 <link href="css/flags32.css" media="screen" rel="stylesheet" type="text/css"/>
 <link href="css/tlmaps.css" media="screen" rel="stylesheet" type="text/css"/>
 <!-- Custom CSS -->
 <link href="css/style.css" rel="stylesheet">
 <!-- Custom Fonts -->
 <link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
 <script src="js/jquery.js"></script>
 <script type="text/javascript" src="js/jquery-ui.min.js"></script>
 <script src="js/jquery.dataTables.js"></script>
 <script type="text/javascript" src="js/jquery.tlmap.js"></script>
 <script type="text/javascript" src="maps/jquery.tlmap.world.js" charset="utf-8"></script>
 <script type="text/javascript" src="js/choropleth.js" charset="utf-8"></script>
 <script src="js/dvscharts.js"></script>
 <script src="js/sticky-table-headers.js"></script>
</head>
<body>
 <div class="navbar-custom">
  <ul>
    <li class="nleft" style="float:left";>
     <img src="images/logo.png" width="45%" />
    </li>
    <li class="lnkdn-share-button">
         <a><svg viewBox="0 50 512 512" >
        <path fill="#ffffff" d="M150.65,100.682c0,27.992-22.508,50.683-50.273,50.683c-27.765,0-50.273-22.691-50.273-50.683
        C50.104,72.691,72.612,50,100.377,50C128.143,50,150.65,72.691,150.65,100.682z M143.294,187.333H58.277V462h85.017V187.333z
        M279.195,187.333h-81.541V462h81.541c0,0,0-101.877,0-144.181c0-38.624,17.779-61.615,51.807-61.615
        c31.268,0,46.289,22.071,46.289,61.615c0,39.545,0,144.181,0,144.181h84.605c0,0,0-100.344,0-173.915
        s-41.689-109.131-99.934-109.131s-82.768,45.369-82.768,45.369V187.333z"/>
      </svg>
         <span>Share</span></a>
    </li>
    <li class="fb-share-button">
         <a data-js="twitter-share"><svg viewBox="0 0 12 12" preserveAspectRatio="xMidYMid meet">
             <path class="svg-icon-path" d="M9.1,0.1V2H8C7.6,2,7.3,2.1,7.1,2.3C7,2.4,6.9,2.7,6.9,3v1.4H9L8.8,6.5H6.9V12H4.7V6.5H2.9V4.4h1.8V2.8 c0-0.9,0.3-1.6,0.7-2.1C6,0.2,6.6,0,7.5,0C8.2,0,8.7,0,9.1,0.1z"></path>
         </svg>
         <span>Share</span></a>
    </li>
    <li class="tw-share-button">
         <a><svg viewBox="328 355 335 276" xmlns="http://www.w3.org/2000/svg">
             <path d="M 630, 425A 195, 195 0 0 1 331, 600A 142, 142 0 0 0 428, 570A  70,  70 0 0 1 370, 523A  70,  70 0 0 0 401, 521A  70,  70 0 0 1 344, 455A  70,  70 0 0 0 372, 460A  70,  70 0 0 1 354, 370A 195, 195 0 0 0 495, 442A  67,  67 0 0 1 611, 380A 117, 117 0 0 0 654, 363A  65,  65 0 0 1 623, 401A 117, 117 0 0 0 662, 390A  65,  65 0 0 1 630, 425Z" style="fill:#ffffff;"/>
           </svg>
         <span>Share</span></a>
    </li>
    <li class="">
     <a href="connex">Data</a> 
    </li>
    <li>
     <a href="maths">Machine Learning</a>
    </li>
    <li class="active">
     <a href="index">Home</a>
    </li>
   </ul>
</div>
    <!-- Page Header -->
   <div class="mapcontainer">
    <div id="tlmap">
 
    </div><!-- end of tlmap-->
  <!-- parameters legend start -->
     <div class="project-legend middle density">
      <a id="atoggletrois">&#x25B2;</a>  
      <ul>
       <li class="min">
       Parameters
       </li>
       <li class="graph leg litrois" style="border-radius: 0; border:none">
        <div class="colors">
         <label class="containerradio">Confirmed&nbsp;
           <input type="radio" name="radio" value="Confirmed">
           <span class="checkmark"></span>
         </label>
         <label class="containerradio">Deaths&nbsp;
           <input type="radio" checked="checked" name="radio" value="Deaths">
           <span class="checkmark"></span>
         </label>
         <label class="containerradio">Recovered&nbsp;
           <input type="radio" name="radio" value="Recovered">
           <span class="checkmark"></span>
         </label>
         <label class="containerradio">Active&nbsp;
           <input type="radio" name="radio" value="Active">
           <span class="checkmark"></span>
         </label>
        </div>
       </li>
      </ul>
     </div>
    <!-- parameters legend stop-->
    <!-- Arithmetic progression legend start-->
     <div class="project-legend left density">
      <a id="atoggleun">&#x25B2;</a>  
      <ul>
       <li class="min">
       Progression &nbsp;[<a id="changeset" style="color:#666;text-decoration:none;cursor:pointer;text-transform:none;">polynomial(log)</a>&nbsp;/&nbsp;<a id="changesetlin" style="color:#666;text-decoration:none;cursor:pointer;text-transform:none;">linear</a>]
       </li>
       <li class="graph leg liun" style="border-radius: 0; border:none">
        <div class="colors">
         <div class="quartile" id="legendcolor0"></div>
         <div class="quartile" id="legendcolor1"></div>
         <div class="quartile" id="legendcolor2"></div>
         <div class="quartile" id="legendcolor3"></div>
         <div class="quartile" id="legendcolor4"></div>
        </div>
        <div class="colors" id="legendval" style="font-weight:normal; text-align: center">
         <div class="quartile" style="padding-top: 5px" id="legendvalue0">[0-20%]</div>
         <div class="quartile" style="padding-top: 5px" id="legendvalue1">[20%-40%]</div>
         <div class="quartile" style="padding-top: 5px" id="legendvalue2">[40%-60%]</div>
         <div class="quartile" style="padding-top: 5px" id="legendvalue3">[60%-80%]</div>
         <div class="quartile" style="padding-top: 5px" id="legendvalue4">[80%-100%]</div>
        </div>
       </li>
      </ul>
     </div>
     <!-- arithmetic progression legend end -->
     <!-- start timeline slider -->
     <div class="right project-legend density">  
      <a id="atoggledeux">&#x25B2;</a>  
      <ul>
       <li class="min">
       <a id="nbdays" style="color:#666;text-decoration:none;"></a> days ago</a>
       </li>
       <li class="graph leg lideux" style="border-radius: 0; border:none">
        <div class="colors">
         <div class="lideux" style="width:100%;position:relative;display:block;vertical-align:middle;padding-top:1em;">  
          <input  type="range" min="0" max="7" value="0" class="slider slidecontainer" id="myRange" list="sliderticks" />
           <datalist id="sliderticks" class="sliderticks" style="z-index:0;">
             <p>0</p>
             <p>1</p>
             <p>2</p>
             <p>3</p>
             <p>4</p>
             <p>5</p>
             <p>6</p>
             <p>7</p>
           </datalist>          
         </div>
        </div>
       </li>
      </ul>
     </div>
     <!-- end of slider -->
     <div class="copyright" id="srcdata"></div>
   </div><!-- end of mapcontainer -->
    </header>

<?php
echo "    <div class=\"shareall\">
</div>
";
     // generate rows & get date
     if(isset($_GET["d"]) && $_GET["d"]  ==  validateDate($_GET["d"], "d-m-Y")){
     $d =  date('Y-m-d', strtotime($_GET["d"]));
     $query = "SELECT * FROM `".$tablename."` WHERE DATE(`ToDate`)='".$d."' AND `Country_Code`!='undefined'  ORDER BY ABS(`Deaths`) DESC";
     }else{
     $query = "SELECT * FROM `".$tablename."` WHERE `ToDate`=DATE('".$today."') AND `Country_Code`!='undefined'  ORDER BY ABS(`Deaths`) DESC";
     }
     $result=mysqli_query($link,$query)or die( mysqli_error($link) );
     $i=0;
     $Deathsarray = array();
     $Confirmedarray = array();
     $Activearray = array();
     $Recoveredarray = array();
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
					{
     $sdDeaths = expl($row["SDDeaths"]);
     $sdDeaths_seven = expl($row["SDDeaths_seven"]);
     $sdDeaths_fourteen = expl($row["SDDeaths_fourteen"]);

     $sdActive = expl($row["SDActive"]);
     $sdActive_seven = expl($row["SDActive_seven"]);
     $sdActive_fourteen = expl($row["SDActive_fourteen"]);

     $sdRecovered = expl($row["SDRecovered"]);
     $sdRecovered_seven = expl($row["SDRecovered_seven"]);
     $sdRecovered_fourteen = expl($row["SDRecovered_fourteen"]);

     $sdConfirmed = expl($row["SDConfirmed"]);
     $sdConfirmed_seven = expl($row["SDConfirmed_seven"]);
     $sdConfirmed_fourteen = expl($row["SDConfirmed_fourteen"]);
     
     if(strlen($CC_alpha2[$row["Country_Code"]])>20){
      $cntry = substr($CC_alpha2[$row["Country_Code"]],0,20)."..";
     }else{
      $cntry = $CC_alpha2[$row["Country_Code"]];
     }
     $tslDeaths= str_replace(",",", ",$row["TableDeaths"]);
     $tslActive= str_replace(",",", ",$row["TableActive"]);
     $tslRecovered= str_replace(",",", ",$row["TableRecovered"]);
     $tslConfirmed= str_replace(",",", ",$row["TableConfirmed"]);
     $posDeaths = strpos($tslDeaths, ",");
     if(!isset($tslDeaths) || $tslDeaths ==""){
      $TableDeaths = "0, 0";
     }elseif(!$posDeaths){
      $TableDeaths = "0, ".$tslDeaths;
     }else{
      $TableDeaths = $tslDeaths;
     }
     $posActive = strpos($tslActive, ",");
     if(!isset($tslActive) || $tslActive ==""){
      $TableActive = "0, 0";
     }elseif(!$posActive){
      $TableActive = "0, ".$tslActive;
     }else{
      $TableActive = $tslActive;
     }
     $posRecovered = strpos($tslRecovered, ",");
     if(!isset($tslRecovered) || $tslRecovered ==""){
      $TableRecovered = "0, 0";
     }elseif(!$posRecovered){
      $TableRecovered = "0, ".$tslRecovered;
     }else{
      $TableRecovered = $tslRecovered;
     }
     $posConfirmed = strpos($tslConfirmed, ",");
     if(!isset($tslConfirmed) || $tslConfirmed ==""){
      $TableConfirmed = "0, 0";
     }elseif(!$posConfirmed){
      $TableConfirmed = "0, ".$tslConfirmed;
     }else{
      $TableConfirmed = $tslConfirmed;
     }
     $Deathsarray[] = array("Flag"=>"<a class=\"f32\"><i class=\"flag ".strtolower($row["Country_Code"])."\"></i></a>",
      "Country"=>$cntry,"Deaths" =>$row["Deaths"],"SD_monthDeaths"=>$sdDeaths[0],"pctmonthDeaths"=>$sdDeaths[1],"SD_14dDeaths"=>$sdDeaths_fourteen[0],"pct_14dDeaths"=>$sdDeaths_fourteen[1],"SD_7dDeaths"=>$sdDeaths_seven[0],"pct_7dDeaths"=>$sdDeaths_seven[1],"Trends_monthsDeaths"=>$TableDeaths);

     $Confirmedarray[] = array("Flag"=>"<a class=\"f32\"><i class=\"flag ".strtolower($row["Country_Code"])."\"></i></a>",
      "Country"=>$cntry,"Confirmed" =>$row["Confirmed"],"SD_monthConfirmed"=>$sdConfirmed[0],"pctmonthConfirmed"=>$sdConfirmed[1],"SD_14dConfirmed"=>$sdConfirmed_fourteen[0],"pct_14dConfirmed"=>$sdConfirmed_fourteen[1],"SD_7dConfirmed"=>$sdConfirmed_seven[0],"pct_7dConfirmed"=>$sdConfirmed_seven[1],"Trends_monthsConfirmed"=>$TableConfirmed);
      
     $Activearray[] = array("Flag"=>"<a class=\"f32\"><i class=\"flag ".strtolower($row["Country_Code"])."\"></i></a>",
      "Country"=>$cntry,"Active" =>$row["Active"],"SD_monthActive"=>$sdActive[0],"pctmonthActive"=>$sdActive[1],"SD_14dActive"=>$sdActive_fourteen[0],"pct_14dActive"=>$sdActive_fourteen[1],"SD_7dActive"=>$sdActive_seven[0],"pct_7dActive"=>$sdActive_seven[1],"Trends_monthsActive"=>$TableActive);

     $Recoveredarray[] = array("Flag"=>"<a class=\"f32\"><i class=\"flag ".strtolower($row["Country_Code"])."\"></i></a>",
      "Country"=>$cntry,"Recovered" =>$row["Recovered"],"SD_monthRecovered"=>$sdRecovered[0],"pctmonthRecovered"=>$sdRecovered[1],"SD_14dRecovered"=>$sdRecovered_fourteen[0],"pct_14dRecovered"=>$sdRecovered_fourteen[1],"SD_7dRecovered"=>$sdRecovered_seven[0],"pct_7dRecovered"=>$sdRecovered_seven[1],"Trends_monthsRecovered"=>$TableRecovered);
     }
					mysqli_free_result($result);
     
echo "<div class=\"content\">
    <div class=\"tabs\">
      <div role=\"tablist\" aria-label=\"Programming Languages\">
        <button role=\"tab\" aria-selected=\"true\" id=\"tab1\">
          Deaths
        </button>
        <button role=\"tab\" aria-selected=\"false\" id=\"tab2\">
          Confirmed
        </button>
        <button role=\"tab\" aria-selected=\"false\" id=\"tab3\">
          Active
        </button>
        <button role=\"tab\" aria-selected=\"false\" id=\"tab4\">
          Recovered
        </button>
      </div>
   ";
// tab1 Deaths        
 echo "<div role=\"tabpanel\" aria-labelledby=\"tab1\">
  <table class=\"table\" id=\"table-sparkline\">
           <thead class=\"thead-maroon\">
             <tr>
               <th scope=\"col\">#</th>
               <th scope=\"col\">Flag</th>
               <th scope=\"col\">Country</th>
               <th scope=\"col\">Deaths</th>
               <th scope=\"col\">SD/month</th>
               <th scope=\"col\">%/month</th>
               <th scope=\"col\">SD/14d</th>
               <th scope=\"col\">%/14d</th>
               <th scope=\"col\">SD/7d</th>
               <th scope=\"col\">%/7d</th>
               <th style=\"width: 120px\" scope=\"col\">Trends/months</th>
             </tr>
           </thead>          
          <tbody id=\"tbody-sparkline\">";
$i=0;
foreach($Deathsarray as $key => $val){
 $i++;
						echo "       <tr>
                  <th>".$i."</th>
                  <th>".$val["Flag"]."</th>
                  <th>".$val["Country"]."</th>
                  <th>".number_format($val["Deaths"], 0, ',', ' ')."</th>
                  <th>".number_format($val["SD_monthDeaths"], 0, ',', ' ')."</th>
                  <th>".$val["pctmonthDeaths"]."%</th>
                  <th>".number_format($val["SD_14dDeaths"], 0, ',', ' ')."</th>
                  <th>".$val["pct_14dDeaths"]."%</th>
                  <th>".number_format($val["SD_7dDeaths"], 0, ',', ' ')."</th>
                  <th>".$val["pct_7dDeaths"]."%</th>
                  <td style=\"width: 120px\" data-sparkline=\"".$val["Trends_monthsDeaths"]."\"/>
              </tr>	";
}
// end of table and container
echo "          </tbody>
         </table>
        </div>";
// tab2 Confirmed        
 echo "<div role=\"tabpanel\" aria-labelledby=\"tab2\" hidden>
  <table class=\"table\" id=\"table-sparkline\">
           <thead class=\"thead-maroon\">
             <tr>
               <th scope=\"col\">#</th>
               <th scope=\"col\">Flag</th>
               <th scope=\"col\">Country</th>
               <th scope=\"col\">Confirmed</th>
               <th scope=\"col\">SD/month</th>
               <th scope=\"col\">%/month</th>
               <th scope=\"col\">SD/14d</th>
               <th scope=\"col\">%/14d</th>
               <th scope=\"col\">SD/7d</th>
               <th scope=\"col\">%/7d</th>
               <th style=\"width: 120px\" scope=\"col\">Trends/months</th>
             </tr>
           </thead>          
          <tbody id=\"tbody-sparkline\">";
function cmpConfirmed($a, $b)
{
   return ($a['Confirmed']< $b['Confirmed']);
}
usort($Confirmedarray, "cmpConfirmed");
$i=0;
foreach($Confirmedarray as $key => $val){
 $i++;
						echo "       <tr>
                  <th>".$i."</th>
                  <th>".$val["Flag"]."</th>
                  <th>".$val["Country"]."</th>
                  <th>".number_format($val["Confirmed"], 0, ',', ' ')."</th>
                  <th>".number_format($val["SD_monthConfirmed"], 0, ',', ' ')."</th>
                  <th>".$val["pctmonthConfirmed"]."%</th>
                  <th>".number_format($val["SD_14dConfirmed"], 0, ',', ' ')."</th>
                  <th>".$val["pct_14dConfirmed"]."%</th>
                  <th>".number_format($val["SD_7dConfirmed"], 0, ',', ' ')."</th>
                  <th>".$val["pct_7dConfirmed"]."%</th>
                  <td style=\"width: 120px\" data-sparkline=\"".$val["Trends_monthsConfirmed"]."\"/>
              </tr>	";
}
// end of table and container tab2 confirmed
echo "          </tbody>
         </table>
        </div>";         
// tab3 Active        
 echo "<div role=\"tabpanel\" aria-labelledby=\"tab3\" hidden>
  <table class=\"table\" id=\"table-sparkline\">
           <thead class=\"thead-maroon\">
             <tr>
               <th scope=\"col\">#</th>
               <th scope=\"col\">Flag</th>
               <th scope=\"col\">Country</th>
               <th scope=\"col\">Active</th>
               <th scope=\"col\">SD/month</th>
               <th scope=\"col\">%/month</th>
               <th scope=\"col\">SD/14d</th>
               <th scope=\"col\">%/14d</th>
               <th scope=\"col\">SD/7d</th>
               <th scope=\"col\">%/7d</th>
               <th style=\"width: 120px\" scope=\"col\">Trends/months</th>
             </tr>
           </thead>          
          <tbody id=\"tbody-sparkline\">";
$i=0;
function cmpActive($a, $b)
{
   return ($a['Active']< $b['Active']);
}
usort($Activearray, "cmpActive");
foreach($Activearray as $key => $val){
 $i++;
						echo "       <tr>
                  <th>".$i."</th>
                  <th>".$val["Flag"]."</th>
                  <th>".$val["Country"]."</th>
                  <th>".number_format($val["Active"], 0, ',', ' ')."</th>
                  <th>".number_format($val["SD_monthActive"], 0, ',', ' ')."</th>
                  <th>".$val["pctmonthActive"]."%</th>
                  <th>".number_format($val["SD_14dActive"], 0, ',', ' ')."</th>
                  <th>".$val["pct_14dActive"]."%</th>
                  <th>".number_format($val["SD_7dActive"], 0, ',', ' ')."</th>
                  <th>".$val["pct_7dActive"]."%</th>
                  <td style=\"width: 120px\" data-sparkline=\"".$val["Trends_monthsActive"]."\"/>
              </tr>	";
}
// end of table and container Active tab3
echo "          </tbody>
         </table>
        </div>";
// tab4 Recovered        
 echo "<div role=\"tabpanel\" aria-labelledby=\"tab4\" hidden>
  <table class=\"table\" id=\"table-sparkline\">
           <thead class=\"thead-maroon\">
             <tr>
               <th scope=\"col\">#</th>
               <th scope=\"col\">Flag</th>
               <th scope=\"col\">Country</th>
               <th scope=\"col\">Recovered</th>
               <th scope=\"col\">SD/month</th>
               <th scope=\"col\">%/month</th>
               <th scope=\"col\">SD/14d</th>
               <th scope=\"col\">%/14d</th>
               <th scope=\"col\">SD/7d</th>
               <th scope=\"col\">%/7d</th>
               <th style=\"width: 120px\" scope=\"col\">Trends/months</th>
             </tr>
           </thead>          
          <tbody id=\"tbody-sparkline\">";
$i=0;
function cmpRecovered($a, $b)
{
   return ($a['Recovered']< $b['Recovered']);
}
usort($Recoveredarray, "cmpRecovered");
foreach($Recoveredarray as $key => $val){
 $i++;
						echo "       <tr>
                  <th>".$i."</th>
                  <th>".$val["Flag"]."</th>
                  <th>".$val["Country"]."</th>
                  <th>".number_format($val["Recovered"], 0, ',', ' ')."</th>
                  <th>".number_format($val["SD_monthRecovered"], 0, ',', ' ')."</th>
                  <th>".$val["pctmonthRecovered"]."%</th>
                  <th>".number_format($val["SD_14dRecovered"], 0, ',', ' ')."</th>
                  <th>".$val["pct_14dRecovered"]."%</th>
                  <th>".number_format($val["SD_7dRecovered"], 0, ',', ' ')."</th>
                  <th>".$val["pct_7dRecovered"]."%</th>
                  <td style=\"width: 120px\" data-sparkline=\"".$val["Trends_monthsRecovered"]."\"/>
              </tr>	";
}
// end of table and container tab 4 Recovered
echo "          </tbody>
         </table>
        </div>";

// content end
echo "   </div>
        </div>
         <div class=\"tablecopyright\"><a style=\"text-decoration:none;\" id=\"tablecopyrighta\"></a></div>
 ";
?>
 <hr>
<!-- Footer -->
<div class="containerfooter">
   <a class="afa" href="https://lombard-web-services.com/lwebservices/">
   <i class="fa fa-circle fa-stack-2x"></i>
   <i class="fa fa-lombard fa-stack-1x fa-inverse"></i>
   </a>
</div>
<div class="footercopyright">
   <p style="font-size:0.8em;font-weight:250;">Copyright &copy; <span id="annee"></span> Lombard Web Services </p>
</div>
<script src="js/sparkline.js"></script>
<script type="text/javascript">
    var urltoshare = window.location.href;
    $('.tw-share-button').click(function() {
      var twitterWindow = window.open('https://twitter.com/share?url=' + urltoshare, 'twitter-popup', 'height=350,width=600');
      if(twitterWindow.focus) { twitterWindow.focus(); }
        return false;
    });
    $('.fb-share-button').click(function() {
         window.open('https://www.facebook.com/sharer/sharer.php?u=' + urltoshare,
             'facebook-share-dialog',
             'width=800,height=600'
         );
     }); 
    $('.lnkdn-share-button').click(function() {
         window.open('https://www.linkedin.com/shareArticle?mini=true&url=' + urltoshare,
             'linkedin-share-dialog',
             'width=800,height=600'
         );
     }); 
   $('.table').stickyTableHeaders();
   jQuery.extend( jQuery.fn.dataTableExt.oSort, {
       "percent-pre": function ( a ) {
           var x = (a == "-") ? 0 : a.replace( /%/, "" ).replace(/ /,"");
           return parseFloat( x );
       },
       "percent-asc": function ( a, b ) {
           return ((a < b) ? -1 : ((a > b) ? 1 : 0));
       },
       "percent-desc": function ( a, b ) {
           return ((a < b) ? 1 : ((a > b) ? -1 : 0));
       }
   });
   $('.table').dataTable( {
    columnDefs: [
      { "orderable": false, "targets": [10] },
      { "type": "percent", "targets": [0, 2, 3, 4, 5, 6, 7, 8, 9] }
    ],
    // Disable pagination
    // Disable search and activate search serverside
    "bFilter": false,
    "bLengthChange": false,
    "bPaginate": false,
    "paging":   false,
    "ordering": false,
    "destroy": true,
    "info":     false
   });
   navbarheight = $( '.navbar-custom' ).outerHeight();
   containerpx =  $(window).height() - navbarheight;
   $('.mapcontainer').css({'height':containerpx,'width':'100%'});
   $('.navbar-custom').css({'z-index':'110'});
   $('.mapcontainer').css({'padding-top':navbarheight});
   const tabs = document.querySelector('.tabs');
   const tabButtons = tabs.querySelectorAll('[role="tab"]');
   const tabPanels = Array.from(tabs.querySelectorAll('[role="tabpanel"]'));
   
   function handleTabClick(event) {
     tabPanels.forEach(panel => panel.hidden = true);
     // Mark all tabs as unselected
     tabButtons.forEach(tab => tab.setAttribute("aria-selected", false));
     // Mark the clicked tab as selected
     event.currentTarget.setAttribute("aria-selected", true);
     // console.log('tab shown id=>'+event.currentTarget.id);
     // Find the associated tabPanel and show it
     const { id } = event.currentTarget;
     // Find in the array of tabPanels
     const tabPanel = tabPanels.find(
       panel => panel.getAttribute('aria-labelledby') === id
     );
     tabPanel.hidden = false;
   }
   tabButtons.forEach(button => button.addEventListener('click', handleTabClick));
   $(window).load(function() {
     var annee = 2020; 
     var year = new Date(); if(annee == year.getFullYear()) year = year.getFullYear(); else year = annee + ' - ' + year.getFullYear(); 
     an = $('#annee');
      an.html(year);
    });	
</script>
</body>
</html>
