<?php 
//include_once('dbConn.php'); 
include_once('functions.php'); 
$conn = getDBConn('noWelcomeText'); 

$adminUserId = $country = $area1 = $area2 = $area3 = $area4 = $area5 = $coordsXY = $address = $phone = $email = $listingImg = $outsideImg = $imgTagIds = $deliveryTime = $name = $avgStars = $totVotes = $priceLevel = $foodTypeIds = $minPurchase = $deliveryPrice = $bonus = $openingHoursString = $postalCodes = $paymentTime = $paymentTypeIds = NULL;

// ---------- if  all fields have values --------- 
$content = file_get_contents('php://input');
$d = json_decode($content, true);
$table = "restaurants";
$fields = "adminUserId,country,area1,area2,area3,area4,area5,coordsXY,address,phone,email,listingImg,outsideImg,imgTagIds,deliveryTime,name,avgStars,totVotes,priceLevel,foodTypeIds,minPurchase,deliveryPrice,bonus,openingHoursString,postalCodes,paymentTime,paymentTypeIds";

$values = 
$d["adminUserId"] . ",'" . 
$d["country"] . "'," . 
$d["area1"] . "," . 
$d["area2"] . "," . 
$d["area3"] . "," .  
$d["area4"] . "," . 
$d["area5"] . ",'" . 
$d["coordsXY"] . "','" . 
$d["address"] . "','" . 
$d["phone"] . "','" . 
$d["email"] . "','" . 
$d["listingImg"] . "','" . 
$d["outsideImg"] . "','" . 
$d["imgTagIds"] . "'," . 
$d["deliveryTime"] . ",'" . 
$d["name"] . "'," . 
$d["avgStars"] . "," . 
$d["totVotes"] . "," . 
$d["priceLevel"] . ",'" . 
$d["foodTypeIds"] . "'," . 
$d["minPurchase"] . "," . 
$d["deliveryPrice"] . "," . 
$d["bonus"] . ",'" . 
$d["openingHoursString"] . "','" . 
$d["postalCodes"] . "'," . 
$d["paymentTime"] . ",'" . 
$d["paymentTypeIds"] . "'"; 


/*
// ---------- if not all fields have values --------- 
//if (isset($d["country"]))
//{
	
	if(isset($d["adminUserId"]))        { $adminUserId = $d["adminUserId"]; }
	if(isset($d["country"]))            { $country = $d["country"]; }
	if(isset($d["area1"]))              { $area1 = $d["area1"]; }
	if(isset($d["area2"]))              { $area2 = $d["area2"]; }
	if(isset($d["area3"]))              { $area3 = $d["area3"]; }
	if(isset($d["area4"]))              { $area4 = $d["area4"]; }
	if(isset($d["area5"]))              { $area5 = $d["area5"]; }
	if(isset($d["coordsXY"]))           { $coordsXY = $d["coordsXY"]; }
	if(isset($d["address"]))            { $address = $d["address"]; }
	if(isset($d["phone"]))              { $phone = $d["phone"]; }
	if(isset($d["email"]))              { $email = $d["email"]; }	
	if(isset($d["listingImg"]))         { $listingImg = $d["listingImg"]; }
	if(isset($d["outsideImg"]))         { $outsideImg = $d["outsideImg"]; }
	if(isset($d["imgTagIds"]))          { $imgTagIds = $d["imgTagIds"]; }
	if(isset($d["deliveryTime"]))       { $deliveryTime = $d["deliveryTime"]; }
	if(isset($d["name"]))               { $name = $d["name"]; }
	if(isset($d["avgStars"]))           { $avgStars = $d["avgStars"]; }
	if(isset($d["totVotes"]))           { $totVotes = $d["totVotes"]; }
	if(isset($d["priceLevel"]))         { $priceLevel = $d["priceLevel"]; }
	if(isset($d["foodTypeIds"]))        { $foodTypeIds = $d["foodTypeIds"]; }
	if(isset($d["minPurchase"]))        { $minPurchase = $d["minPurchase"]; }
	if(isset($d["deliveryPrice"]))      { $deliveryPrice = $d["deliveryPrice"]; }
	if(isset($d["bonus"]))              { $bonus = $d["bonus"]; }
	if(isset($d["openingHoursString"])) { $openingHoursString = $d["openingHoursString"]; }
	if(isset($d["postalCodes"]))          { $postalCodes = $d["postalCodes"]; }
	if(isset($d["paymentTime"]))        { $paymentTime = $d["paymentTime"]; }
	if(isset($d["paymentTypeIds"]))     { $paymentTypeIds = $d["paymentTypeIds"]; }
//}

$values = $adminUserId . ",'" . $country . "'," . $area1 . "','" . $area2 . "','" . $area3 . "','" . $area4 . "','" . $area5 . "','" . $coordsXY . "','" . $address . "','" . $phone . "','" . $email . "','" . $listingImg . "','" . $outsideImg . "','" . $imgTagIds . "','" . $deliveryTime . "','" . $name . "','" . $avgStars . "','" . $totVotes . "','" . $priceLevel . "','" . $foodTypeIds . "','" . $minPurchase . "','" . $deliveryPrice . "','" . $bonus . "','" . $openingHoursString . "','" . $mapCoords . "','" . $paymentTime . "','" . $paymentTypeIds . "'";
*/

$sql = "INSERT INTO " . $table . " (" . $fields . ") VALUES (" . $values . ")";
echo $sql; //exit;

if ($conn->query($sql) === TRUE) {
	$arr = array('id' => mysqli_insert_id($conn));
	header('Content-Type: application/json');
	echo json_encode($arr);
} else {
	echo $conn->error;  // remove in poroduction
}



$conn->close();
?>
