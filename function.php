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

// ok
function addNewContract($hotel_id = NULL, $customer_id_number = NULL, $company_name = NULL,
  $company_address = NULL, $company_phone = NULL, $booking_rooms = 0, $check_in_date = NULL, $check_out_date = NULL,
  $payment_method = NULL){
  // Check $customer_id_number
  if (isEmpty($customer_id_number)) return 0; // "error_message" => "Customer id number is not present"

  // Check $company_name, $company_address, $company_phone
  if (isEmpty($company_name)) return 1; // "error_message" => "Company name is not present"
  if (isEmpty($company_address)) return 2; // "error_message" => "Company adress is not present"
  if (isEmpty($company_phone)) return 3; // "error_message" => "Company phone is not present"

  // check $check_in_date, $check_out_date
  if (isEmpty($check_in_date)) return 4; // "error_message" => "Check in date is not present"
  if (isEmpty($check_out_date)) return 5; // "error_message" => "Check out date is not present"
  if (!isValidTimeFormat($check_in_date)) return 6; // "error_message" => "Check in date have invalid time format"
  if (!isValidTimeFormat($check_out_date)) return 7; // "error_message" => "Check out date have invalid time format"

  // Check $payment_method
  if (isEmpty($payment_method)) return 8; // "error_message" => "Payment method is not present"

  // check $booking_rooms
  if ($booking_rooms == 0) return 9; // "error_message" => "Booking rooms number must be greater than 0"

  // Check $hotel_id
  $db = new DatabaseConfig;
  $result = $db->existed("hotels", "id", $hotel_id);
  if (!$result){
    unset($db);
    return 10; // "error_message" => "Hotel id is not existed in database"
  }

  // Check booking_room is available
  if ($result["available_rooms"] < $booking_rooms){
    unset($db);
    return 11; // "error_message" => "Available room is not enough"
  }

  $available_rooms = $result["available_rooms"] - $booking_rooms;
  $total_money = $booking_rooms * $result["cost"];
  $status = 0;
  $created_time = date("Y/m/d H:m", time());

  $query = "INSERT INTO contracts(hotel_id, customer_id_number, company_name, company_address, company_phone, booking_rooms, check_in_date, check_out_date, status, payment_method, created_time, total_money)";
  $query .= "VALUES ('$hotel_id', '$customer_id_number', '$company_name', '$company_address', '$company_phone', '$booking_rooms', '$check_in_date', '$check_out_date', '$status', '$payment_method', '$created_time', '$total_money')";

  $result = $db->query($query);

  if ($result) {
    $query = "UPDATE hotels SET available_rooms = $available_rooms WHERE id = '$hotel_id'";
    $db->query($query);
    unset($db);
    return -1; // ok
  }

  unset($db);
  return 12; // "error_message" => "Error on execution query"
}

// checking
function checkRoomAvailable($hotel_id){
  if (isEmpty($hotel_id)) return -1; // "error_message" => "Hotel id is not present"

  $db = new DatabaseConfig;
  $result = $db->existed("hotels", "id", $hotel_id);
  unset($db);

  if ($result)
    if ($result["available_rooms"] > 0) return 1;
    else return 0;
  else return -2; // "error_message" => "Hotel id is not existed in database"
}
?>
