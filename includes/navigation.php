<div class="navigation">
<div id="button_nav" onclick="window.location='index.php'">HOME</div>
<div id="button_nav" onclick="window.location='search.php?query='">TOP RATED</div>
<div id="button_nav" onclick="window.location='add.php'">ADD NEW</div>

<?php
	
if(isset($_COOKIE['user_id']))
{
  mysql_connect("mysql12.000webhost.com", "a4446349_jmar", "banana1234");
  mysql_select_db( "a4446349_jmar" );
	$var1 = $_COOKIE['user_id'];
	$strSQL =
	"SELECT name
	FROM `User`
	WHERE user_id = '{$var1}'
	";
		$rs = mysql_query($strSQL);
	$row=mysql_fetch_array($rs);
	$display= $row['name'];
	$name= "Hi, {$display}";
	mysql_close();
	echo "<div id=\"button_nav\" style=\"float:right;\" onclick=\"window.location='index.php?signout=1'\">SIGN OUT</div>";
	echo "<div id=\"button_nav\" style=\"float:right;\" onclick=\"window.location='user.php'\">Hi, {$display}!</div>";
}
else
{
	echo "<div id=\"button_nav\" style=\"float:right;\" onclick=\"window.location='login.php'\">SIGN IN</div>";
}



?>
</div>
