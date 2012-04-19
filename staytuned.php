<?php
//Send some headers to keep the user's browser from caching the response.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
header("Content-Type: text/json; charset=utf-8");


$db_host = "localhost";
$db_user = "root";
$db_password = "c1cci0";
$db_database = "keebuu";
$db_tab_newsletter = "newsletter";




$email = "";
$json = '{"response":';
if (isset($_GET['newsletter'])) $email = $_GET['newsletter'];

if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
  $json .= '"ko"';
  }
else
  {
   // verifico che non esista già l'email nel database
  
   $query = "SELECT * FROM ".$db_tab_newsletter." where email='".$email."'";
     $conn = mysql_connect($db_host,$db_user,$db_password);

     mysql_select_db($db_database, $conn) or die ("Error in database selection. Verification parameters.");
     $result = mysql_query($query, $conn);
 if ($row = mysql_fetch_array($result)){
      $json .= '"ko"';
  }
  else{
       mysql_query("INSERT INTO newsletter (email) VALUES ('".$email."')");
       $json .= '"ok"';
  }
     mysql_close($conn);
  }
$json .= '}';
echo $json;
?>
