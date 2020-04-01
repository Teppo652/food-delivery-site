
<?php
include_once('functions.php'); 
$conn = getDBConn('','noWelcomeText'); 
$email = $password = '';
// https://stuffonaut.com/laundrier/saveUser.php?action=save&houseId=1&name=Teppo
$content = file_get_contents('php://input');
$d = json_decode($content, true);

if($d["email"] != '') { $email = $d["email"]; } 
if($d["password"] != '') { $password = $d["password"]; } 


if($email == '') { echo 'email missing'; exit;}
if($password == '') { echo 'password missing'; exit;}

// check if email exists already
// not in use yet as Register.vue can not recover after returning userExists
/*
if(isset($d["email"])) { 
	$email = $d["email"];
	$sql1 = "SELECT id FROM users WHERE email = '" . $email . "' LIMIT 1";
	$result = mysqli_query($conn, $sql1); 
	if ($result->num_rows > 0) {	
		$arr = array('id' => 'userExists');
		header('Content-Type: application/json');
		echo json_encode($arr);
		exit;  
	}
}
*/

$table = "users";
$fields = "email,password";

/*

Full texts	
id
name
email
phone
password
address
coordsXY
city
doorCode
joinedDate
totOrders
defaultRestaurantIds

Edit Edit
Copy Copy
Delete Delete
1
Teppo
teppo.testaaja69@gmail.com
0405556677
123qweQWE
Omakatu 1
NULL
Stockholm
5
NULL
NULL
NULL
*/
// email   simple_crypt($d["adminUserId"], 'e')
// password  simple_crypt($d["adminUserId"], 'e')
/*
$values = "" . 
$d["email"] 	. "','" . 
$d["password"]  . "'";
*/
$values = "'" . $d["email"] . "','" . $d["password"]  . "'";

//$values = $houseId . "," . $isAdmin . ",'" . $name . "','" . $email . "','" . $password . "','" . $aptNumber . "'";
$sql = "INSERT INTO " . $table . " (" . $fields . ") VALUES (" . $values . ")";


if ($conn->query($sql) === TRUE) {
	//if($remember == '1') { $remember = simple_crypt(mysqli_insert_id($conn), 'e'); }
	$arr = array('id' => mysqli_insert_id($conn));
	header('Content-Type: application/json');
	echo json_encode($arr);
} else {
	echo 'error';
}

//echo $sql;
$conn->close();      
?>