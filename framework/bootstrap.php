<?php

spl_autoload_register(function($class) {

	$dirs = [
		"",
		'core/',
		'controllers/',
		'lib/',
		'models/'
	];
	foreach($dirs as $dir ) {
		if(file_exists(FRAMEWORK_DIR . $dir . $class . '.php')) {
			require FRAMEWORK_DIR . $dir . $class . '.php';
		}
	}

});





foreach(glob(FRAMEWORK_DIR . 'modules/*.module.php') as $path) {
	require $path;
}
