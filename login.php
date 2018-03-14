<?php
ini_set('display_errors',1);
session_start();

// If GET signout -> destroy session and redirect home
if (isset($_GET['signout'])) {
    session_destroy();
    header('location:/');
}

// If POST -> try to sign in
if (isset($_POST['username']) and isset($_POST['password'])) {

    // Connect to mysql
    require_once('config/mysql.php');
    $db = connect_db();

    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);

    // Find user with matching username and password
    $sql = "SELECT * FROM users WHERE username='".$username."' AND password='".$password."'";
    if (!$query = $db->query($sql)) {
        //echo $sql.'<br>';
        die("Query failed");
    }

    if ($query->num_rows > 0) {
        // Store user id and name in session
        $user = $query->fetch_object();
        $_SESSION['userid'] = $user->id;
        $_SESSION['name'] = $user->name;
        
        header('location:/');
    } else {
        header('location:/login.php');
    }
}

include_once('views/head_view.php');
include_once('views/menu_view.php');
?>

        <form method="post" action="/login.php" class="container">
            
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <h1>User login</h1>

                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" class="form-control" name="username" placeholder="Your username">
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Your password">
                    </div>

                    <button type="submit" class="btn btn-primary">Sign in</button>
                </div>
            </div>
        
        </form>

<?php
include_once('views/foot_view.php');