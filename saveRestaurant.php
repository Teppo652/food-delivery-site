<?php 
//include_once('dbConn.php'); 
include_once('functions.php'); 
$conn = getDBConn('noWelcomeText'); 

$country = $area1 = $area2 = $area3 = $area4 = $area5 = $coordsXY = $address = $phone = $listingImg = $outsideImg = $imgTagIds = $deliveryTime = $name = $avgStars = $totVotes = $priceLevel = $foodTypeIds = $minPurchase = $deliveryPrice = $bonus = $openingHoursString = $mapCoords = $paymentTime = $paymentTypeIds = NULL;

// ---------- if  all fields have values --------- 
$content = file_get_contents('php://input');
$d = json_decode($content, true);
$table = "restaurants";
$fields = "country,area1,area2,area3,area4,area5,coordsXY,address,phone,listingImg,outsideImg,imgTagIds,deliveryTime,name,avgStars,totVotes,priceLevel,foodTypeIds,minPurchase,deliveryPrice,bonus,openingHoursString,mapCoords,paymentTime,paymentTypeIds";

$values = "'"
$d["country"] . "','" . 
$d["area1"] . "','" . 
$d["area2"] . "','" . 
$d["area3"] . "','" . 
$d["area4"] . "','" . 
$d["area5"] . "','" . 
$d["coordsXY"] . "','" . 
$d["address"] . "','" . 
$d["phone"] . "','" . 
$d["listingImg"] . "','" . 
$d["outsideImg"] . "','" . 
$d["imgTagIds"] . "','" . 
$d["deliveryTime"] . "','" . 
$d["name"] . "','" . 
$d["avgStars"] . "','" . 
$d["totVotes"] . "','" . 
$d["priceLevel"] . "','" . 
$d["foodTypeIds"] . "','" . 
$d["minPurchase"] . "','" . 
$d["deliveryPrice"] . "','" . 
$d["bonus"] . "','" . 
$d["openingHoursString"] . "','" . 
$d["mapCoords"] . "','" . 
$d["paymentTime"] . "','" . 
$d["paymentTypeIds"] . "'"; 


// ---------- if not all fields have values --------- 
if (isset($_GET["country"]))
{
	if($_GET["country"] != null)            { $country = $_GET["country"]; }
	if($_GET["area1"] != null)              { $area1 = $_GET["area1"]; }
	if($_GET["area2"] != null)              { $area2 = $_GET["area2"]; }
	if($_GET["area3"] != null)              { $area3 = $_GET["area3"]; }
	if($_GET["area4"] != null)              { $area4 = $_GET["area4"]; }
	if($_GET["area5"] != null)              { $area5 = $_GET["area5"]; }
	if($_GET["coordsXY"] != null)           { $coordsXY = $_GET["coordsXY"]; }
	if($_GET["address"] != null)            { $address = $_GET["address"]; }
	if($_GET["phone"] != null)              { $phone = $_GET["phone"]; }
	if($_GET["listingImg"] != null)         { $listingImg = $_GET["listingImg"]; }
	if($_GET["outsideImg"] != null)         { $outsideImg = $_GET["outsideImg"]; }
	if($_GET["imgTagIds"] != null)          { $imgTagIds = $_GET["imgTagIds"]; }
	if($_GET["deliveryTime"] != null)       { $deliveryTime = $_GET["deliveryTime"]; }
	if($_GET["name"] != null)               { $name = $_GET["name"]; }
	if($_GET["avgStars"] != null)           { $avgStars = $_GET["avgStars"]; }
	if($_GET["totVotes"] != null)           { $totVotes = $_GET["totVotes"]; }
	if($_GET["priceLevel"] != null)         { $priceLevel = $_GET["priceLevel"]; }
	if($_GET["foodTypeIds"] != null)        { $foodTypeIds = $_GET["foodTypeIds"]; }
	if($_GET["minPurchase"] != null)        { $minPurchase = $_GET["minPurchase"]; }
	if($_GET["deliveryPrice"] != null)      { $deliveryPrice = $_GET["deliveryPrice"]; }
	if($_GET["bonus"] != null)              { $bonus = $_GET["bonus"]; }
	if($_GET["openingHoursString"] != null) { $openingHoursString = $_GET["openingHoursString"]; }
	if($_GET["mapCoords"] != null)          { $mapCoords = $_GET["mapCoords"]; }
	if($_GET["paymentTime"] != null)        { $paymentTime = $_GET["paymentTime"]; }
	if($_GET["paymentTypeIds"] != null)     { $paymentTypeIds = $_GET["paymentTypeIds"]; }
}


// -------------------------------------------------- 
$values = "'" . $country . "','" . $area1 . "','" . $area2 . "','" . $area3 . "','" . $area4 . "','" . $area5 . "','" . $coordsXY . "','" . $address . "','" . $phone . "','" . $listingImg . "','" . $outsideImg . "','" . $imgTagIds . "','" . $deliveryTime . "','" . $name . "','" . $avgStars . "','" . $totVotes . "','" . $priceLevel . "','" . $foodTypeIds . "','" . $minPurchase . "','" . $deliveryPrice . "','" . $bonus . "','" . $openingHoursString . "','" . $mapCoords . "','" . $paymentTime . "','" . paymentTypeIds . "'";
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
