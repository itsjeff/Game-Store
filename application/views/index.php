<?php 
require_once('_layout/header.php'); ?>
		
		<!-- HERO -->
		<div id="hero">
			<div class="wrapper">	
				<div style="overflow: hidden; position: relative;">
					<div class="hero-image"><img src="assets/images/hero-mario.jpg" alt="mario kart 8"></div>
					
					<div class="details">
						<a href="index.php?page=product&id=4" class="view" alt="view product">View Product</a>
						 
						<div class="title">
							<strong>Mario Kart 8</strong> | Now Available on: Wii U
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- COMING SOON -->
		<div id="current">
			<div class="wrapper">
				<h2>Now Available</h2>
				
				<div class="products">
					<?php foreach ($products as $product) { ?>
					
						<div class="product">
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
				
				<div class="more">
					<a href="index.php?page=products" class="button" alt="more">More Products</a>
				</div>
			</div>
		</div>
		
		<!-- COMING SOON -->
		<div id="coming-soon">
			<div class="wrapper">
				<h2>Coming Soon</h2>
				
				<div class="left">
					<div class="product">
						<img src="assets/images/coming-destiny.jpg" alt="coming soon: Destiny">
						<h3>Destiny</h3>
						<p>Available Soon</p>
					</div>
				</div>
				
				<div class="right">
					<div class="product">
						<img src="assets/images/coming-pokemon.jpg" alt="coming soon: Pokemon">
						<h3>Pokemon - Omega Ruby &amp; Aplha Sapphire</h3>
						<p>Available Soon</p>
					</div>
				</div>
				
				<div style="clear: both;"></div>
			</div>
		</div>

<?php require_once('_layout/footer.php'); ?>		