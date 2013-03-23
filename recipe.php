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

$r_id = $_GET['recipe_id'];
$r_query=
		"SELECT DISTINCT *
		FROM `Recipe`
		WHERE recipe_id = $r_id";
$i_query = 
		"SELECT DISTINCT *
		FROM `RecipeHasIngredient`
		WHERE recipe_id = $r_id";
		
$r_result = mysql_query( $r_query );
$r_row = mysql_fetch_array( $r_result );
$name = $r_row['name'];
$time = $r_row['cook_time'];
$difficulty = $r_row['difficulty'];
$directions = $r_row['directions'];
$avg_rating = $r_row['avg_rating'];
$type = $r_row['type_of_food'];

$i_result = mysql_query( $i_query );
$num_ingr = mysql_num_rows( $i_result );


$uid = $_COOKIE['user_id'];
$query_like = "SELECT * FROM `Likes` WHERE `user_id` = {$uid} AND `recipe_id` = {$r_id}";
$rs = mysql_query( $query_like );
$user_liked = false;
if( mysql_num_rows( $rs ) > 0 )
{
	$user_liked = true;
}

 if( isset($_POST['like']) )
 {
	 if( $user_liked == false )
	 {
		 $query_like = "INSERT INTO `Likes`(`user_id`,`recipe_id`)VALUES('{$uid}','{$r_id}')";

	 }
	 else
	 {
		 $query_like = "DELETE FROM `Likes` WHERE `user_id` = {$uid} AND `recipe_id` = {$r_id}";
	 }
	mysql_query( $query_like );
	header('Location: '.$_SERVER['PHP_SELF']."?recipe_id={$r_id}" );
	
}
if( isset($_POST['comment']) )
 {
	$comment_text=$_POST['comment_text'];
	$date = date("Y\-m\-d");
	 $strSQL =
	"INSERT INTO `CommentsOn`(`user_id`,`recipe_id`,`comment_text`,`date_commented`)VALUES('{$uid}','{$r_id}','{$comment_text}', '{$date}')";
	$rs = mysql_query( $strSQL );
	header('Location: '.$_SERVER['PHP_SELF']."?recipe_id={$r_id}" );
}
	$uid = $_COOKIE['user_id'];
	$rid = $r_id;
	$query_rate = "SELECT * FROM `Rating` WHERE `user_id` = {$uid} AND `recipe_id` = {$rid}";
$rs = mysql_query($query_rate);
$rate_rs = $rs;
if( isset($_POST['rate'] ) && $_POST['rating'] != 0 )
{
	$rating = $_POST['rating'];

	

	if( mysql_num_rows($rs) > 0 )
	{
		// User already rated, update rating
		$query_rate = "UPDATE `Rating` SET `rating`={$rating} WHERE `user_id` = {$uid} AND `recipe_id` = {$rid}";
	}
	else
	{
		// User hasn't rated yet, insert
		$query_rate = "INSERT INTO `Rating` (`user_id`,`recipe_id`,`rating`) VALUES ( {$uid}, {$rid}, {$rating} )";
		
	}
	mysql_query($query_rate);
	
	
	// Update average
	$query_rate = "UPDATE `Recipe` SET `avg_rating`=(SELECT AVG(rating) FROM `Rating` WHERE `recipe_id` = {$rid}) WHERE `recipe_id` = {$rid}";
	mysql_query($query_rate);
	
	header('Location: '.$_SERVER['PHP_SELF']."?recipe_id={$r_id}" );
}
?>
<div id="content">
<h1><?php echo "$name" ?>
<div style="float:right;">

<?php 
	if( isset( $_COOKIE['user_id'] ) )
	{
		echo '<form id="form1" name="form1" method="post" action="">';
		if( $user_liked == false )
		{
			// if user doesn't like this recipe
			echo '<input type="submit" value="Like This!" name="like" id="button"/>';
		}
		else
		{
			// else if user likes recipe
			echo '<input type="submit" value="Liked :)" name="like" id="button"/>';
		}
		echo '</form>';
	}
	else
	{
		echo '<div id="button" onclick="window.location=\'login.php\'">Sign in to like this recipe</div>';
	}
?>
</div>
</h1>
  <p>
<?php echo "<b>Cuisine:</b> $type &emsp; | &emsp;
						<b>Difficulty:</b> $difficulty &emsp; | &emsp; 
						<b>Cooking time:</b> $time &emsp; | &emsp;
						<b>Average Rating:</b> " ;
		if( $avg_rating == 0 )
		{
			echo "Not yet rated";
		}
		else
		{
			echo number_format( $avg_rating, 2 );
		}
						?>
                            
</p>

<h2>Ingredients</h2>
<?php
if( $num_ingr > 0 )
{
	echo "<table class=\"results\">";
	for( $i = 0; $i < $num_ingr; $i++ )
	{
		$i_row = mysql_fetch_array( $i_result );
		echo "<tr>";
		echo "<td>{$i_row['quantity']}</td>";
		echo "<td>{$i_row['ingr_name']}";
		if( strcmp($i_row['note'], 0) != 0)
		{
			echo ", {$i_row['note']}";
		}
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";
}
else
{
	echo "<p>Sorry, we could not find any ingredients for this recipe.</p>";
}
?>

<h2>Directions</h2>
<p>
<?php 
$output = str_replace( "\n", "\n\n", $directions );
$output = nl2br( $output );
echo "{$output}" ?></p>
  

</div>
<div id="content2">
<div id="content_left">
<h3>Add your comment</h3>
<?php
if( isset( $_COOKIE['user_id'] ) )
	{
	echo '<form id="form1" name="form1" method="post" action="">
      <textarea cols="40" rows="3" name="comment_text" id="directions"></textarea><br/>
	  <input type="submit" value="Submit" name="comment" id="button"/>
      <br />    
  </form>';
	}
	else
	{
		echo '&emsp;&emsp;<b><u><a href="login.php">Log in</a></u></b> to comment on this recipe!';
	}

?>
   
</div>
<div id="content_right">
<h3>Rate this recipe</h3>
<?php
if( isset( $_COOKIE['user_id'] ) )
{
	if(mysql_num_rows($rate_rs) > 0 )
	{
		$rate_row = mysql_fetch_array($rate_rs);
		$my_rating = $rate_row['rating'];
		echo "You gave this recipe a <b>{$my_rating}</b>.";
	}
	else
	{
		echo "You haven't rated this recipe yet.";
	}
	// display current rating
echo '<form id="form_rate" name="form_rate" method="post" action="">
<select name="rating">
<option value="0"></option>
<option value="1">1 - Horrific</option>
<option value="2">2 - Off-putting</option>
<option value="3">3 - Adequate</option>
<option value="4">4 - Enjoyable</option>
<option value="5">5 - Fantastic</option>
</select>
<br/><br/>
<input type="submit" value="Rate" name="rate" id="button" />
</form>';
}
	else
	{
		echo '&emsp;&emsp;<b><u><a href="login.php">Log in</a></u></b> to rate this recipe!';
	}
?>
</div>
</div>
<div id="content">
<h3>Comments</h3>

<?php
$query_comments = "SELECT User.name, CommentsOn.comment_text, CommentsOn.date_commented FROM `CommentsOn`, `User` WHERE CommentsOn.recipe_id={$r_id} AND CommentsOn.user_id = User.user_id";
$rs = mysql_query($query_comments);
if( mysql_num_rows( $rs) > 0 )
{
	echo "<ul>";
	for( $i = 0; $i < mysql_num_rows($rs); $i++ )
	{
		$row = mysql_fetch_array($rs);
		echo "<li>\"{$row['comment_text']}\"<br/>{$row['name']},&emsp;{$row['date_commented']}<br/>&nbsp;</li>";
	}
	echo "</ul>";
}
else
{
	echo "There are no comments for this recipe.";
}

?>
</div>

<?php include( 'includes/footer.php' ); ?>
</div>
</body>
</html>
