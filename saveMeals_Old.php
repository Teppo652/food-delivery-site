<?php 
//include_once('dbConn.php'); 
include_once('functions.php'); 
$conn = getDBConn('noWelcomeText'); 
$today = getTodaysDate();

$restaurantId = $groupId = $name = $descriptionText = $ingredientIds = $price = NULL;

// ---------- if  all fields have values --------- 
$content = file_get_contents('php://input');
$d = json_decode($content, true);
$table = "meals";
$fields = "restaurantId,groupId,name,descriptionText,ingredientIds,price";

$values = "'"
$d["restaurantId"] . "','" . 
$d["groupId"] . "','" . 
$d["name"] . "','" . 
$d["descriptionText"] . "','" . 
$d["ingredientIds"] . "','" . 
$d["price"] . "'"; 


// ---------- if not all fields have values --------- 
if (isset($_GET["restaurantId"]))
{
  if($_GET["restaurantId"] != null)    { $restaurantId = $_GET["restaurantId"]; }
  if($_GET["groupId"] != null)         { $groupId = $_GET["groupId"]; }
  if($_GET["name"] != null)            { $name = $_GET["name"]; }
  if($_GET["descriptionText"] != null) { $descriptionText = $_GET["descriptionText"]; }
  if($_GET["ingredientIds"] != null)   { $ingredientIds = $_GET["ingredientIds"]; }
  if($_GET["price"] != null)           { $price = $_GET["price"]; }
}


// -------------------------------------------------- 
$values = "'" . $restaurantId . "','" . $groupId . "','" . $name . "','" . $descriptionText . "','" . $ingredientIds . "','" . price . "'";
$sql = "INSERT INTO " . $table . " (" . $fields . ") VALUES (" . $values . ")";

if ($conn->query($sql) === TRUE) {
  $arr = array('id' => mysqli_insert_id($conn));
  header('Content-Type: application/json');
  echo json_encode($arr);
} else {
  echo 'error: '$conn -> error;  // remove in poroduction
}

$conn->close();
?>