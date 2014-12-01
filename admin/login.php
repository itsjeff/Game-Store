<?php 
require_once('../settings.php'); 


// Check for login
if ($auth->check())
{
	header('location: index.php');
}


// Post submit
if (isset($_POST['submit']))
{	
	// Validate rules
	$validate->rules(array(
					'email'    => 'required|email',
					'password' => 'required'
					));				
				
				
	// Check validation
	if($validate->check() === true)
	{	
	
		// User data
		$user_data = array(
						'email'    => $_POST['email'], 
						'password' => $_POST['password']
						);
		
		// Attempt login	
		if ($auth->login($user_data))
		{
			header('location: index.php');
		}
		else
		{
			echo 'Credentials do not match.';
		}
	}
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	
	<link media="all" type="text/css" rel="stylesheet" href="_layout/css/login.css">
</head>
<body>
	<div id="form-container">	

		<div class="padding">
			<div id="section-header"><img src="_layout/images/logo.png" /></div>
		
			<form method="post">
			
				<div class="form-wrap">	
					
					<div class="input-wrap">
						<?php echo $validate->show_error('email'); ?>
						<input class="input-text" name="email" type="text" value="<?php echo set_value('email'); ?>" placeholder="E-mail" />
					</div>
					
					<div class="input-wrap">
						<?php echo $validate->show_error('password'); ?>
						<input class="input-text" name="password" type="password" placeholder="Password" />
					</div>

					<div>
						<input class="btn-block" type="submit" name="submit" value="Login" />
					</div>
					
					<p>
						<a href="../index.php">Back to Site</a>
					</p>
				</div>
			
			</form>
			
		</div>
	</div>
</body>
</html>