<?php
	
class mysql {
	
	function connect() {
		include("config.php");
		mysql_connect($hostname, $username, $password) or die("Failed to Connect");
		mysql_select_db($db) or die("Failed to connect to database!");
	}
	
	function show_users() {
		mysql::connect();
		echo("<br><br>
			<table border='1' bordercolor='#000000' style='background-color:#FFFFFF' cellpadding='3' cellspacing='3'>
				<tr>
					<td>Username</td>
					<td>Email</td>
					<td>Domain</td>
					<td>License</td>
					<td>Status</td>
					<td>Action</td>
				</tr> ");
	$query = mysql_query("SELECT * FROM Clients") or die("Cannot run query");
		while($row = mysql_fetch_array($query)) {
			echo("
				<tr>
				    <td>$row[username]</td>
					<td>$row[email]</td>
					<td><a href=$row[domain]>$row[domain]</a></td>
					<td>$row[license]</td>
					<td>$row[status]</td>
					<td><a href=index.php?ac=delete&usr=$row[username]>Delete</a>|<a href=index.php?ac=edit&usr=$row[username]>Edit</a>|<a href=index.php?ac=ban&usr=$row[username]>Ban</a></td>
				</tr>
			");
		}
	}
	
	function insert($a, $b, $c){
		$tinyurl = generate::check();
		mysql::connect();
		if(mysql::check_for(username, $a, $b, $c)==false){
			if(mysql::check_for(email, $a, $b, $c)==false){
				if(mysql::check_for(domain, $a, $b, $c)==false){
				mysql_query("INSERT INTO Clients (username, email, domain, license) VALUES ('$a', '$b', '$c', '$tinyurl')");
				echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
				}	
			}
		}
	}
	function check_for($a, $b, $c, $d) {
		mysql::connect();
			if($a == username){
				$query = mysql_query("SELECT * FROM Clients WHERE username = '$b'") or die(mysql_error());
				$total = mysql_fetch_row($query);

				if($total > 0) {
					echo "username is already taken";
				}
				else {
					return false;
				}
			}
			if($a == email){
				$query = mysql_query("SELECT * FROM Clients WHERE email = '$c'") or die(mysql_error());
				$total = mysql_fetch_row($query);
				if($total > 0) {
					echo "Email is already in database";
				}
				else {
					return false;
				}
			}
			if($a == domain){
			$query = mysql_query("SELECT * FROM Clients WHERE domain = '$d'") or die(mysql_error());
			$total = mysql_fetch_row($query);
			if($total > 0) {
				echo "Domain is already in database";
			}
			else {
				return false;
			}
			}	
	}
	function remove($a){
		mysql::connect();
		mysql_query("DELETE FROM Clients WHERE username = '$a'") or die("Cannot run query!");
		echo '<br>' . $a . ' has been removed!';
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php?msg=' . $a . ' has been removed!">';
	}
	function pull_default($a) {
		mysql::connect();
		$query = mysql_query("SELECT * FROM Clients WHERE username = '$a'") or die("Cannot run query");
		$row = mysql_fetch_array($query);
			echo('<table>
				<form action="index.php?ac=edit&sd=go" method="post">
					<tr><td>username:</td><td><input type="text" name="username" value="' . $row[username] . '" /></td></tr>
					<tr><td>Email:</td><td><input type="text" name="email" value="' . $row[email] . '" /></td></tr>
					<tr><td>Domain:</td><td><input type="text" name="domain" value="' . $row[domain] . '" /></td></tr>
					<tr><td>Status:</td><td><input type="radio" name="type" value="Ban" />Banned <input type="radio" name="type" value="Free" />Free</td></tr>
					<input type="hidden" name="dur" value="' . $row[username] . '" />
					<tr><td><input type="submit" value="Submit" /></td></tr>
			');
		
	}
	function do_update($a, $b, $c, $d, $e){
		mysql::connect();
		mysql_query("UPDATE `Clients` SET `username` = '$a',`email` = '$b',`domain` = '$c',`status` = '$d' WHERE `username` = '$e'") or die(mysql_error()); 
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
	}
	function pull_default_ban($a) {
		mysql::connect();
		$query = mysql_query("SELECT * FROM Clients WHERE username = '$a'") or die("Cannot run query");
		$row = mysql_fetch_array($query);
			echo('<table>
				<form action="index.php?ac=ban&sd=go" method="post">
					<tr><td>Banned?:</td><td><input type="radio" name="free" value="Ban" />Banned  <input type="radio" name="free" value="Free" />Free</td></tr>
					<tr><td>Reason:</td><td><input type="text" name="reason" value="' . $row[reason] . '" /></td></tr>
					<input type="hidden" name="dur" value="' . $row[username] . '" />
					<tr><td><input type="submit" value="Submit" /></td></tr>
			');
		
	}
	function do_update_ban($a, $b, $c){
		mysql::connect();
		echo $a, $b, $c;
		mysql_query("UPDATE Clients SET `reason` = '$b', `status` = '$a' WHERE `username` = '$c'") or die(mysql_error()); 
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
	}
	function do_update_settings($a, $b, $c){
		mysql::connect();
		mysql_query("UPDATE `active` SET `active` = '$a',`message` = '$b' WHERE `id` = '$c'") or die(mysql_error()); 
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
	}
	function pull_default_settings() {
		mysql::connect();
		$query = mysql_query("SELECT * FROM active") or die("Cannot run query");
		$row = mysql_fetch_array($query);
			echo('<table>
				<form action="index.php?ac=settings&sd=go" method="post">
					<tr><td>Banned?:</td><td><input type="radio" name="free" value="1" />Offline  <input type="radio" name="free" value="0" />Online</td></tr>
					<tr><td>Reason:</td><td><input type="text" name="message" value="' . $row[message] . '" /></td></tr>
					<input type="hidden" name="dur" value="' . $row[id] . '" />
					<tr><td><input type="submit" value="Submit" /></td></tr>
			');
		
	}
}
class generate{
	function rands() {
		$rand = rand(0,9);
		return $rand;
	}
	function check() {
		$dis = generate::rands() . generate::rands() . generate::rands() . generate::rands() . generate::rands() . "-" .  generate::rands() . generate::rands() . generate::rands() . generate::rands() . generate::rands() . "-" .generate::rands() . generate::rands() . 		generate::rands() . generate::rands() . generate::rands() . "-" .  generate::rands() . generate::rands() . generate::rands() . generate::rands() . generate::rands() . "-" . generate::rands() . generate::rands() . generate::rands() . generate::rands() . generate::rands();

		mysql::connect();
		$sql = "SELECT * FROM Clients WHERE license = '$dis'";
		$query = mysql_query($sql);
		$results = mysql_fetch_row($query);
		if($results > 0){
				$string = generate::rands() . generate::rands() . generate::rands() . generate::rands() . generate::rands() . "-" .  generate::rands() . generate::rands() . generate::rands() . generate::rands() . generate::rands() . "-" .generate::rands() . generate::rands() . generate::rands() . generate::rands() . generate::rands() . "-" .  generate::rands() . generate::rands() . generate::rands() . generate::rands() . generate::rands() . "-" . generate::rands() . generate::rands() . generate::rands() . generate::rands() . generate::rands();
				return $string;
		}
		else {
			return $dis;
		}
	}	
}