<?php 
include_once('functions.php'); 
$conn = getDBConn('','noWelcomeText'); 
$email = $password = $id = $remember = '';
$table = "users";


$id = '-1';
//echo 'DATA:' . file_get_contents('php://input');
// {"email":{"email":"teppo.testaaja69@gmail.com","password":"123qweQWE","remember":false}}<br />
/*
if($d["restaurantId"] != '') { 	
	$id = $d["restaurantId"];
} 
*/

$d = json_decode(file_get_contents('php://input'), true);


if($d["email"] != '') { $email = $d["email"]; } 
if($d["password"] != '') { $password = $d["password"]; } 
if($d["remember"] != '') { $remember = $d["remember"]; } 


if($email == '') { echo 'email missing'; exit;}
if($password == '') { echo 'password missing'; exit;}
if($remember == '') { echo 'remember missing'; exit;}

/*
if( isset($d["id"]) && !empty ($d["id"]) && $d["id"] != '-1') {
    $id = (int)(simple_crypt($d["id"], 'd')); // user id from remember
    $remember = '1';
} else { 
    $email = $d["email"];
    $password = $d["password"];
    $remember = $d["remember"];
}
*/
 // SELECT * FROM users WHERE id = -1 LIMIT 1[]
/*
if($id != '') {
    $sql = "SELECT * FROM $table WHERE id = $id LIMIT 1";
} else { */
    $sql = "SELECT * FROM $table WHERE email = '$email' AND password = '$password' LIMIT 1";    
//}
//echo $sql;

$result = mysqli_query($conn, $sql);
if ($result === false) { 
	echo 0; // USE THIS FOR ALL PHP FILES!!
	exit;
}
$arr = array();



while($row = mysqli_fetch_assoc($result)){
    $arr[] = $row;
}
/*
while($row = mysqli_fetch_assoc($result)) {
	if($remember == '1') { $remember = simple_crypt($row['id'], 'e'); } else { $remember = ''; }
	//arr[] = $row;
	array_push($arr, array(
		'id'  		=> $row['id'],
		'houseId'  	=> $row['houseId'],
		'isAdmin'  	=> $row['isAdmin'],
		'name'  	=> $row['name'],
		'email'  	=> $row['email'],
		'password'  => '',
		'aptNumber' => $row['aptNumber'],
		'remember'  => $remember
		)); 
}
*/

header('Content-Type: application/json');
echo json_encode($arr);



/*
function simple_crypt( $str, $action = 'e' ) {
    $secret_key = '234g7n6GsdhHDrbpwS05730w9';
    $secret_iv = 'HDrbpw234gGsd7n6GsdhS05Gs';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    if( $action == 'e' ) {
        // encrypt
        $output = base64_encode( openssl_encrypt( $str, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        // decrypt
        $output = openssl_decrypt( base64_decode( $str ), $encrypt_method, $key, 0, $iv );
        //$output = 'decrypt gives error...';
    } else if( $action == 'e512' ) {
        $output = crypt($str,'$6$rounds=5000$234g7n6GsdhHDrbpwS0573$');
    } 
    //echo "<br>Encrypted length of $str is: " . strlen($output);
    return $output;
}
*/
?>