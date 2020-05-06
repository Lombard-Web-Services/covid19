# COVID19 Bot
3 bots are available for your COVID19 related website/dashboard. 

## Robots list
* scraper.php - a PHP cli script to scrape, clean, store into a MySQL db and generate csv data periodically from the official Johns Hopkins Repository
* jsonmap.php - a PHP cli script to generate fresh JSON file of a dataset from the previously imported database
* covid_table.php  - a PHP cli script to generate periodically Standard deviation , Coefficient of Variation on a range of 31 days , 14 days and 7 days

## Robots dependencies
* php-gmp
* php-mbstring
* php-curl
* php-cli
* php-mysql
* curl

# scraper.php installation instructions
Firstly fill up your database credentials on top of the scraper.php file.
Create a database (replace by your configuration)

```sh
CREATE DATABASE `COVID19`;
ALTER DATABASE `COVID19` COLLATE utf8_unicode_ci
USE `COVID19`;
CREATE TABLE `COVID19_TABLE` (
 `IDMC` int NOT NULL AUTO_INCREMENT,
 `FIPS` VARCHAR(20),
 `Admin2` VARCHAR(300),
 `Province_State` VARCHAR(300),
 `Country_Region` VARCHAR(500),
 `Country_Code` VARCHAR(200),
 `Country_CodeA3` VARCHAR(200),
 `Last_Update` DATETIME,
 `Lat` VARCHAR(20),
 `Lon` VARCHAR(20),
 `Confirmed` VARCHAR(20),
 `Deaths` VARCHAR(20),
 `Recovered` VARCHAR(20),
 `Active` VARCHAR(20),
 `Combined_Key` VARCHAR(500),
 PRIMARY KEY ( `IDMC` )
) ENGINE = InnoDB
```
Note: in this example I have used "COVID19"as database name and "COVID19_TABLE" as table name, feel free to change these information by your own configuration.

Secondly put the scraper.php file into a "secure" directory, (IE behind the public_html folder). Create a directory and put the [cc.csv] file into it.
```sh
chmod +x scraper.php
mkdir -p public_html/data/
wget -O public_html/data/cc.csv https://raw.githubusercontent.com/Lombard-Web-Services/covid19/tree/master/bot/cc.csv
```

## scraper.php options
Here are the cli options 
f - folder where the datas are saved from the relative path of this script (without slash on start and in the end)
c - options for checking duplicates/updates during the update (yes or no)
s - start date (the start date of the dataset format d-m-Y  (first date is 22-01-2020)

Example if you need the dataset since the start of the covid without checking for duplicates into your database: 
```sh
nohup php scraper.php --f=public_html/data --c=no --s=22-01-2020 &
```

## scraper.php cron
It's possible to set up a cron in order to periodically make updates (crontab -e), think to replace the "scriptabsolutepath" in this following command by your script absolute path. For example, this command permit to check every day at 6:07AM the latest update of the day.

```sh
7 6 * * * php /scriptabsolutepath/scraper.php --f=public_html/data --c=yes  >> /scriptabsolutepath/scraper.log
```
# jsonmap.php installation instructions
The file jsonmap.php is a cli PHP script that could be changed into an api with a few lines of codes. Its first purpose was to request data directly from the database and show the JSON results on a page, but once rethinked, I have changed the operating mode of this script to act such as a robot to generate large and smaller JSON files from the Johns Hopkins COVID 19 daily reports database scraped previously with scraper.php. 

So lets filling up the top of the jsonmap.php file.
FYI:
* updatehour variable to match with your daily update cron from the import script scraper.php
* rowresultslimit, is your supported database row results limits, changing this number depends on the performance of your system
```sh
$host = "databasehost";
$username = "username";
$password = "password";
$dbname  = "dbname"; 
$tablename = "tablename";
// configure the update hour of the CSSE DB import
$updatehour = 8;
// limit the result for a row request without grouping
$rowresultlimit = 9999999;
```

## jsonmap.php options

f - folder where the datas are saved from the relative path of this script (without slash on start and in the end)
g - For group request 
n - options for checking numbers of days between today

the parameter g : Is for grouping result by a specific parameter key, list of parameters :IDMC FIPS Admin2 Province_State Country_Region Country_Code Country_CodeA3 Last_Update Lat Lon Confirmed Deaths Recovered Active Combined_Key,Ndate,NCCdate

Note about Ndate and NCCdate:
Ndate represent the normal date (format YYYY-MM-dd)
NCCdate represent the normal date with country code(alpha2) parameter included (format YYYY-MM-dd.CC)

Effect of the group parameter function :
If the group parameter is used a cumulative sum will take effect on each of these specific fields/columns :Confirmed,Deaths,Recovered,Active 

## jsonmap.php cron
To generate daily a JSON database of a 8 days range of cumulated results grouped by Country codes and by date
```sh
0 8 * * * php /scriptabsolutepath/jsonmap.php --f=public_html/data --n=8 --g=NCCdate >> /scriptabsolutepath/jsonmap.log
```
Do not forget to replace "scriptabsolutepath" by the script absolute path.
# covid_table.php installation instructions
The covid_table.php is a cli script that permit to generate a fresh computed table of standard deviation and coefficient of variation on a selected range date the data computed are for 7, 14, 32 days. The script is working only if you have used previously scraper.php to crawl the datas.
The role of this PHP file is to save the standard deviation and variation results into the MySQL database and generate a csv file while the job is ended.

You need this table into your database before using this script.
```sh
CREATE TABLE `SD` (
 `IDSD` int NOT NULL AUTO_INCREMENT,
 `FromDate` DATETIME,
 `ToDate` DATETIME,
 `Country_Code` varchar(20),
 `Confirmed` VARCHAR(40),
 `Deaths` VARCHAR(40),
 `Recovered` VARCHAR(40),
 `Active` VARCHAR(40),
 `SDConfirmed` VARCHAR(40),
 `SDDeaths` VARCHAR(40),
 `SDRecovered` VARCHAR(40),
 `SDActive` VARCHAR(40),
 `SDConfirmed_seven` VARCHAR(40),
 `SDDeaths_seven` VARCHAR(40),
 `SDRecovered_seven` VARCHAR(40),
 `SDActive_seven` VARCHAR(40),
 `SDConfirmed_fourteen` VARCHAR(40),
 `SDDeaths_fourteen` VARCHAR(40),
 `SDRecovered_fourteen` VARCHAR(40),
 `SDActive_fourteen` VARCHAR(40),
 `TableConfirmed` VARCHAR(3000),
 `TableDeaths` VARCHAR(3000),
 `TableRecovered` VARCHAR(3000),
 `TableActive` VARCHAR(3000),
 PRIMARY KEY ( `IDSD` )
) ENGINE = InnoDB
```
Do not forget to modify the top of the php covid_table.php file 
```sh
$host = "databasehost";
$username = "username";
$password = "password";
$dbname  = "dbname"; 
$tablename = "tablename";
// configure the update hour of the CSSE DB import
$updatehour = 8;
// limit the result for a row request without grouping
$rowresultlimit = 9999999;
```
## covid_table.php options
f - the destination directory without first and last slashes where the csv file will be saved

## covid_table.php cron
To setup a daily covid standard deviation and coefficient of variation generation table import at 7 o'clock AM.
```sh
0 7 * * * php /scriptabsolutepath/covid_table.php --f=public_html/data  >> /scriptabsolutepath/covid_table.log
```
Do not forget to replace the "scriptabsolutepath" by the script absolute path.

[comment]: #
   [cc.csv]: <https://raw.githubusercontent.com/Lombard-Web-Services/covid19/master/bot/cc.csv>

