<?php
include("config.php");
class mysql {
	function connect(){
		mysql_connect("clientstestscrip.db.8757405.hostedresource.com","viewscriptprotec","Thisawesome123") or die(mysql_error());
		mysql_select_db("clientstestscrip");
	}
	function check_data($a, $b, $c, $d){
		$ban = "We are sorry, but your access has be cut for the following reason: ";
		$access = "We are sorry, but you do not have access to the following script. Please contact the seller you bought this from!";
		mysql::connect();
		// Check if script is offline		
		$query_check_active = mysql_query("SELECT * FROM active WHERE id = '1'") or die("Cannot run query");
		$active_status = mysql_fetch_array($query_check_active);
		$active = $active_status[active];
		$message = $active_status[message];
		if($active == 0) {
			// Check if user data exists
				$query = mysql_query("SELECT * FROM `Clients` WHERE `username` = '$b' AND `email` = '$c' AND domain = '$a' AND license = '$d'") or die(mysql_error());
				$total = mysql_fetch_row($query);
				if($total > 0) {
				// Grab messages from database				
				$query_check_ban = mysql_query("SELECT * FROM `Clients` WHERE `username` = '$b' AND `email` = '$c' AND domain = '$a' AND license = '$d'") or die("Cannot run query");
				$is_banned = mysql_fetch_array($query_check_ban);
				$banned = $is_banned[status];
				$bannedreason = $is_banned[reason];
				$free = "Free";
				if($banned == Free) {
					echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';

				}
				else {
					echo $ban . " " . $bannedreason;
				}
			}
			else {
				echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=protector.php?ac=' . $access . ' ">';
			}
		}
		else {
			echo '<h1> Server Offline </h1><br><br>' . $message;	
		}
	}
	function check_data_again($a, $b, $c, $d){
		mysql::connect();
		$ban = "We are sorry, but your access has be cut for the following reason: ";
		$access = "We are sorry, but you do not have access to the following script. Please contact the seller you bought this from!";
		// Check if script is offline
		$query_check_active = mysql_query("SELECT * FROM active WHERE id = '1'") or die("Cannot run query");
		$active_status = mysql_fetch_array($query_check_active);
		$active = $active_status[active];
		$message = $active_status[message];
		if($active == 1) {
			// Check if user data exists
			$query_if_exists = mysql_query("SELECT * FROM `Clients` WHERE `username` = '$b' AND `email` = '$c' AND domain = '$a' AND license = '$d'") or die(mysql_error());
			$is_there = mysql_fetch_row($query_if_exist);
			if($is_there > 0) {
				$query_check_ban = mysql_query("SELECT * FROM `Clients` WHERE `username` = '$b' AND `email` = '$c' AND domain = '$a' AND license = '$d'") or die("Cannot run query");
				$is_banned = mysql_fetch_array($query_check_ban);
				$banned = $is_banned[status];
				$bannedreason = $is_banned[reason];
				if($banned == Free) {
					return true;
				}
				else {
					echo $ban . " " . $bannedreason;
					return false;
				}
			}
			else {
				echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=protector.php?ac=' . $access . ' ">';
			}
		}
		else {
			echo $message;	
		}
	}
}
if(isset($_GET[ac])){
	echo $_GET[ac];
}
else {
	mysql::check_data($domain, $username, $email, $license);
}