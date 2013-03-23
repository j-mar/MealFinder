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
//mysql_connect("mysql.eecs.ku.edu", "nalmadan", "Uu5X6R7y");
  mysql_connect("mysql12.000webhost.com", "a4446349_jmar", "banana1234");
mysql_select_db( "a4446349_jmar" );

$query = $_GET['query'];
$search_by = $_GET['search_by'];

		$var1= $_COOKIE['user_id'];
		$strSQL =
		"SELECT name,email
	 	FROM `User`
		WHERE user_id = '{$var1}'
		";
	    $user_result= mysql_query($strSQL);
		//$row=mysql_fetch_array($rs);
		//$display= $row['name'];
		//$name= {$display};
	
		$strSQL =
		"SELECT  r.name, r.recipe_id
	 	FROM `Recipe` r,`Likes` l
		WHERE r.recipe_id= l.recipe_id
		AND user_id = '{$var1}'
		";
	    $likes = mysql_query($strSQL);
		//$row=mysql_fetch_array($rs);
		//$display= $row['email'];
		//$name= {$display};
		
		$strSQL =
		"SELECT  r.name, r.recipe_id
	 	FROM `Recipe` r,`Creates` c
		WHERE r.recipe_id= c.recipe_id
		AND user_id = '{$var1}'
		";
	    $create= mysql_query($strSQL);
		//$row=mysql_fetch_array($rs);
		//$display= $row['email'];
		//$name= {$display};




//$rs = mysql_query( $strSQL );

//$numResults = mysql_num_rows( $rs );
//$numResults = mysql_num_rows( $rs );
//$numResults = mysql_num_rows( $rs );

 ?>
<div id="content">
<h1>My Profile</h1>
<? 


		$row = mysql_fetch_array($user_result);
		//$row=mysql_fetch_array($rs);
		$display= $row['name'];
		$display2= $row['email'];
		//$name= {$display};
		echo "<p><b>Name:</b> {$display}</p>";
		echo "<p><b>Email:</b> {$display2}</p>";
		?>
        </div>
        <div id="content_left">
<h3>Recipes you've liked</h3>
<ul>
<?php
if( mysql_num_rows($likes) > 0 )
{
	for( $i = 0; $i < mysql_num_rows($likes); $i++ )
	{
		$row = mysql_fetch_array($likes);
		//$row=mysql_fetch_array($rs);
		$name= $row['name'];
		//$name= {$display};
	    echo "<li><a href=\"recipe.php?recipe_id={$row['recipe_id']}\">{$row['name']}</a></li>";
	}
}
else
{
	echo "<li>You haven't liked anything yet. :(</li>";
}
?>
</ul>
</div>
<div id="content_right">

<h3>Recipes you've created</h3>
<ul>
<?php
if( mysql_num_rows($create) > 0 )
{
	for( $i = 0; $i < mysql_num_rows($create); $i++ )
	{
		$row = mysql_fetch_array($create);
		//$row=mysql_fetch_array($rs);
		$name= $row['name'];
		//$name= {$display};
	    echo "<li><a href=\"recipe.php?recipe_id={$row['recipe_id']}\">{$row['name']}</a></li>";
	}
}
else
{
	echo "<li>You haven't added any recipes. :(</li>";
}
?>
</ul>
</div>
<?php
mysql_close();
?>


<?php include( 'includes/footer.php' ); ?>

</div>

</body>
</html>
