<?php
function getTodaysDate($getWhat='date')
{
  $now = new DateTime();
  $now->setTimezone( new \DateTimeZone( 'Europe/Helsinki' ) ); // full list: http://php.net/manual/en/timezones.php  
  if($getWhat='date') { return $now->format('ymd'); exit; } 
  if($getWhat='hour') { return $now->format('H'); exit; } // 'Y-m-d H:i:s'; all have leading zero - cheked
  if($getWhat='dateTime') { return $now->format('ymdHi'); exit; }

/*
  $yy = substr($dbDateYYMMDDHHMM,0,2);
  $mm = substr($dbDateYYMMDDHHMM,2,2);
  $dd = substr($dbDateYYMMDDHHMM,4,2);
  $date = $yy . '-' . $mm . '-' . $dd; // '07-01-16'
*/
  // $startDay = DateTime::createFromFormat('y-m-d', $all)->format('y-m-d');
  /////////$startDay = DateTime::createFromFormat('y-m-d', $all);
  // $date2 = new DateTime("2009-06-26");
  // $interval = $startDay->diff($today);
  // return $today . ' x ' . $startDay . '<br>' . "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
  // // shows the total amount of days (not divided into years, months and days like above)
  // echo "difference " . $interval->days . " days ";
  //return $today . ' x ' . $startDay . ' DIFF: ' . $interval->format('%R%a days') ." ."; 
  return $date;
}
// -------------- FILE FUNCTIONS ---------------
//$newSitesFolder = 'sites';

function createDir($newDir)
{
	$dir = realpath(dirname(__FILE__)) . '/sites/' . $newDir;
    if ( !file_exists($dir) ) {
        $oldmask = umask(0);  // helpful when used in linux server  
        mkdir ($dir, 0777);
        echo '<br>' . 'Created dir:' . $dir . '<br>';
    }

    //file_put_contents($dir.'/testDir.txt', 'Hello File');
    ////chmod($dir.'/testDir.txt', 0777); // protect from deleting
}

function createFile($newDir, $newFile)
{
	$file2 =  getcwd() . '/' . 'sites/' . $newDir . '/' . $newFile;
    echo '<br>' . 'Created file: ' . $file2 . '<br>';
    $person = "John Smith\n";
    file_put_contents($file2, $person);    
    // chmod($file2, 0777); // protect from deleting
}
// -------------- ENCRYPTION FUNCTIONS -------------
// source: http://stackoverflow.com/questions/13425764/blowfish-encryption-in-php

function decrypt($data,$key){
    $iv=pack("H*" , substr($data,0,16));
    $x =pack("H*" , substr($data,16)); 
    $res = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $x , MCRYPT_MODE_CBC, $iv);
    return $res;
}

function encrypt($data,$key){
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $data, MCRYPT_MODE_CBC, $iv); // key max 56 chars?
    return bin2hex($iv . $crypttext);
}

//$str = "Kissa"; 
//$key = '12345678901234567890123456789012345678901234567890'; // key max 56 chars?
//echo 'String: ' . $str . '<br>';
//$strEncrypted = encrypt_blowfish($str, $key);
//echo 'Encrypted: ' . $strEncrypted . '<br>';
//
//$strDecrypted = decrypt_blowfish($strEncrypted, $key);
//echo 'Decrypted: ' . $strDecrypted . '<br>';
//echo 'Length: ' . strlen($strEncrypted) . '<br><br>';

// -------------- DATABASE FUNCTIONS ---------------

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
     
function getLargestValue($fieldName, $table, $conn)
{
  $sql = "SELECT MAX(" . $fieldName . ") AS largestValue FROM " . $table;
  $result = mysqli_query($conn, $sql) or die(mysql_error());            
  while($row = mysqli_fetch_assoc($result))
  {
    return $row['largestValue'];
  }             
}

function getSingle($getWhat, $tableName, $where, $value, $conn) 
{  
  $data = "";  
  $sql = "SELECT " . $getWhat . " FROM " . $tableName . ' WHERE ' . $where . " = '" . $value . "' LIMIT 1"; 
  //echo '<br>SQL: ' . $sql . '<br>';
  $result = mysqli_query($conn, $sql);
  
  if (mysqli_num_rows($result) > 0)
  {    
    while($row = mysqli_fetch_assoc($result))
  	{        
  	    $data .= $row[$getWhat]; // single
    }
  }
  return $data;
}

//function getNumberOfTables($siteId, $conn)
//{
//    $sql = "SELECT * FROM gen_tables WHERE siteId=" . $siteId;
//    return mysqli_num_rows(mysqli_query($conn,  $sql));
//}
     
     
     
// ------------------------- below not in use yet ------------------------     
     
function createTable($sql, $conn)
{
	echo '<br>Starting to create table<br>';	
  
	// // sql to create table
	// $sql = "CREATE TABLE ' . $newTable . ' (
	// id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	// firstname VARCHAR(30) NOT NULL,
	// lastname VARCHAR(30) NOT NULL,
	// email VARCHAR(50),
	// reg_date TIMESTAMP
	// )";
  
	// // $sql = "CREATE DATABASE " . $newTable . ";";
  // $sql = "CREATE TABLE " . $newTable . ";";
  
  
  
  
  // $db->exec($sql);
	if ($conn->query($sql) === TRUE) {
	    echo 'Table ' . $newTable . ' created successfully';
	} else {
	    echo 'Error creating ' . $newTable . ': ' . $conn->error;
      echo '<br>SQL: ' . $sql;
	}
	
	$conn->close();
}

/*
// DELETE THIS
CREATE TABLE users
(
id int identity primary key,
userId int NOT NULL,
firstName VARCHAR(50) NOT NULL,
lastName VARCHAR(50) NOT NULL,
email VARCHAR(50) NOT NULL,
login VARCHAR(25) NOT NULL,
password VARCHAR(25) NOT NULL,
active bit NOT NULL DEFAULT 'true'
)

INSERT INTO users (userId,firstName,lastName,email,login,password,active) VALUES (
'0','Mr','Admin','Test@test.fi','login',password','0')
*/





// function createDatabase($newDb)
// {
// 	// db settings
// 	$servername = "localhost";
// 	$username = "1029520";
// 	$password = "qwerty";	
// 	$dbname = "1029520";
// 	// $table = "organisations";
// 	
// 	$conn = mysqli_connect($servername, $username, $password, $dbname);
// 	if (!$conn) { die("DB connection failed: " . mysqli_connect_error()); }
// 
// 
// 		
// 	// Create database
// 	$sql = "CREATE DATABASE IF NOT EXISTS " . $newDb;
// 	if ($conn->query($sql) === TRUE) 
// 	{
// 	    echo "<br>Database created successfully<br>";
// 	} 
// 	else 
// 	{
// 	    echo "<br>Error creating database: " . $conn->error . '<br>';
// 	}
// 		
// 	$conn->close();
// }




?>