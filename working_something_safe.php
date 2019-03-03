<?php

  function call_uber_api($OATH_Token, $REQUEST_TYPE, $Uber_API_Endpoint, $url_params) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $Uber_API_Endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $REQUEST_TYPE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($url_params));

    $headers = array();
    $headers[] = "Authorization: Bearer ".$OATH_Token;
    $headers[] = "Accept-Language: en_US";
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //For https
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //For https
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);

    return $result;
  }

  $token = "";

  // 0 - Delete current trip
  $url_params = [];
  $request_estimate_result = json_decode(call_uber_api($token, "DELETE", "https://sandbox-api.uber.com/v1.2/requests/current", $url_params), TRUE);
  // echo "Delete (Current) Trip<br /><br />";

  // 1 - Estimate a trip
  $url_params = [];
  $url_params["start_latitude"] = 34.139051;
  $url_params["start_longitude"] = -118.122951;
  $url_params["end_latitude"] = 34.021024;
  $url_params["end_longitude"] = -118.291579;

  $request_estimate_result = json_decode(call_uber_api($token, "POST", "https://sandbox-api.uber.com/v1.2/requests/estimate", $url_params), TRUE);
  $fare_id = $request_estimate_result['fare']['fare_id'];

  // echo "Estimates Trip";
  // echo "<pre>";
  // print_r($request_estimate_result);
  // echo "</pre>";

  // 2 - Create Request
  $url_params = [];
  $url_params["fare_id"] = $fare_id;
  $url_params["start_latitude"] = 34.139051;
  $url_params["start_longitude"] = -118.122951;
  $url_params["end_latitude"] = 34.021024;
  $url_params["end_longitude"] = -118.291579;

  $request_result = json_decode(call_uber_api($token, "POST", "https://sandbox-api.uber.com/v1.2/requests", $url_params), TRUE);
  $request_id = $request_result['request_id'];

  // echo "Creates Trip";
  // echo "<pre>";
  // print_r($request_result);
  // echo "</pre>";

  // 3 - Current Trip
  $url_params = [];
  $request_current_result = json_decode(call_uber_api($token, "GET", "https://sandbox-api.uber.com/v1.2/requests/current", $url_params), TRUE);

  // 4
  $trip_details = [];
  $trip_details['latitude'] = $request_current_result['pickup']['latitude'];
  $trip_details['longitude'] = $request_current_result['pickup']['longitude'];

  header("Content-Type: application/json");
  echo json_encode($trip_details);

  // echo "Show Curent Trip";
  // echo "<pre>";
  // print_r($request_current_result);
  // echo "</pre>";
  // echo "<br />";
  // echo "<br />";
  // echo "Pickup Latitude : " . $request_current_result['pickup']['latitude'];
  // echo "<br />";
  // echo "Pickup Longitude : " . $request_current_result['pickup']['longitude'];
