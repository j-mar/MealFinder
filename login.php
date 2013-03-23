<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href='http://fonts.googleapis.com/css?family=Kreon|Krona+One' rel='stylesheet' type'text/css' />
<title>MealFinder</title>
<link href="assets/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="main">
<?php include( 'includes/header.php' ); ?>
<?php include( 'includes/navigation.php' ); ?>

<?php
  mysql_connect("mysql12.000webhost.com", "a4446349_jmar", "banana1234");
  mysql_select_db( "a4446349_jmar" );
$message= $_GET['message'];
if( isset($_POST['submit']) )
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	$url = "index.php";
	$strSQL =
		"SELECT name, password,user_id
	 	FROM `User`
		WHERE email = '{$email}'
		AND password ='{$password}'
		";

	
$rs = mysql_query( $strSQL );


if(mysql_num_rows( $rs )==1)
{
	$row=mysql_fetch_array($rs);
	$user_id= $row['user_id'];
	$url = "index.php";
	setcookie('user_id',$user_id,time()+(60*60));
	header("Location: $url" );
}
else
{
	$message = "1";
	$url = "login.php?message=$message";
	header("Location: $url");
}	
}
if( isset($_POST['submit1']) )
{
	$new_user = $_POST['new_user'];
	$new_password = $_POST['new_password'];
	$email = $_POST['email'];
	$url = "index.php";
	$strSQL =
		"SELECT name, password
	 	FROM `User`
		WHERE email= '{$email}'
		";

	
$rs = mysql_query( $strSQL );

if(mysql_num_rows( $rs )==1)
{
    $message = "2";
	$url = "login.php?message=$message";
	header("Location: $url");
}
else
{
	$date = date("Y\-m\-d");
	$strSQL =
	"SELECT MAX(user_id)
	 FROM `User`";
	 $rs = mysql_query( $strSQL );
	 $row=mysql_fetch_array($rs);
	 $user_id= $row['MAX(user_id)']+1;
	 $strSQL =
	"INSERT INTO `User`(`user_id`,`password`,`email`,`name`,`join_date`)VALUES('{$user_id}','{$new_password}','{$email}','{$new_user}','{$date}')";
	$rs = mysql_query( $strSQL );
	$message = "3";
	$url = "login.php?message=$message&date={$date}";
	header("Location: $url");
}	
}


mysql_close();
?>

<?php
if( $message != 0 )
{
	echo '<div id="error" >';
	if( ($message==1) ){
		echo"We could not find a user matching your email and password. Please try again."	;
	}
	else if($message==2 ){
		echo"There is already a user with this email. Please try a different one."	;
	}
	else if($message==3 ){
		echo"Congratulations! You've successfully created an account. Please log in."	;
	}
	else if( $message==4 ){
		echo "You need to be logged in to add new recipes!";
	}
	echo '</div>';
}
?>
<div id="content">
<center>
<h1>Returning user? Log in!</h1>
  <form id="form1" name="form1" method="post" action="">
      <label>Email <input id="user_info" name="email" type="text"/></label><br />
      <label>Password <input id="user_info" name="password" type="password" /></label><br />
	  <input type="submit" value="Login" name="submit" id="submit"/>
      <br />
      
  </form>
  </center>
  </div>
  <div id="content">
  <center>
  <h1>New to MealFinder? Create a new account!</h1>
    <form id="form1" name="form1" method="post" action="">
     	<label>Email <input id="user_info" name="email" type="text"/></label><br />
			<label>Name <input id="user_info" name="new_user" type="text"/></label><br />
      <label>Password <input id="user_info" name="new_password" type="password"/></label><br />
	  <input type="submit" value="Register" name="submit1" id="submit"/>
      <br />
      
  </form>
  
  

<!--    <a href="search.php"
<div id="button" onclick="" style="float:none; width: 100px;">GO</div> -->
</center>
</div>
<?php include( 'includes/footer.php' ); ?>
</div>
</body>
</html>
