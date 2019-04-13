<?php


function get_src($filename) {
	$ext = end(explode('.', $filename));
	if($ext === 'js') return JS_DIR . $filename;
	elseif(
		 $ext === 'png' 
	|| $ext === 'jpg' 
	|| $ext === 'jpeg' 
	|| $ext === 'gif' 
	|| $ext === 'svg') return IMG_DIR . $filename;
}