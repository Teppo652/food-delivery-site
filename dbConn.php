<?
function getDBConn() 
{
	$currDirName = substr(getcwd(), 0, 1);			
	if($currDirName == 'C') 
  {  
      // LOCAL WAMP TEST SERVER
      //echo '<br>This is test server.<br>';
      
      $username = "root"; // root
      $password = "";
      // $servername = "127.0.0.1:8080"; // 
      $servername = "localhost"; //  127.0.0.1
      $dbname = "pizza";
      
      //$servername = "localhost";
      //$username = "1029520";
      //$password = "qwerty";
      //$dbname = "1029520db2";
      $conn = new mysqli($servername, $username, $password, $dbname);
      $conn->set_charset("utf8");
    } 
    else 
    { 
      //echo '<br>This is name cheap server.<br>'; 
      // name cheap
      $dbName="stufssjm_pizza";
      $username = "stufssjm_kindacooladmin"; 
      $password = "IsThisIsTheWayWeParty";
      // $servername = "127.0.0.1:3306"; // 
      $servername = "localhost"; //  127.0.0.1
      $conn = mysqli_connect($servername, $username, $password, $dbName);
      $conn->set_charset("utf8mb4");
    }

// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
		return null;
	} else {
		return $conn;
	}
}
?>