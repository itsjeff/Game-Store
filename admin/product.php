<?php
require_once('../settings.php'); 


// Check for login
if (! $auth->check())
{
	header('location: login.php');
}


// Get single record
$product_id = (isset($_GET['id'])) ? (int) trim(htmlspecialchars($_GET['id'])) : 0;

$product = $db->table('product')->where('product_id', '=', $product_id)->first();


// Post submit
if (isset($_POST['submit']))
{	
	// Validate rules
	$validate->rules(array(
					'title'        => 'required',
					'price'        => 'required|numeric',
					'available_on' => 'required',
					'description'  => 'required'
					));
					
	// Update data
	$update_data = array(
							'title'             => trim(htmlspecialchars($_POST['title'])), 
							'description'       => trim(htmlspecialchars($_POST['description'])), 
							'classification'    => trim(htmlspecialchars($_POST['classification'])), 
							'product_condition' => trim(htmlspecialchars($_POST['condition'])), 
							'available_on'      => trim(htmlspecialchars($_POST['available_on'])), 
							'price'             => trim(htmlspecialchars($_POST['price'])),
							'category_id'       => trim(htmlspecialchars($_POST['category']))
						);
					
					
	// Check validation
	if($validate->check() === true)
	{	
		// Image change
		if (! empty($_FILES['image']['name']))
		{						
			// File paths
			$file->file_path = $_FILES['image']['tmp_name'];
			$file->file_name = $_FILES['image']['name'];	
			$file->file_dest = BASE_PATH . '/assets/uploads/';
			
			// remove old files
			$file->remove($file->file_dest . $product->image);
			$file->remove($file->file_dest . 'thumbs/' . $product->image);
			
			// File rename			
			$file->file_rename = time();
			
			// Move file
			if($file->file_upload()) 
			{
				// Create Thumbnail
				$image->resize($file->file_dest . $file->file_name, $file->file_dest . 'thumbs/' . $file->file_name);
				
				// update file
				$db->table('product')->where('product_id', '=', $product_id)->update(array('image' => $file->file_name));	
			}
		}
	
		// Update
		$db->table('product')->where('product_id', '=', $product_id)->update($update_data);	
		
		header('Location: product.php?id=' . $product_id . '&message=1');
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

	<h3>Modify Product</h3>
	
	<?php
	// Success message
	if (isset($_GET['message']) && trim(htmlspecialchars($_GET['message'])) == 1)
	{
		echo '<div class="success">Product was updated at '. date('h:i:s')  .'!</div>';
	}
	?>
	
	<form action="product.php?id=<?php echo $product->product_id; ?>" method="post" enctype="multipart/form-data">
	
	<table class="form-table" cellspacing="0">
	<tr>
		<th>
			<label for="title">Product Title</label>
			<?php echo $validate->show_error('title'); ?>
		</th>
		<td>
			<input class="input" type="text" id="title" name="title" value="<?php echo $product->title; ?>" />
		</td>
	</tr>
	
	<tr>
		<th><label for="category">Category</label></th>
		<td>


<?php echo form_select('category', $category_array, $product->category_id); ?>

		</td>
	</tr>
	
	<table class="form-table">
	<tr>
		<th><label for="image">Image</label></th>
		<td>
			<p>
				<img style="max-height: 100px;" src="../assets/uploads/thumbs/<?php echo $product->image; ?>" />
			</p>
			
			<input class="file" id="image" type="file" name="image" />
		</td>
	</tr>
	
	<tr>
		<th>
			<label for="available_on">Available On</label>
			<?php echo $validate->show_error('available_on'); ?>
		</th>
		<td>
			<input class="input" type="text" id="available_on" name="available_on" value="<?php echo $product->available_on; ?>" /> <em>YYYY-MM-DD</em>
		</td>
	</tr>
	
	<tr>
		<th>
			<label for="price">Price</label>
			<?php echo $validate->show_error('price'); ?>
		</th>
		<td>
			<input class="input" type="text" id="price" name="price" value="<?php echo $product->price; ?>" />
		</td>
	</tr>
	
	<tr>
		<th><label for="classification">Classification</label></th>
		<td>
		
<?php echo form_select('classification', array('--' => '', 'G' => 'G', 'PG' => 'PG', 'MA' => 'MA', 'R' => 'R'), $product->classification); ?>

		</td>
	</tr>
	
	<tr>
		<th><label for="condition">Condition</label></th>
		<td>
		
<?php echo form_select('condition', array('New' => 'new', 'Preowned' => 'preowned'), $product->product_condition); ?>
			
		</td>
	</tr>
	
	<tr>
		<th>
			<label for="description">Description</label>			
			<?php echo $validate->show_error('description'); ?>
		</th>
		<td>
			<textarea class="textarea" id="description" name="description"><?php echo $product->description; ?></textarea>
		</td>
	</tr>
	
	<tr>
		<th>&nbsp;</th>
		<td>
			<input class="button" type="submit" name="submit" value="Update Product" />
		</td>
	</tr>
	</table>
	
	</form>
	
<?php require_once('_layout/footer.php'); ?>
	