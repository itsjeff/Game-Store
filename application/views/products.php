<?php 
require_once('_layout/header.php'); ?>
		
		<!-- HERO -->
		<div id="hero">
			<div class="wrapper">	
				<h1>Products</h1>
				
				<p>
					<a href="index.php">Home</a> / 
					<?php 
					if (isset($category->category_title))
					{
						echo '<a href="index.php?page=products">Products</a> / ' . $category->category_title; 
					}
					else
					{
						echo 'All Products';
					}
					?>
				</p>
			</div>
		</div>
		
		<!-- AVAILABLE -->
		<div id="current">
			<div class="wrapper">
			
				<div id="sort">
					Sort Products: <a href="index.php?page=products<?php echo $category_action; ?>&order=ASC">Oldest</a> - 
					<a href="index.php?page=products<?php echo $category_action; ?>&order=DESC">Newest</a>
				</div>
				
					<?php if ($product_count > 0) { ?>
					
					<div class="products">
					
					<?php foreach ($products as $product) { ?>
					
						<div class="product spacer">
							<div class="product-box">
								<div class="price">
									<span>$</span> <?php echo $product->price ?>
								</div>
								
								<div class="image">
									<img src="assets/uploads/thumbs/<?php echo $product->image; ?>" alt="<?php echo $product->title; ?>">
								</div>
								
								<div class="info">
									<p><a href="index.php?page=product&id=<?php echo $product->product_id; ?>" alt="<?php echo $product->title; ?>"><?php echo $product->title; ?></a></p>
									<em>Category: <a href="index.php?page=products&category=<?php echo $product->category_id; ?>" alt="category"><?php echo $product->category_title; ?></a></em>
								</div>
							</div>
						</div>
					
					<?php } ?> 
					
						<div style="clear: both;"></div>
					</div>
					
					<?php
					}
					else
					{
						echo '<div class="none">No products here.</div>';
					}
					?>
					
					<div class="more">
						<a href="index.php?page=products<?php echo $category_action . $order_action; ?>&p=<?php echo $page_prev; ?>" class="button" alt="more">Prev</a> 
						<a href="index.php?page=products<?php echo $category_action . $order_action; ?>&p=<?php echo $page_next; ?>" class="button" alt="more">Next</a>
					</div>
			</div>
		</div>

<?php require_once('_layout/footer.php'); ?>		