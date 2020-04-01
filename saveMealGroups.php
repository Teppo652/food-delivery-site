<?php 
include_once('functions.php'); 
$conn = getDBConn('noWelcomeText'); 

// read restaurantId from url
/*
$restaurantId = "-1";
if (isset($_GET['rId']))
{
  $restaurantId = filter_input( INPUT_GET, 'rId', FILTER_SANITIZE_URL );
}
if($restaurantId == '-1') { echo 'restaurantId missing'; exit;}
*/

// read data
$id = '-1';
$dArr = json_decode(file_get_contents('php://input'), true);

// read restaurantId from first item
$restaurantId = $dArr[0]["restaurantId"];

// delete existing in DB
// DELETE FROM mealGroups WHERE restaurantId = 555
	$sql = "DELETE FROM mealGroups WHERE restaurantId=" . $restaurantId;
	if ($conn->query($sql) === TRUE) {
		//$arr = array('id' => mysqli_insert_id($conn));
		//header('Content-Type: application/json');
		//echo json_encode($arr);
	} else {
		//echo 'error: '$conn -> error;  // remove in poroduction
	}

for($i=0; $i<count($dArr); $i++) {
	$values = 
	$dArr[$i]["restaurantId"] . "," . 
	$dArr[$i]["langId"] . ",'" . 
	$dArr[$i]["name"] . "'," . 
	$dArr[$i]["orderId"]; 

	$sql = "INSERT INTO mealGroups (restaurantId,langId,name,orderId) VALUES (" . $values . ")";
	if ($conn->query($sql) === TRUE) {
		//$arr = array('id' => mysqli_insert_id($conn));
		//header('Content-Type: application/json');
		//echo json_encode($arr);
	} else {
		//echo 'error: '$conn -> error;  // remove in poroduction
	}
}
/*
	$sqlArr.push("(" . $values . ")");
}

if ($conn->query($sql . implode(",", $sqlArr)) === TRUE) {
	*/

	

//echo $temp; // 1 1 Alkupalat 1 2 1 Pääruoat 2 3 1 Jälkiruoat 3
//exit;

/*
if($d["restaurantId"] != '') { 	
	$id = $d["restaurantId"];
} 
if($id == '-1') { echo 'restaurantId missing'; exit;}
*/
// KESKEN!!!!!!!!!!


/*
$restaurantId = $langId = $name = $orderId = NULL;

// ---------- if  all fields have values --------- 
$table = "XXXXXX";
$fields = "restaurantId,langId,name,orderId";

$values = "'"
$d["id"] . "','" . 
$d["langId"] . "','" . 
$d["name"] . "','" . 
$d["orderId"] . "'"; 


// ---------- if not all fields have values --------- 
//if (isset($_GET["restaurantId"]))
//{
	//if($_GET["restaurantId"] != null) { $restaurantId = $_GET["restaurantId"]; }
	if($_GET["id"] != null)       	  { $langId = $_GET["id"]; }
	if($_GET["langId"] != null)       { $langId = $_GET["langId"]; }
	if($_GET["name"] != null)         { $name = $_GET["name"]; }
	if($_GET["orderId"] != null)      { $orderId = $_GET["orderId"]; }
//}


// -------------------------------------------------- 
$values = "'" . $restaurantId . "','" . $langId . "','" . $name . "','" . orderId . "'";
$sql = "INSERT INTO " . $table . " (" . $fields . ") VALUES (" . $values . ")";

if ($conn->query($sql) === TRUE) {
	$arr = array('id' => mysqli_insert_id($conn));
	header('Content-Type: application/json');
	echo json_encode($arr);
} else {
	echo 'error: '$conn -> error;  // remove in poroduction
}




header('Content-Type: application/json');
echo json_encode($arr);
*/
?>