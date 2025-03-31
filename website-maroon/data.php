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
 <link rel="icon" type="image/png" sizes="192x192" href="images/favicon/android-icon-192x192.png">
 <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
 <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
 <link rel="manifest" href="images/favicon/manifest.json">
 <meta name="msapplication-TileColor" content="#ffffff">
 <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
 <meta name="theme-color" content="#ffffff">
 <meta name="description" content="COVID 19 Map & Numbers">
 <meta name="author" content="COVID-19 LOMBARD WEB SERVICES">
 <meta name="keywords" content="Look backward, to better see tomorrow..">
 <meta name="robots" content="index,follow">
 <meta name="copyright" content="Lombard Web Services">
 <meta property="og:title" content="Covid-19 stats">
 <meta property="og:site_name" content="covid19.lombard-web-services.com">
 <meta property="og:url" content="https://covid19.lombard-web-services.com/">
 <meta property="og:description" content="Covid 19 Stats">
 <meta property="og:locale" content="fr_FR">
 <meta property="article:author" content="https://www.linkedin.com/in/thibautlombard/">
 <meta property="og:image" content="https://covid19.lombard-web-services.com/images/og.png">
 <meta name="twitter:card" content="summary_large_image">
 <meta name="twitter:description" content="COVID 19 Standard Deviation, Variations, and Map data, stats and infographics">
 <meta name="twitter:title" content="COVID 19 Standard Deviation, Variations, and Map , the dashboard with useful stats">
 <meta name="twitter:domain" content="https://covid19.lombard-web-services.com">
 <meta name="twitter:image" content="https://covid19.lombard-web-services.com/images/ogtw.png">
 <title>COVID19 Data</title>
 <link href="css/flags32.css" media="screen" rel="stylesheet" type="text/css">
 <link href="css/tlmaps.css" media="screen" rel="stylesheet" type="text/css">
 <link href="css/style.css" rel="stylesheet">
 <link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
 <script src="js/jquery.js"></script>
</head>
<body>
 <div class="navbar-custom">
  <ul>
   <li class="nleft" style="float:left;">
    <img src="images/logo.png" width="45%" alt="Logo">
   </li>
   <li class="lnkdn-share-button">
    <a href="#">
     <svg viewBox="0 50 512 512">
      <path fill="#ffffff" d="M150.65,100.682c0,27.992-22.508,50.683-50.273,50.683c-27.765,0-50.273-22.691-50.273-50.683C50.104,72.691,72.612,50,100.377,50C128.143,50,150.65,72.691,150.65,100.682z M143.294,187.333H58.277V462h85.017V187.333zM279.195,187.333h-81.541V462h81.541c0,0,0-101.877,0-144.181c0-38.624,17.779-61.615,51.807-61.615c31.268,0,46.289,22.071,46.289,61.615c0,39.545,0,144.181,0,144.181h84.605c0,0,0-100.344,0-173.915s-41.689-109.131-99.934-109.131s-82.768,45.369-82.768,45.369V187.333z"/>
     </svg>
     <span>Share</span>
    </a>
   </li>
   <li class="fb-share-button">
    <a href="#" data-js="twitter-share">
     <svg viewBox="0 0 12 12" preserveAspectRatio="xMidYMid meet">
      <path class="svg-icon-path" d="M9.1,0.1V2H8C7.6,2,7.3,2.1,7.1,2.3C7,2.4,6.9,2.7,6.9,3v1.4H9L8.8,6.5H6.9V12H4.7V6.5H2.9V4.4h1.8V2.8 c0-0.9,0.3-1.6,0.7-2.1C6,0.2,6.6,0,7.5,0C8.2,0,8.7,0,9.1,0.1z"></path>
     </svg>
     <span>Share</span>
    </a>
   </li>
   <li class="tw-share-button">
    <a href="#">
     <svg viewBox="328 355 335 276" xmlns="http://www.w3.org/2000/svg">
      <path d="M 630, 425A 195, 195 0 0 1 331, 600A 142, 142 0 0 0 428, 570A 70, 70 0 0 1 370, 523A 70, 70 0 0 0 401, 521A 70, 70 0 0 1 344, 455A 70, 70 0 0 0 372, 460A 70, 70 0 0 1 354, 370A 195, 195 0 0 0 495, 442A 67, 67 0 0 1 611, 380A 117, 117 0 0 0 654, 363A 65, 65 0 0 1 623, 401A 117, 117 0 0 0 662, 390A 65, 65 0 0 1 630, 425Z" style="fill:#ffffff;"/>
     </svg>
     <span>Share</span>
    </a>
   </li>
   <li class="active">
    <a href="connex">Data</a>
   </li>
   <li>
    <a href="maths">Machine Learning</a>
   </li>
   <li>
    <a href="index">Home</a>
   </li>
  </ul>
 </div>
 <div class="datablock">
  <div class="single-comment-box">
   <div class="img-box">
    <img src="images/dl-opendata.png" alt="Download Open Data">
   </div>
   <div class="text-box">
    <h3>COVID19 reports</h3>
    <p>The dailies reports produced by Johns Hopkins University CSSE related to covid 19, cleaned data with ISO country codes Alpha2 and Alpha3 included, available in one csv file.
     <br>Date : <span class="datedl"></span>
     <br>Source : <a href="https://github.com/CSSEGISandData/COVID-19/tree/master/csse_covid_19_data/csse_covid_19_daily_reports" target="_blank">CSSE GIS and Data Github</a>
    </p>
    <a href="data/csse_covid_19_daily_reports_FULL.csv" class="reply" target="_blank">Download</a>
   </div>
  </div>
  <div class="single-comment-box">
   <div class="img-box">
    <img src="images/dl-opendata.png" alt="Download Open Data">
   </div>
   <div class="text-box">
    <h3>COVID19 Json 8 Days</h3>
    <p>The 8 days data from covid 19 JH database,in JSON format, usable from the TLMAPS script (see github for more info) available for generating the maps.
     <br>Date : <span class="datedl"></span>
     <br>Source : <a class="mapjson" href="#" target="_blank">lombard-web-services.com</a>
    </p>
    <a href="#" class="reply mapjson" target="_blank">Download</a>
   </div>
  </div>
  <div class="single-comment-box">
   <div class="img-box">
    <img src="images/dl-opendata.png" alt="Download Open Data">
   </div>
   <div class="text-box">
    <h3>COVID19 SD & CV </h3>
    <p>The dailies reports csv file of the Standard deviations and the coefficient of variation for the COVID19 data, time series available every days exented on one month,14 days, and 7 days .
     <br>Date : <span class="datedl"></span>
     <br>Source : <a href="data/SD_Variation_Table_covid_19_daily_reports_FULL.csv" target="_blank">lombard-web-services.com</a>
    </p>
    <a href="data/SD_Variation_Table_covid_19_daily_reports_FULL.csv" class="reply" target="_blank">Download</a>
   </div>
  </div>
  <div class="single-comment-box">
   <div class="img-box gh">
    <svg width="5em" height="5em" viewBox="0 0 24 24">
     <path fill="#691F0E" d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
    </svg>
   </div>
   <div class="text-box">
    <h3>COVID19 Repo</h3>
    <p>This whole website, including robots such as scraper for CSSE Johns Hopkins data, json COVID19 dataset generator, Standard Deviation and Coefficient of variation table maker, also an especially crafted TLMAPS version .
    </p>
    <a href="https://github.com/Lombard-Web-Services/covid19" class="reply" target="_blank">Navigate</a>
   </div>
  </div>
 </div>
 <div class="ffooter">
  <hr>
  <div class="containerfootersignature">
   <a class="afa" href="https://lombard-web-services.com/lwebservices/">
    <i class="fa fa-circle fa-stack-2x"></i>
    <i class="fa fa-lombard fa-stack-1x fa-inverse"></i>
   </a>
  </div>
  <div class="footercopyrightsignature">
   <p style="font-size:0.8em;font-weight:250;padding-top:1em;">Copyright &copy; <span id="annee"></span> Lombard Web Services </p>
  </div>
 </div>
 <script>
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
  hourofupdate = 8;
  var hourofupdate;
  gethourtoday = new Date().getHours();
  today = new Date();
  if(gethourtoday < parseInt(hourofupdate)){
   thedaytodayis1 = today.setDate(today.getDate() - 2);
   thedaytodayis = new Date(thedaytodayis1).toISOString().slice(0,10);
  } else {
   thedaytodayis1 = today.setDate(today.getDate() - 1);
   thedaytodayis = new Date(thedaytodayis1).toISOString().slice(0,10);
  }
  $(".datedl").html(thedaytodayis);
  $('.mapjson').attr('href','data/map_'+thedaytodayis+'.json');
  $(window).load(function() {
   var annee = 2020;
   var year = new Date();
    if(annee == year.getFullYear()) {
     year = year.getFullYear();
    } else {
     year = annee + ' - ' + year.getFullYear();
    }
   an = $('#annee');
   an.html(year);
  });
 </script>
</body>
</html>
