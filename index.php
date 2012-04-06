<?
include("class.php");
echo("Script Protector");
echo("<p>");
echo("<a href=index.php>Home</a><br>");
echo("<a href=index.php?page=create>Create new user</a><br>");
echo("<a href=index.php?ac=settings>Settings</a><br>");
echo("<a href=index.php?page=logout>Logout</a>");
echo("<br>");
if(isset($_GET[msg])){
	echo "<br><b>" . $_GET[msg] . "</b><br>";
}


if($_GET[page]==create){
	if($_GET[page]==create && $_GET[ac]==insert){
		mysql::insert($_POST[username], $_POST[email], $_POST[domain]);
	}
	else{
		echo('<table>
			<form action="index.php?page=create&ac=insert" method="post">
				<tr><td>Username:</td><td><input type="text" name="username" /></td></tr>
				<tr><td>Email:</td><td><input type="text" name="email" /></td></tr>
				<tr><td>Domain:</td><td><input type="text" name="domain" /></td></tr>
				<tr><td><input type="submit" value="Submit" /></td></tr>
		');
	}
}
elseif($_GET[page]==logout){
	session_destroy();
}
elseif($_GET[ac]==delete){
	$id = $_GET[usr];
	mysql::remove($id);
}
elseif($_GET[ac]==edit){
	if(!isset($_GET[sd])){
		mysql::pull_default($_GET[usr]);
	}
	elseif(isset($_GET[sd])){
		mysql::do_update($_POST[username], $_POST[email], $_POST[domain], $_POST[type], $_POST[dur]);
	}
}
elseif($_GET[ac]==ban) {
	if(!isset($_GET[sd])){
		mysql::pull_default_ban($_GET[usr]);
	}
	elseif(isset($_GET[sd])){
		mysql::do_update_ban($_POST[free], $_POST[reason], $_POST[dur]);
	}
}
elseif($_GET[ac]==settings) {
	if(!isset($_GET[sd])){
		mysql::pull_default_settings();
	}
	elseif(isset($_GET[sd])){
		mysql::do_update_settings($_POST[free], $_POST[message], $_POST[dur]);
	}
}
else{
	mysql::show_users();
}
