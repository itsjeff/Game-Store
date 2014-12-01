<html>
<head>
	<title>Control Panel</title>
	
	<link media="all" type="text/css" rel="stylesheet" href="_layout/css/admin.css">
</head>
<body>
	<div id="container">
		<div style="float: right; padding: 12px 15px 0;">	
		
			Welcome, <em><?php echo $auth->user()->email; ?></em> | 
			
			<a href="../index.php">My Site</a> | 
			
			<a href="process.php?action=logout">Logout</a>
			
		</div>
		
		<h1>Control Panel</h1>
		
		<div id="menu">
		<ul>
			<li><a href="index.php">Dashboard</a></li>
			<li><a href="products.php">Products</a></li>
			<li><a href="product_add.php">Add Product</a></li>
			<li><a href="categories.php">Categories</a></li>
			<li><a href="category_add.php">Add Category</a></li>
		</ul>
		</div>
		
		<div id="body">