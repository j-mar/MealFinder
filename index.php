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

<div id="content">
<center>
	<h1>Find me a recipe with...</h1>
	<h1>I would like to make...</h1>
  <h1>I have a craving for...</h1>
  <form id="form1" name="form1" method="post" action="">
      <input id="tb_search" name="search_item" type="text"/>
      <br />
    <label>
      Search By&nbsp;<select name="category" size="1" id="category">
        <option>Recipes</option>
        <option>Cuisine</option>
        <option>Ingredient</option>
      </select>
      </label>
  </form>
<div id="button" style="float:none; width: 100px;">GO</div>
</center>
</div>
<?php include( 'includes/footer.php' ); ?>
</div>
</body>
</html>
