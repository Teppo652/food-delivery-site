<?php 
include_once('functions.php'); 
$conn = getDBConn('noWelcomeText'); 

$id = '-1';
$d = json_decode(file_get_contents('php://input'), true);

if($d["restaurantId"] != '') { 	
	$id = $d["restaurantId"];
} 
if($id == '-1') { echo 'restaurantId missing'; exit;}

$sql = "SELECT * FROM restaurants WHERE id = " . $id . " LIMIT 1";

$result = mysqli_query($conn, $sql);
if ($result === false) {
	echo 0;
	exit;
}

$arr = array();
while($row = mysqli_fetch_assoc($result)){
    $arr[] = $row;
}
header('Content-Type: application/json');
echo json_encode($arr);
?>