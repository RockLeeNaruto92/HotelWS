<?php
require_once "config/database.php";

function isEmpty($variable){
  return $variable == NULL || strlen($variable) == 0;
}

function isValidTimeFormat($time){
  return strtotime($time) != NULL;
}

// ok
function addNewHotel($id = NULL, $name = NULL, $star = 0, $province = NULL,
  $country = NULL, $address = NULL, $website = NULL, $phone = NULL,
  $total_rooms = 0, $cost = 0){
  // Check name
  if (isEmpty($name)) return 0; // "error_message" => "Name is not present.";

  // Check star
  if ($star <= 0) return 1; // "error_message" => "Star must be greater than 0"

  // check province, country, address
  if (isEmpty($province)) return 2; // "error_message" => "Province is not present"
  if (isEmpty($country)) return 3; // "error_message" => "Country is not present"
  if (isEmpty($address)) return 4; // "error_message" => "Address is not present"

  // check website and phone
  if (isEmpty($website)) return 5; // "error_message" => "Website is not present"
  if (isEmpty($phone)) return 6; // "error_message" => "Phone is not present"

  // Check total_rooms and cost
  if ($total_rooms <= 0) return 7; // "error_message" => "Total rooms must be greater than 0"
  if ($cost <= 0) return 8; // "error_message" => "Cost must be greater than 0"

  // Check id
  $db = new DatabaseConfig;
  $result = $db->existed("hotels", "id", $id);
  if ($result){
    unset($db);
    return 9; // "error_message" => "Hotel id is existed in database"
  }

  $query = "INSERT INTO hotels(id, name, star, province, country, address, website, phone, total_rooms, available_rooms, cost)";
  $query .= "VALUES ('$id', '$name', $star, '$province', '$country', '$address', '$website', '$phone', $total_rooms, $total_rooms, $cost)";

  $result = $db->query($query);
  unset($db);

  if ($result) return -1; // OK
  else return 10; // "error_message" => "Error on execution query"
}

// ok
function isExistedHotel($id = NULL){
  if (isEmpty($id)) return 0; // "error_message" => "Id is not present"

  $db = new DatabaseConfig;
  $result = $db->existed("hotels", "id", $id);
  unset($db);

  if ($result) return -1; // OK
  else return 1; // "error_message" => "Id is not exist in database"
}

// ok
function findByProvince($province = NULL){
  if (isEmpty($province)) return "Province is not present"; // "error_message" => "Province is not present"

  $db = new DatabaseConfig;
  $query = "SELECT * FROM hotels WHERE province = '$province'";
  $result = $db->query($query);
  unset($db);

  if (mysql_num_rows($result) == 0) return "Not exist any hotels";
  else {
    $data = array();
    while ($row = mysql_fetch_array($result)){
      $rowData = array();
      foreach (DatabaseConfig::$HOTELS as $value)
        $rowData[$value] = $row[$value];
      $data[] = $rowData;
    }
    return json_encode($data);
  }
}
?>
