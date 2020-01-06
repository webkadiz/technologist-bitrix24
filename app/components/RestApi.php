<?php

namespace app\components;

use pl\core\{Config, Logger};

class RestApi
{

  static function makeRequest($method, $params)
  {
    $queryUrl = Config::get('bitrix_base_url') . '/rest/' . $method;
    $queryData = http_build_query($params);
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_POST => 1,
      CURLOPT_HEADER => 0,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $queryUrl,
      CURLOPT_POSTFIELDS => $queryData,
    ]);

    $result = json_decode(curl_exec($curl), true);
    curl_close($curl);

    return $result;
  }
}
