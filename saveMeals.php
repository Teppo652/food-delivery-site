<?php 
//include_once('dbConn.php'); 
include_once('functions.php'); 
$conn = getDBConn('noWelcomeText'); 
$today = getTodaysDate();

/*
// read restaurantId from url
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
// DELETE FROM meals WHERE restaurantId = 555

  $sql = "DELETE FROM meals WHERE restaurantId=" . $restaurantId;
  echo $sql;
  if ($conn->query($sql) === TRUE) {
    //$arr = array('id' => mysqli_insert_id($conn));
    //header('Content-Type: application/json');
    //echo json_encode($arr);
  } else {
    //echo 'error: '$conn -> error;  // remove in poroduction
  }

for($i=0; $i<count($dArr); $i++) {
  $ingredients = null;
  if($dArr[$i]["ingredients"] != '') { $ingredients = implode($dArr[$i]["ingredients"]); }

  $values = 
  $restaurantId . "," . 
  //$dArr[$i]["langId"] . "," . 
  $dArr[$i]["groupId"] . ",'" . 
  $dArr[$i]["name"] . "','" . 
  $dArr[$i]["descText"] . "','" . 
  $ingredients . "','" . 
  $dArr[$i]["price"] . "'"; 

  $sql = "INSERT INTO meals (restaurantId,groupId,name,descText,ingredients,price) VALUES (" . $values . ")";
  //echo $sql; 
  if ($conn->query($sql) === TRUE) {
    //$arr = array('id' => mysqli_insert_id($conn));
    //header('Content-Type: application/json');
    //echo json_encode($arr);
  } else {
    //echo 'error: '$conn -> error;  // remove in poroduction
  }
}

/*

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
*/
$conn->close();
?>