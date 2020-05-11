- Execute the 3 cron bots available on github well configured with your update hour https://github.com/Lombard-Web-Services/covid19/tree/master/bot

- Once the data are imported change the top of the index.php file with your own credentials.

- modify the file js/choropleth.js by your own settings

apiURL = 'https://yourwebsite.tld/';
foldername = "data/";
fileprefix = "map_";
numberofdays = 8;
hourofupdate = 8;

- rename the htaccess file to .htaccess (you need apache2  mod rewrite, eventually mod headers)

- to display a specific outbreak you can issue a date (dd-mm-yyyy) in the d parameter of the index , example :
https://yourwebsite.tld/?d=09-05-2020

- a demo is available here : https://covid19.lombard-web-services.com

Feel free to change meta tags and og links to your headers.

Your website is now up and running.
Here you are.
