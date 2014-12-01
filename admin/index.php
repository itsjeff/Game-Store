<?php 
require_once('../settings.php'); 


// Check for login
if (! $auth->check())
{
	header('location: login.php');
}


require_once('_layout/header.php'); 
?>

	<h3>Dashboard</h3>
	
	<p>Information here</p>
	
<?php require_once('_layout/footer.php'); ?>