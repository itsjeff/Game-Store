<?php 
require_once('_layout/header.php'); ?>
		
		<!-- HERO -->
		<div id="hero">
			<div class="wrapper">	
				<h1>Search</h1>
				
				<p>
					<a href="index.php">Home</a> / Search / <?php echo $search_string; ?>
				</p>
			</div>
		</div>
		
		<!-- AVAILABLE -->
		<div id="current">
			<div class="wrapper">
			
				<div id="sort">
					Search results: <?php echo $product_count; ?>
				</div>
				
					<?php if ($product_count > 0) { ?>
					
					<div class="products">
					
					<?php foreach ($products as $product) { ?>
					
						<div class="search-result">
							<p>
								<strong><a href="index.php?page=product&id=<?php echo $product->product_id; ?>"><?php echo $product->title; ?></a></strong>
							</p>
							
							<em>Category: <?php echo $product->category_title; ?></em>
						</div>
					
					<?php } ?> 
					
					</div>
					
					<?php
					}
					else
					{
						echo '<div class="none">No products found.</div>';
					}
					?>
			</div>
		</div>

<?php require_once('_layout/footer.php'); ?>		