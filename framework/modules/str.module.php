<?php

function strtocamel($str)
{
	$strParts = explode('_', $str);
	$resStr = array_shift($strParts);

	foreach ($strParts as $strPart) {
		$resStr .= ucfirst($strPart);
	}

	return $resStr;
}

function strtounder($str)
{
	$strChars = str_split($str);

	$index = 0;
	foreach ($strChars as $char) {
		if (ctype_upper($char)) {
			$str = substr($str, 0, $index) . '_' . strtolower($char) . substr($str, $index + 1);
			$index++;
		}
		$index++;
	}

	return $str;
}
