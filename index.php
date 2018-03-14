<?php
ini_set('display_errors',1);

session_start();

require_once('config/mysql.php');
$db = connect_db();


include_once('views/head_view.php');
include_once('views/menu_view.php');
?>

<div class="container">

    <h1 class="text-center">Hello World</h1>

</div>
     
<?php
include_once('views/foot_view.php');