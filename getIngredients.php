<?php 
include_once('functions.php'); 
$conn = getDBConn('noWelcomeText'); 

$langId = '-1';
$d = json_decode(file_get_contents('php://input'), true);

if($d["langId"] != '') { 	
	$langId = $d["langId"];
} 
if($langId == '-1') { echo 'langId missing'; exit;}

$sql = "SELECT id,groupId,name FROM ingredientNames WHERE langId = '" . $langId . "' ORDER BY orderId";
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