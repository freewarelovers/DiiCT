<?php
#error_reporting(E_ALL | E_STRICT);

#die('hi!');

$dir_http = dirname(__FILE__);	// e.g. /home/diict/www
$dir_home = dirname($dir_http);	// e.g. /home/diict
define('HTTP_DIR', $dir_http);
define('HOME_DIR', $dir_home);

// General includes
require(HTTP_DIR.'/site.php');
require(HTTP_DIR.'/database.php');
require(HTTP_DIR.'/navigator.php');

Navigator::navigate();
Site::output();
?>
