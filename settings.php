<?php
/*
 * Folders & Paths
 *
 */
DEFINE('BASE_PATH', __DIR__);

$dir_inc     = 'library/';
$dir_views   = 'views/';
$dir_uploads = 'uploads/';

date_default_timezone_set('UTC');



// Start session (needed for login and cart)
session_start();



/*
 * Require files
 *
 */
require_once ($dir_inc . 'Auth.php');
require_once ($dir_inc . 'Cart.php');
require_once ($dir_inc . 'Database.php');
require_once ($dir_inc . 'Form.php');
require_once ($dir_inc . 'File.php');
require_once ($dir_inc . 'Image.php');
require_once ($dir_inc . 'Validate.php');



/*
 * Load classes
 *
 */
$db       = new Jeffs\Database;
$auth     = new Jeffs\Auth($db);
$file     = new Jeffs\File;
$image    = new Jeffs\Image;
$validate = new Jeffs\Validate;
?>
