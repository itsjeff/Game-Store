<?php 
require_once('_layout/header.php'); ?>
		
		<!-- HERO -->
		<div id="hero">
			<div class="wrapper">	
				<h1>My Shopping Cart</h1>
				
				<p>
					<a href="index.php">Home</a> / My Shopping Cart
				</p>
			</div>
		</div>
		
		<!-- AVAILABLE -->
		<div id="current">
			<div class="wrapper">
			
				<div id="sort">
					<div style="float: right;">
						<a href="index.php?page=cart&action=clear">Clear Cart</a>
					</div>
					
					Total items: <?php echo count_cart(); ?>
				</div>
				
				<div class="products">
					<table class="table" width="100%">
					<tr>
						<th align="left">Product</th>
						<th align="right">Price</th>
					</tr>
					
					<?php foreach(get_cart() as $product) { ?>
					
					<tr>
						<td align="left">
							<a href="index.php?page=product&id=<?php echo $product['id']; ?>"><?php echo $product['title']; ?></a>
							
							<p>Category: <?php echo $product['category']; ?></p>
						</td>
						<td align="right">$<?php echo $product['price']; ?></td>
					</tr>
					
					<?php } ?>
					
					<tr>
						<td class="total">&nbsp;</td>
						<td class="total" align="right">
							Total: $<?php echo cart_total(); ?>
						</td>
					</tr>
					</table>
				</div>
			</div>
		</div>

<?php require_once('_layout/footer.php'); ?>		