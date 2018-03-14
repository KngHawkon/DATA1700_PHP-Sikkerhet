<?php
ini_set('display_errors',1);
session_start();

// Redirect if not logged in
if (!isset($_SESSION['userid']))
    header("location: /");

// Connect to mysql
require_once('config/mysql.php');
$db = connect_db();

// Get posts from db
if (!$query = $db->query("SELECT p.*, u.name FROM posts p LEFT JOIN users u ON u.id = p.userid")) {
    die("Query failed");
}

// Put posts in post array
$posts = array();
while ($row = $query->fetch_object()) {
    $posts[] = $row;
}

// If POST -> Save comment
if (isset($_POST['body']) and isset($_SESSION['userid'])) {

    $body = addslashes(htmlentities($_POST['body']));

    // Insert post into db
    if (!$query = $db->query("INSERT INTO posts (userid, body) VALUES ('".$_SESSION['userid']."','".$body."')")) {
        die("Insert failed");
    }

    // Redirect to avoid refresh repost
    header('location:secure.php');
}

include_once('views/head_view.php');
include_once('views/menu_view.php');
?>

<div class="container">

    <h1 class="text-center">Very secure area</h1>
    <hr>
    <?php foreach ($posts as $post): ?>
    <div>
        <b><?php echo $post->name; ?></b>
        <p><?php echo $post->body; ?></p>
        <small><time><?php echo date_create_from_format('Y-m-d H:i:s', $post->created)->format('d.m.Y - \K\l. H:i'); ?></time></small>
    </div>
    <hr>
    <?php endforeach; ?>
    <form method="post" action="/secure.php">
        <div class="form-group">
            <label>New post:</label>
            <textarea class="form-control" name="body" placeholder="Write a post..."></textarea>
        </div>    
        <button type="submit" class="btn btn-primary">Post</button>
    </form>

</div>
     
<?php
include_once('views/foot_view.php');