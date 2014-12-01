<?php
require_once('../settings.php'); 


// Check for login
if (! $auth->check())
{
	header('location: login.php');
}


// Action
$action = (isset($_GET['action'])) ? trim(htmlspecialchars($_GET['action'])) : NULL;


if ($action === 'category_delete')
{
	// Get id
	$category_id = (int) $_GET['id'];
	
	
	// Remove record
	$db->table('category')->where('category_id', '=', $category_id)->delete();
	
	
	// Redirect to manage
	header('Location: categories.php');
}
else if ($action === 'product_delete')
{
	// Get id & get table
	$product_id = (int) $_GET['id'];
	$product    = $db->table('product')->where('product_id', '=', $product_id)->first();
	
	
	// Remove file
	$file->remove(BASE_PATH . '/assets/uploads/' . $product->image);
	$file->remove(BASE_PATH . '/assets/uploads/thumbs/' . $product->image);
	
	
	// Remove record
	$db->table('product')->where('product_id', '=', $product_id)->delete();
	
	
	// Redirect to manage
	header('Location: products.php');
}
else if ($action === 'logout')
{
	$auth->logout();
	
	header('location: login.php');
}
else
{
	header('Location: index.php');
}
?>