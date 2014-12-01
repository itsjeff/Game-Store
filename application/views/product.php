<?php 
require_once('_layout/header.php'); ?>
		
		<!-- HERO -->
		<div id="hero">
			<div class="wrapper">	
				<div class="price">
					<h2><small>$</small> <?php echo $product->price; ?></h2>
					
					<p><a href="index.php?page=product&action=cart&id=<?php echo $product->product_id; ?>" class="add">Add to cart</a></p>
				</div>
				
				<h1><?php echo $product->title; ?></h1>
				
				<p>
					<a href="index.php">Home</a> / 
					<a href="index.php?page=products&category=<?php echo $product->category_id; ?>"><?php echo $product->category_title; ?></a> / 
					<?php echo $product->title; ?>
				</p>
				
			</div>
		</div>
		
		<!-- AVAILABLE -->
		<div id="current">
			<div class="wrapper">
			
				<div id="item">
					<div class="left">
						<img src="assets/uploads/<?php echo $product->image; ?>" alt="<?php echo $product->title; ?>">
						
						<?php 
						if ($product->classification == 'G')
						{
							echo '<div class="classification"><img src="assets/images/rating-g.jpg" alt="G"> <a href="http://classification.com.au">More Information</a></div>';
						}
						else if ($product->classification == 'PG')
						{
							echo '<div class="classification"><img src="assets/images/rating-pg.jpg" alt="G"> <a href="http://classification.com.au">More Information</a></div>';
						}
						else if ($product->classification == 'MA')
						{
							echo '<div class="classification"><img src="assets/images/rating-m.jpg" alt="G"> <a href="http://classification.com.au">More Information</a></div>';
						}
						else if ($product->classification == 'R')
						{
							echo '<div class="classification"><img src="assets/images/rating-r.jpg" alt="G"> <a href="http://classification.com.au">More Information</a></div>';
						}
						?>
					</div>
					
					<div class="content">
						<div class="buy">
							<h2>Price: $<?php echo $product->price; ?></h2>
							<p><?php echo $product->product_condition; ?></p>
						</div>
						
						<div class="info">
							<p>Usually ships with 1 to 2 days.</p>
							<p>Ships to Australian addresses only.</p>
						</div>
						
						<h3>Product Overview</h3>
						
						<div class="description">
							<?php echo $product->description; ?>
						</div>
					</div>
					
					<div style="clear: both;"></div>
				</div>
				
			</div>
		</div>

<?php require_once('_layout/footer.php'); ?>		