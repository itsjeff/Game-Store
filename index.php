<?php
require_once('settings.php');


// Get the current page, otherwise goto default view
$page = (isset($_GET['page'])) ? trim(htmlspecialchars($_GET['page'])) : '';

if (isset($_POST['search_string'])) 
{
	$url_encode = urlencode($_POST['search_string']);
	
	$search_term = trim(htmlspecialchars($url_encode));
	
	header('Location: index.php?page=search&title=' . $search_term);
}


// Current Page
if ($page == 'cart')
{	
	$action = (isset($_GET['action'])) ? trim(htmlspecialchars($_GET['action'])) : null;
	
	// Cart actions
	if ($action == 'clear')
	{
		clear_cart();
		
		header('Location: index.php?page=cart');
	}
	
	
	// Get View						
	require_once('application/' . $dir_views . 'cart.php');
}
else if ($page == 'products')
{	
	// List products
	$category_id = (isset($_GET['category'])) ? trim(htmlspecialchars($_GET['category'])) : 0;
	
	$order = (isset($_GET['order']) && $_GET['order'] == 'ASC') ? 'ASC' : 'DESC';
		
	$category_action = ($category_id > 0) ? '&category=' . $category_id : '';
	$order_action    = ($order) ? '&order=' . $order : '';
	
	
	//Pagination
	if (isset($_GET['p']) && is_numeric($_GET['p'])) 
	{
		$current_page = (int)$_GET['p'];
	} 
	else 
	{
		$current_page = 1;
	}
	
	$results_per_page = 8;
	
	$results_start = (isset($_GET['p'])) ? $results_per_page * ($current_page - 1) : 0;
	
	$page_prev = ($current_page < 2) ? 1 : $current_page - 1;
	$page_next = $current_page + 1;
	
	
	// Category id is valid or not
	if ($category_id)
	{
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
						->orderBy('product.product_id', $order)
						->limit(array($results_start, $results_per_page))
						->where('product.category_id', '=', $category_id)
						->get();
						
		$product_count = $db->num_rows;
						
		$category = $db->table('category')
						->where('category_id', '=', $category_id)
						->first();
	}
	else
	{
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
						->orderBy('product.product_id', $order)
						->limit(array($results_start, $results_per_page))
						->get();

		$product_count = $db->num_rows;
	}

	
	// Get View						
	require_once('application/' . $dir_views . 'products.php');
}
else if ($page == 'product')
{
	// Get product
	$product_id = (isset($_GET['id'])) ? trim(htmlspecialchars($_GET['id'])) : 0;
	
	$action = (isset($_GET['action'])) ? trim(htmlspecialchars($_GET['action'])) : '';
	
	$product = $db->table('product')
					->select('product.product_id', 
							'product.title', 
							'product.description', 
							'product.category_id', 
							'product.classification', 
							'product.product_id', 
							'product.created_on', 
							'product.price', 
							'product.product_condition', 
							'product.image', 
							'category.category_title')
					->join('category', 'product.category_id', '=', 'category.category_id')
					->where('product.product_id', '=', $product_id)
					->first();
	
	
	if ($action == 'cart')
	{
		$cart_item = array('id'       => $product->product_id, 
							'title'    => $product->title, 
							'image'    => $product->image,
							'price'    => $product->price,
							'category' =>$product->category_title
							);
							
		add_to_cart($cart_item);
		
		header('location: index.php?page=product&id=' . $product_id);
	}
	else
	{
		// Get View		
		require_once('application/' . $dir_views . 'product.php');
	}
}
else if ($page == 'search')
{
	
	// Search table
	$search_string = trim(htmlspecialchars(stripslashes($_GET['title'])));
	
	$products = $db->table('product')
					->select('product.product_id', 
							'product.title', 
							'product.description', 
							'product.category_id', 
							'product.classification', 
							'product.product_id', 
							'product.created_on', 
							'product.price', 
							'product.product_condition', 
							'product.image', 
							'category.category_title')
					->join('category', 'product.category_id', '=', 'category.category_id')
					->where('product.title', 'LIKE', $search_string)
					->get();
					
	$product_count = $db->num_rows;
					
	// Get View		
	require_once('application/' . $dir_views . 'search.php');	
}
else
{
	// List products
	$products = $db->table('product')
					->select('product.product_id', 
							'product.title', 
							'product.description', 
							'product.category_id', 
							'product.classification', 
							'product.product_id', 
							'product.created_on', 
							'product.price', 
							'product.product_condition', 
							'product.image', 
							'category.category_title')
					->join('category', 'product.category_id', '=', 'category.category_id')
					->limit(array(4))
					->get();
			
			
	// Get View				
	require_once('application/' . $dir_views . 'index.php');
}
?>