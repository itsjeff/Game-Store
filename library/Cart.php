<?php
/*
 * Add item to cart
 */
function add_to_cart($item)
{
	if (count($_SESSION['cart']) > 0)
	{
		array_push($_SESSION['cart'], $item);
	}
	else
	{
		$_SESSION['cart'] = array($item);
	}
}


/*
 * Get cart items
 */
function get_cart()
{
	$products = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : array();
	
	return $products;
}


/*
 * Clear cart items
 */
function clear_cart()
{
	if (isset($_SESSION['cart']))
	{
		unset($_SESSION['cart']);
	}
}


/*
 * Count total items in cart
 */
function count_cart()
{
	return (isset($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;
}


/*
 * Price total
 */
function cart_total()
{
	$total = 0;

	if (isset($_SESSION['cart']))
	{	
		foreach($_SESSION['cart'] as $product)
		{
			$total += $product['price'];
		}
	}
	
	return $total;
}
?>