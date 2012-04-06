<?php
/*
Author: Nicholas Young
Domain: Http://www.hackmuch.com/
Version: 1.0
*/
/*
=======================================
				READ ME
1.) Fill in the following values
=======================================
Add:

include("protector.php");
include("config.php");
$check_data = check_data_two($domain, $username, $email, $license);
if(!$check_data == true) {
	echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php?ac=' . $access . ' >';
}

to any file that you want protected
*/

$domain = "http://www.hackmuch.com";
$username = "Noid";
$email = "noid@hackmuch.com";
$license = "80993-97323-61631-20935-53706";



?>