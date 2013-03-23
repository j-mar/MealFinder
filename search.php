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

$query = $_GET['query'];
$search_by = $_GET['search_by'];

if( empty( $query ) )
{
	$strSQL =
		"SELECT recipe_id, name, avg_rating
	 	FROM `Recipe`
		ORDER BY avg_rating DESC";
}
else if( strcmp( $search_by, "Recipes" ) == 0 ) 
{
	$strSQL =
		"SELECT recipe_id, name, avg_rating
	   	FROM `Recipe`
	    WHERE name LIKE'%$query%'
			ORDER BY avg_rating DESC";
}
else if( strcmp( $search_by, "Cuisine" ) == 0 )
{
	$strSQL =
		"SELECT recipe_id, name, avg_rating
		 FROM `Recipe`
		 WHERE type_of_food LIKE '%$query%'
		 ORDER BY avg_rating DESC";
}
else if( strcmp( $search_by, "Ingredient" ) == 0 )
{
	$strSQL = 
		"SELECT r.recipe_id, r.name, r.avg_rating
FROM `Recipe` r, (SELECT DISTINCT recipe_id
FROM `RecipeHasIngredient`
WHERE ingr_name LIKE '%$query%') i
WHERE r.recipe_id = i.recipe_id
ORDER BY r.avg_rating DESC";
}


$rs = mysql_query( $strSQL );

$numResults = mysql_num_rows( $rs ); ?>
<div class="main">

<div id="content">
<h1>You might enjoy these <i><? echo $_GET['query'] ?></i> recipes</h1>
<table id="results" class="results">
<thead>
<tr>
<td width="70%">Name</td>
<td width="30%" align="center">Average Rating</td>
</tr>
</thead>
<? 
if( $numResults > 0 )
{
	for( $i = 0; $i < mysql_num_rows($rs); $i++ )
	{
		$row = mysql_fetch_array($rs);
	
		echo "<tr>";
		echo "<td>";
		echo "<a href=\"recipe.php?recipe_id={$row['recipe_id']}\">{$row['name']}</a>";
		echo "</td>";
		echo "<td align=\"center\">";
		if( $row['avg_rating'] == 0 )
		{
			echo "---";
		}
		else
		{
			echo number_format($row['avg_rating'], 2);
		}
		echo "</td>";
		echo "</tr>";
	}
}
else
{
	echo "<tr>
				<td>We could not find anything for \"$query\".</td>
				<td>:(</td>
				</tr>";
}
mysql_close();
?>
</table>
</div>

<?php include( 'includes/footer.php' ); ?>

</div>

</body>
</html>
