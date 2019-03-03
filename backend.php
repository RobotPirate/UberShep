<?php

$url_params = [];


  $url_params["fare_id"] = "d30e732b8bba22c9cdc10513ee86380087cb4a6f89e37ad21ba2a39f3a1ba960";
  $url_params["product_id"] = "a1111c8c-c720-46c3-8534-2fcdd730040d";
  $url_params["start_latitude"] = 37.761492;
  $url_params["start_longitude"] = -122.423941;
  $url_params["end_latitude"] = 37.775393;
  $url_params["end_longitude"] = -122.417546;

  $hello = json_encode($url_params);

  echo "<pre>";
  print_r($hello);
  echo "</pre>";




$token = "JA.VUNmGAAAAAAAEgASAAAABwAIAAwAAAAAAAAAEgAAAAAAAAG8AAAAFAAAAAAADgAQAAQAAAAIAAwAAAAOAAAAkAAAABwAAAAEAAAAEAAAAE6FzNIvQuOn0g0x3UaFPPxsAAAAIRugH5XbakrGQLGVstF_zsD6nTsZl-iBh9_8xXVGQP0RxchVLAGJXcdRtX8E2zh6VlH_nNh_WHytCqZNLGD6pVEopoeWqZdwwETIy6Z3kO3pt9ZxXFjnTLCST7Ap0PDapvFU-jLUFPeRY07ADAAAAEqe_4qQyUw8j2OnbCQAAABiMGQ4NTgwMy0zOGEwLTQyYjMtODA2ZS03YTRjZjhlMTk2ZWU";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.uber.com/v1.2/requests");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $hello);

$headers = array();
$headers[] = "Authorization: Bearer ".$token;
$headers[] = "Accept-Language: en_US";
$headers[] = "Content-Type: application/json";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //For https
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//For https
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

echo "<pre>";
print_r($result);
echo "</pre>";
