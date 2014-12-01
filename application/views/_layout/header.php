<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Game Store</title>
		
		<meta charset="utf-8">
		
		<link href="assets/css/main.css" rel="stylesheet">
		<script src="assets/js/jquery.min.js"></script>
		
		<script>
			$(document).ready(function () {    
				
				$('#menu li').hover(
					function () {
						$('ul', this).stop().slideDown(100);
					}, 
					function () {
						$('ul', this).stop().slideUp(100);            
					}
				);
				
			});
		</script>
	</head>
	<body>
	
		<!-- HEADER -->
		<div id="header">
			<div class="wrapper">
				<div id="cart">
					<p>Cart: <?php echo count_cart(); ?> item(s) in cart.</p>
					<a href="index.php?page=cart" class="checkout">Check out</a>
				</div>
			</div>
		</div>
		
		<!-- MENU -->
		<div id="menu">
			<div class="wrapper">
				<div class="search">
					<form method="post">
						<input type="text" name="search_string" placeholder="Search">
					</form>
				</div>
				
				<ul>
					<li><a href="index.php">HOME</a></li>
					<li><a href="index.php?page=products&category=2" alt="ps4">PS4</a></li>
					<li><a href="index.php?page=products&category=3" alt="xbox one">XBOX ONE</a></li>
					<li><a href="index.php?page=products&category=4" alt="wii u">WII U</a></li>
					<li>
					<a href="index.php?page=products&category=5" alt="other">OTHER</a>
						<ul>
							<li><a href="index.php?page=products&category=1">Nintendo 3DS</a></li>
							<li><a href="index.php?page=products&category=6">PC</a></li>
						</ul>  
					</li>
				</ul>
			</div>
		</div>