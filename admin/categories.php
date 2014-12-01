<?php 
require_once('../settings.php'); 


// Check for login
if (! $auth->check())
{
	header('location: login.php');
}


// Get table
$categories = $db->table('category')->orderBy('category_id', 'DESC')->get();

require_once('_layout/header.php'); 
?>

	<h3>Categories</h3>
	
	<table class="table" cellspacing="0">
	<tr>
		<th width="5%">Id</th>
		<th width="20%">Category</th>
		<th width="60%">Description</th>
		<th width="15%">Options</th>
	</tr>
	
	<?php foreach($categories as $category) { ?>
	
	<tr>
		<td width="5%"><?php echo $category->category_id; ?></td>
		<td width="20%">
			<a href="category.php?id=<?php echo $category->category_id; ?>"><?php echo $category->category_title; ?></a>
		</td>
		<td width="60%"><?php echo $category->category_description; ?></td>
		<td width="15%">
			<a href="category.php?id=<?php echo $category->category_id; ?>">Modify</a> | 
			<a href="process.php?action=category_delete&id=<?php echo $category->category_id; ?>">Remove</a>
		</td>
	</tr>
		
	<?php } ?>
	
	</table>
	
<?php require_once('_layout/footer.php'); ?>