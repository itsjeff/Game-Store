<?php 
require_once('../settings.php'); 


// Check for login
if (! $auth->check())
{
	header('location: login.php');
}


// Get table
$products = $db->table('product')
				->select('product.product_id', 
						'product.title', 
						'product.category_id', 
						'product.product_id', 
						'product.created_on', 
						'product.price', 
						'product.product_condition', 
						'product.image', 
						'category.category_title')
				->join('category', 'product.category_id', '=', 'category.category_id')
				->orderBy('product.product_id', 'DESC')
				->get();

				
require_once('_layout/header.php'); 
?>

	<h3>Products</h3>
	
	<table class="table" cellspacing="0">
	<tr>
		<th width="2%">Id</th>
		<th width="8%">Image</th>
		<th width="20%">Product</th>
		<th width="25%">Category</th>
		<th width="15%">Created At</th>
		<th width="15%">Price</th>
		<th width="15%">Options</th>
	</tr>
	
	<?php foreach($products as $product) { ?>
	
	<tr>
		<td width="2%"><?php echo $product->product_id; ?></td>
		<td width="8%"><img style="max-height: 50px;" src="<?php echo '../assets/uploads/thumbs/' . $product->image; ?>" /></td>
		<td width="20%">
			<p><a href="product.php?id=<?php echo $product->product_id; ?>"><?php echo $product->title; ?></a></p>
			<em><?php echo $product->product_condition; ?></em>
		</td>
		<td width="25%"><?php echo $product->category_title; ?></td>
		<td width="15%"><?php echo $product->created_on; ?></td>
		<td width="15%">$<?php echo $product->price; ?></td>
		<td width="15%">
			<a href="product.php?id=<?php echo $product->product_id; ?>">Modify</a> | 
			<a href="process.php?action=product_delete&id=<?php echo $product->product_id; ?>">Remove</a>
		</td>
	</tr>
		
	<?php } ?>
	
	</table>
	
<?php require_once('_layout/footer.php'); ?>