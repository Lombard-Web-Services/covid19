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
      <meta property="og:title" content="Covid-19 stats" />
      <meta property="og:site_name" content="covid19.lombard-web-services.com"/>
      <meta property="og:url" content="https://covid19.lombard-web-services.com/" />
      <meta property="og:description" content="Covid 19 Stats" />
      <meta property="og:locale" content="fr_FR" />
      <meta property="article:author" content="https://www.linkedin.com/in/thibautlombard/" />
      <meta property="og:image" content="https://covid19.lombard-web-services.com/images/og.png" />
      <!-- SEO Twitter -->
      <meta name="twitter:card" content="summary_large_image"/>
      <meta name="twitter:description" content="COVID 19 World data, stats and infographics"/>
      <meta name="twitter:title" content="COVID 19 Standard Deviation, Variations, and Map , the dashboard with useful stats"/>
      <meta name="twitter:domain" content="https://covid19.lombard-web-services.com"/>
      <meta name="twitter:image" content="https://covid19.lombard-web-services.com/images/ogtw.png"/>
      <title>COVID19 Maths - Standard Deviation, Variations, and Map</title>
      <link href="css/flags32.css" media="screen" rel="stylesheet" type="text/css"/>
      <link href="css/tlmaps.css" media="screen" rel="stylesheet" type="text/css"/>
      <!-- Custom CSS -->
      <link href="css/style.css" rel="stylesheet">
      <!-- Custom Fonts -->
      <link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
      <script src="js/jquery.js"></script>
      <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
      <script>
         MathJax = {
             tex: {inlineMath: [['$', '$'], ['\\(', '\\)']]},
             svg: {fontCache: 'global'}
           };
         data = [369,242,437,367,427,289,218];
           let getMean = function (data) {
             return data.reduce(function (a, b) {
                 return Number(a) + Number(b);
             }) / data.length;
         };
         let getSD = function (data) {
             let m = getMean(data);
             return Math.sqrt(data.reduce(function (sq, n) {
                     return sq + Math.pow(n - m, 2);
                 }, 0) / (data.length));
         };
         console.log(getSD(data));
      </script>
      <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>
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
            <li class="active">
               <a href="maths">Machine Learning</a>
            </li>
            <li>
               <a href="index">Home</a>
            </li>
         </ul>
      </div>
            <div class="maths">
               <h3 style="text-align:center;">Machine learning techniques overview</h3>
               <h1>Arithmetic progression applied on legend colors</h1>
               <p> On the first page of this website, I have used a function to adapt the positive numbers of the dataset to the legend of the map. This algorithm is working for linear normalization. 
                  The rgb triplet matrix is named N set 
                  $$N=[RGB]$$
                  x is a color associated into the rgb matrix
                  $$x_{color}\in N$$ 
                  S is an arithmetic sequence where x min and x max values are into the interval.
                  $$S_{x}=\{x \in N \mid x_{min} \leq n \leq x_{max} \} $$
                  So x could be a non negative real number  $$x \in \mathbb{R}$$
                  After that we can create a quantifier for our legend knowing the maximum values of our set, I have commutated for each colors the color number with the xmax value divided by the n number of colors I wish to display. 
                  $$ \forall{x} P(x) = \sum{x_{color}} * (\frac{x_{max}} n_{color} )$$
               </p>
               <h1>Standard Deviation applied on COVID 19 data (regression tree algorithm)</h1>
               <p>Following this numerical sample, based on 7 days of Deaths people in France because of the COVID-19 virus since 2nd May 2020 (from Johns Hopkins University data), I have used a Standard Deviation (From decision tree algorithm) to calculate the homogeneity of the numerical sample.</p>
               <p>Example:<br>
                  Our sequence of positive numbers :
                  $$A = \{369,242,437,367,427,289,218\} $$
                  The count of this sequence is $$n_{A} = 7$$
                  The average $$\bar{x} = \frac{\sum x} n = 335.571$$
                  The standard deviation $$S = \sqrt{ \frac{(\sum x - \bar{x})^{2}} n} = 80.622$$
                  The Coefficient of variation is $$CV = \frac{S}{\bar{x}} * 100 \% = 24.03 $$  
               </p>
               <p>By comparing the coefficient of variation with the number of deaths over 7, 14 , 31 days we can estimate more precisely the variation of the epidemy trough time. Moreover these numbers open the possibilities to estimate the efficiency of the isolation measures and their impact related to these 4 following factors : Active, Deaths, Recovered, Confirmed.</p>
            </div>
<!-- Footer -->
<hr>
<div class="containerfooter">
   <a class="afa" href="https://lombard-web-services.com/lwebservices/">
   <i class="fa fa-circle fa-stack-2x"></i>
   <i class="fa fa-lombard fa-stack-1x fa-inverse"></i>
   </a>
</div>
<div class="footercopyright" style="font-size:0.8em;font-weight:250;">
   <p style="font-size:0.8em;font-weight:250;">Copyright &copy; <span id="annee"></span> Lombard Web Services </p>
</div>
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
         $(window).load(function() {
           var annee = 2020; 
           var year = new Date(); if(annee == year.getFullYear()) year = year.getFullYear(); else year = annee + ' - ' + year.getFullYear(); 
           an = $('#annee');
            an.html(year);
          });	
      </script>
   </body>
</html>
