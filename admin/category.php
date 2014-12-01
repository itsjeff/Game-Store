<?php
require_once('../settings.php'); 


// Check for login
if (! $auth->check())
{
	header('location: login.php');
}


// Get single record
$category_id  = (isset($_GET['id'])) ? (int) trim(htmlspecialchars($_GET['id'])) : 0;

$category     = $db->table('category')->where('category_id', '=', $category_id)->first();

$category_num = $db->num_rows;


// Post submit
if (isset($_POST['submit']))
{	

	// Validate rules
	$validate->rules(array(
					'title'       => 'required',
					'description' => 'required'
					));
	
	// Update data
	$update_data = array(
						'category_title'       => trim(htmlspecialchars($_POST['title'])),
						'category_description' => trim(htmlspecialchars($_POST['description']))
						);
	

	// Check Validation
	if ($category_num > 0 && $validate->check() === true)
	{
		$db->table('category')->where('category_id', '=', $category_id)->update($update_data);	
		
		header('Location: category.php?id=' . $category_id . '&message=1');
	}
}


require_once('_layout/header.php'); 
?>

	<h3>Modify Category</h3>
	
	<?php
	// Success
	if (isset($_GET['message']) && trim(htmlspecialchars($_GET['message'])) == 1)
	{
		echo '<div class="success">Category was updated at '. date('h:i:s')  .'!</div>';
	}
	?>
	
	<form action="category.php?id=<?php echo $category->category_id; ?>" method="post" accept-charset="utf-8">
	
	<table class="form-table" cellspacing="0">
	<tr>
		<th>
			<label for="title">Category Title</label>
			 <?php echo $validate->show_error('title'); ?>
		</th>
		<td>
			<input class="input" type="text" name="title" value="<?php echo $category->category_title; ?>" />
		</td>
	</tr>
	<tr>
		<th>
			<label for="description">Category Description</label>
			 <?php echo $validate->show_error('description'); ?>
		</th>
		<td>
			<textarea class="textarea" name="description"><?php echo $category->category_description; ?></textarea>
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input class="button" type="submit" name="submit" value="Update Category" />
		</td>
	</tr>
	</table>
	
	</form>
	
<?php require_once('_layout/footer.php'); ?>
	