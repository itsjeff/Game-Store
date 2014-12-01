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
					'title'        => 'required',
					'available_on' => 'required',
					'price'        => 'required|numeric',
					'description'  => 'required'
					));
	
	// Validate Image input
	if (empty($_FILES['image']['name']))
	{
		$validate->set_message('image', 'Image field is required.');
	}
					
	
	// if all is fine, then insert data
	if ($validate->check() === true)
	{
		// File paths
		$file->file_path = $_FILES['image']['tmp_name'];
		$file->file_name = $_FILES['image']['name'];	
		$file->file_dest = BASE_PATH . '/assets/uploads/';
		
		// File rename
		$file->file_rename = time();
		
		// Move file
		if($file->file_upload()) 
		{
			// Create Thumbnail
			$image->resize($file->file_dest . $file->file_name, $file->file_dest . 'thumbs/' . $file->file_name);
		}
		
		
		// Insert data
		$insert_data = array(
							'title'            => trim(htmlspecialchars($_POST['title'])), 
							'description'      => trim(htmlspecialchars($_POST['description'])), 
							'created_on'       => date('Y-m-d h:i:s'), 
							'available_on'     => trim(htmlspecialchars($_POST['available_on'])), 
							'price'            => trim(htmlspecialchars($_POST['price'])), 
							'image'            => $file->file_name, 
							'classification'   => trim(htmlspecialchars($_POST['classification'])), 
							'product_condition'=> trim(htmlspecialchars($_POST['condition'])), 
							'category_id'      => trim(htmlspecialchars($_POST['category']))
							);

		$db->table('product')->insert($insert_data);
				
		// Redirect		
		header('location: products.php');
	}
}


// Get categories for select field
$categories = $db->table('category')->get();

$category_array = array();

foreach ($categories as $category) 
{ 
	$category_array[$category->category_title] = $category->category_id;
}


require_once('_layout/header.php'); 
?>

	<h3>Add Product</h3>
	
	<form action="product_add.php" method="post" enctype="multipart/form-data">
	
	<table class="form-table" cellspacing="0">
	<tr>
		<th>
			<label for="title">Product Title</label>
			<?php echo $validate->show_error('title'); ?>
		</th>
		<td>
			<input class="input" type="text" id="title" name="title" value="<?php echo set_value('title'); ?>" />
		</td>
	</tr>
	
	<tr>
		<th><label for="category">Category</label></th>
		<td>
				
<?php echo form_select('category', $category_array, set_value('category')); ?>

		</td>
	</tr>
	
	<table class="form-table">
	<tr>
		<th>
			<label for="image">Image</label>
			<?php echo $validate->show_error('image'); ?>
		</th>
		<td>
			<input class="file" type="file" id="image" name="image" />
		</td>
	</tr>
	
	<tr>
		<th>
			<label for="available_on">Available On</label>
			<?php echo $validate->show_error('available_on'); ?>
		</th>
		<td>
			<input class="input" type="text" id="available_on" name="available_on" value="<?php echo set_value('available_on'); ?>" /> <em>YYYY-MM-DD</em>
		</td>
	</tr>
	
	<tr>
		<th>
			<label for="price">Price</label>
			<?php echo $validate->show_error('price'); ?>
		</th>
		<td>
			<input class="input" type="text" id="price" name="price" value="<?php echo set_value('price'); ?>" />
		</td>
	</tr>
	
	<tr>
		<th><label for="classification">Classification</label></th>
		<td>

<?php echo form_select('classification', array('--' => '', 'G' => 'G', 'PG' => 'PG', 'MA' => 'MA', 'R' => 'R'), set_value('classification')); ?>
		
		</td>
	</tr>
	
	<tr>
		<th><label for="condition">Condition</label></th>
		<td>
		
<?php echo form_select('condition', array('New' => 'new', 'Preowned' => 'preowned'), set_value('condition')); ?>

		</td>
	</tr>
	
	<tr>
		<th>
			<label for="description">Description</label>
			<?php echo $validate->show_error('description'); ?>
		</th>
		<td>
			<textarea class="textarea" id="description" name="description"><?php echo set_value('description'); ?></textarea>
		</td>
	</tr>
	
	<tr>
		<th>&nbsp;</th>
		<td>
			<input class="button" type="submit" name="submit" value="Add Product" />
		</td>
	</tr>
	</table>
	
	</form>
	
<?php require_once('_layout/footer.php'); ?>
	