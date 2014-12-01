<?php
require_once('../settings.php'); 


// Check for login
if (! $auth->check())
{
	header('location: login.php');
}


// Post submit
if (isset($_POST['submit']))
{	
	// Validate rules
	$validate->rules(array(
					'title'       => 'required',
					'description' => 'required'
					));
					
	// Insert data
	$insert_data = array(
						'category_title'       => trim(htmlspecialchars($_POST['title'])), 
						'category_description' => trim(htmlspecialchars($_POST['description']))
						);
	
	
	// Check validation
	if($validate->check() === true)
	{	
		// Insert record
		$db->table('category')->insert($insert_data);
		
		// Redirect
		header('location: categories.php');
	}
}

require_once('_layout/header.php'); 
?>

	<h3>Add Category</h3>
	
	<form action="category_add.php" method="post" accept-charset="utf-8">
	
	<table class="form-table" cellspacing="0">
	<tr>
		<th>
			<label for="title">Category Title</label> 
			<?php echo $validate->show_error('title'); ?>
		</th>
		<td>
			<input class="input" type="text" name="title" value="<?php echo set_value('title'); ?>" />
		</td>
	</tr>
	<tr>
		<th>
			<label for="description">Category Description</label> 
			<?php echo $validate->show_error('description'); ?>
		</th>
		<td>
			<textarea class="textarea" name="description"><?php echo set_value('description'); ?></textarea>
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input class="button" type="submit" name="submit" value="Add Category" />
		</td>
	</tr>
	</table>
	
	</form>
	
<?php require_once('_layout/footer.php'); ?>
	