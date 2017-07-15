<?php 
header('Content-Type: application/json');
$host = "localhost"; 
$user = "admin"; 
$pass = "123"; 
$database = "world"; 

$linkID = mysql_connect($host, $user, $pass) or die("Could not connect to host."); 
mysql_select_db($database, $linkID) or die("Could not find database."); 
mysql_query("SET NAMES utf8");
$sth = mysql_query("SELECT
country.Code2 as code,
country.Code as code2,
country.Name as name,
country.Continent as continent,
country.Region as region,
codearea.dial_code as dial_code
FROM
country
left Join codearea ON country.Code2 = codearea.code");
$rows = array();
while($r = mysql_fetch_assoc($sth)) {
   //$rows[] = $r;
   $code = $r['code'];
   $code2 = $r['code2'];
   $name = $r['name'];
   $continent = $r['continent'];
   $region = $r['region'];
   $dial_code = $r['dial_code'];
   
   
	$sth1 = mysql_query("SELECT
	city.ID as id,
	city.Name as city,
	city.District as district
	FROM
	city where city.CountryCode = '$code2' ");
	$rows1 = array();
	while($r1 = mysql_fetch_assoc($sth1)) {
	   $rows1[] = $r1;	   
	   
	}
   //$rows['city'] = $rows1;
   $rows[] = array("code"=>$code,"code2"=>$code2,"name"=>$name,"dial_code"=>$dial_code,"continent"=>$continent,"region"=>$region,"city"=>$rows1);
   
   
   
   
}
print json_encode($rows);
$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($rows));
fclose($fp);

?>