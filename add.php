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
if( !isset($_COOKIE['user_id'] ) ) 
{
	header("Location: login.php?message=4");
}
if( isset($_POST['submit']) )
{
  mysql_connect("mysql12.000webhost.com", "a4446349_jmar", "banana1234");
  mysql_select_db( "a4446349_jmar" );
	
	$name = $_POST['r_name'];
	$cuisine = $_POST['cuisine'];
	$difficulty = $_POST['difficulty'];
	$time_hr = $_POST['time_hr'];
	$time_min = $_POST['time_min'];
	if(strcmp($time_hr, "" ) == 0)
	{
		$time_hr = "0";
	}
	if(strcmp($time_min, "" ) == 0 )
	{
		$time_min = "0";
	}
	$cook_time = "00:".$time_hr . ":".$time_min;
	$directions = $_POST['directions'];
	$id_query = "SELECT MAX(recipe_id) FROM `Recipe`";
	if( !empty($name) )
	{
	$rq = mysql_query($id_query);
	$row = mysql_fetch_array( $rq );
	$recipe_id = $row['MAX(recipe_id)'] + 1;


	$query = "INSERT INTO `Recipe`(`recipe_id`, `name`,`cook_time`,`difficulty`,`directions`,`type_of_food`) VALUES ( '{$recipe_id}', '{$name}', '{$cook_time}', '{$difficulty}', '{$directions}', '{$cuisine}' )";
	mysql_query($query);
	$uid = $_COOKIE['user_id'];
	$date = date("Y\-m\-d");
	$query = "INSERT INTO Creates (user_id, recipe_id, date_created) VALUES ( {$uid}, {$recipe_id}, '{$date}' )";
	mysql_query($query);
  for($i=1; $i<=15;$i++)
  {
      $iname= $i.'name';
      $iquantity=$i.'quantity';
      $inote= $i.'note';
      $name= $_POST[$iname];
      $quantity= $_POST[$iquantity];
      $note = $_POST[$inote];
      if(!empty( $name ))
      {
      	$query = "INSERT INTO `RecipeHasIngredient`(`recipe_id`, `ingr_name`,`quantity`,`note`) VALUES ( '{$recipe_id}', '{$name}', '{$quantity}','{$note}')";
    mysql_query($query);
    }
  }
  header( "Location: recipe.php?recipe_id={$recipe_id}&uid={$uid}") ;
	}
mysql_close();
/*
$url = "search.php?query=$query&search_by=$search_by";
	header("Location: $url" );

*/
}
?>
<div id="content">
<h1>Add a new recipe</h1>

<form id="add_new" name="add_new" method="post" action="" >
<table class="add_new">
	<tr>
  <td>Name</td>
  <td><input id="r_name" name="r_name" type="text" class="add_new_input"/></td>
  </tr>
  <tr>
  <td>Cuisine:</td>
  <td>
  <select name="cuisine" id="cuisine">
  <option>American</option>
  <option>Italian</option>
  <option>Mexican</option>
  <option>Chinese</option>
  <option>Indian</option>
  <option>Japanese</option>
  <option>French</option>
  <option>Spanish</option>
  <option>Other</option>
  </select>
  </td>
  </tr>
  <tr>
  <td>Difficulty</td>
  <td>
  <select name="difficulty" id="difficulty">
  <option>Simple</option>
  <option>Moderate</option>
  <option>Challenging</option>
  </select>
  </td>
  </tr>
  <tr>
  <td>Cooking time</td>
  <td><input type="text" name="time_hr" id="time_hr" class="add_time" />&nbsp;:&nbsp;<input type="text" name="time_min" id="time_min" class="add_time" /> (hours : minutes)</td>
  </tr>
  <tr>
  <td>Ingredients</td>
  <td>
  <table class="add_ingr">
  <tr class="add_ingr">
  <td width="20%" class="add_ingr"><b>Quanitity</b><br/> (e.g. "1 cup", "1/2 teaspoon")</td>
  <td width="40%"class="add_ingr"><b>Ingredient</b><br/> (e.g. "chicken", "broccoli")</td>
  <td width="40%"class="add_ingr"><b>Note</b><br/>(e.g. "diced", "cooked")</td>
  </tr>
    <?php
  
  for($i=1 ;$i<=15;$i++)
  {
  $name= $i."name";
  $quantity= $i."quantity";
  $note= $i."note";
  echo "<tr class=\"add_ingr\">";
    echo "<td class=\"add_ingr\"><input id=\"$quantity\" name= \"$quantity\" type=\"text\" class=\"ingr_quantity\"/></td>\n";
    echo "<td class=\"add_ingr\"><input id= \"$name\" name= \"$name\"type=\"text\" class=\"ingr_name\"/></td>\n";

  echo "<td class=\"add_ingr\"><input id=\"$note\" name= \"$note\" type=\"text\" class=\"ingr_note\"/></td>\n";
  echo "</tr>";
  }
  
  ?>
  </td>
  </table>
  </tr>
  <tr>
  <td>Directions</td>
  <td><textarea cols="40" rows="10" name="directions" id="directions"></textarea></td>
  </tr>
  </table>
  <p> </p>
  <input type="submit" value="Add this recipe" name="submit" id="button"/>
</form>


</div>
<?php include( 'includes/footer.php' ); ?>
</div>
</body>
</html>
