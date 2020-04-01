<?php 
//include_once('dbConn.php'); 
include_once('functions.php'); 
$conn = getDBConn('noWelcomeText'); 

// read from url

$id = '';
/*
$id = filter_input( INPUT_GET, "id", FILTER_SANITIZE_URL );
if($id == '') { echo "Error - someId missing!"; exit; }
*/

// OR read from postdata

/*
$content = file_get_contents('php://input');
$d = json_decode($content, true);
*/
//$sql = "SELECT country,area1,area2,area3,area4,area5,coordsXY,address,phone,listingImg,outsideImg,imgTagIds,deliveryTime,name,avgStars,totVotes,priceLevel,foodTypeIds,minPurchase,deliveryPrice,bonus,openingHoursString,mapCoords,paymentTime,paymentTypeIds FROM restaurants WHERE someId = $someId";




if($id == '') {
	$sql = "SELECT id, listingImg, imgTagIds, deliveryTime, name, avgStars, totVotes, priceLevel, foodTypeIds, minPurchase, deliveryPrice, bonus from restaurants";
} else {
  	$sql = "SELECT * from restaurants WHERE id = $id LIMIT 1";
}
$result = mysqli_query($conn, $sql);
if ($result === false) {
echo 0;
exit;
}


// ---------- pass DB object --------- 

$arr = array();
while($row = mysqli_fetch_assoc($result)){
    $arr[] = $row;
}
echo json_encode($arr);


// ---------- read each field --------- 
/*
$arr = array();
array_push($arr, array(
	'country' => $row['country'],
	'area1' => $row['area1'],
	'area2' => $row['area2'],
	'area3' => $row['area3'],
	'area4' => $row['area4'],
	'area5' => $row['area5'],
	'coordsXY' => $row['coordsXY'],
	'address' => $row['address'],
	'phone' => $row['phone'],
	'listingImg' => $row['listingImg'],
	'outsideImg' => $row['outsideImg'],
	'imgTagIds' => $row['imgTagIds'],
	'deliveryTime' => $row['deliveryTime'],
	'name' => $row['name'],
	'avgStars' => $row['avgStars'],
	'totVotes' => $row['totVotes'],
	'priceLevel' => $row['priceLevel'],
	'foodTypeIds' => $row['foodTypeIds'],
	'minPurchase' => $row['minPurchase'],
	'deliveryPrice' => $row['deliveryPrice'],
	'bonus' => $row['bonus'],
	'openingHoursString' => $row['openingHoursString'],
	'mapCoords' => $row['mapCoords'],
	'paymentTime' => $row['paymentTime'],
	'paymentTypeIds' => $row['paymentTypeIds']
	));
}
header('Content-Type: application/json');
echo json_encode($arr);
*/
?>