<?php 
$uid = $_GET['user_id'];
$signout = $_GET['signout'];
if( isset($uid) )
{
	setcookie( "user_id", $uid, time()+60*60*24 );
	header("Location: index.php" );
}

if( isset( $signout ) )
{
	setcookie( "user_id", "", time()-60*60*24 );
	header( "Location: index.php" );
}

?>
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
if( isset($_POST['submit']) )
{
	$query = $_POST['search_item'];
	$search_by = $_POST['category'];
	$url = "search.php?query=$query&search_by=$search_by";
	header("Location: $url" );
}
?>
<div id="content">
<center>
<p>&nbsp;</p>
<h1>
<script language="JavaScript">
<!--
var r_text = new Array ();
r_text[0] = "I have a craving for . . .";
r_text[1] = "I'm looking for . . .";
r_text[2] = "I would like to have . . .";
r_text[3] = "I feel like having . . .";
r_text[4] = "I'd like a recipe for . . .";
var i = Math.floor(5*Math.random())

document.write(r_text[i]);

//-->
</script>
</h1>
  <form id="form1" name="form1" method="post" action="">
      <input id="tb_search" name="search_item" type="text"/>&nbsp; <input type="submit" value="Go" name="submit" id="submit"/>
      <br />
    <label>
      Search By&nbsp;<select name="category" size="1">
        <option>Recipes</option>
        <option>Cuisine</option>
        <option>Ingredient</option>
      </select>
      </label>
      
  </form>

<p>&nbsp;</p>

<!--    <a href="search.php"
<div id="button" onclick="" style="float:none; width: 100px;">GO</div> -->
</center>
</div>
<?php include( 'includes/footer.php' ); ?>

</div>
</body>
</html>
