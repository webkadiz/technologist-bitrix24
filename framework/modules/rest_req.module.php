<?php

function rest_req($method, $params) {
	$queryUrl = 'https://b24-fmwacc.bitrix24.ru/rest/' . $method;
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