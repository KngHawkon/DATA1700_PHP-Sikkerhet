<?php
ini_set('display_errors',1);
session_start();

// Redirect if not logged in
if (!isset($_SESSION['userid']))
    header("location: /");

// Connect to mysql and get users
require_once('config/mysql.php');
$db = connect_db();
if (!$query = $db->query("SELECT id, name, username FROM users")) {
    die("Query failed");
}

// Put users into user array
$users = array();
while ($row = $query->fetch_object()) {
    $users[] = $row;
}

// If POST -> create user
if (isset($_POST['username']) and isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

}

include_once('views/head_view.php');
include_once('views/menu_view.php');
?>
<div class="container">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Username</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user->id; ?></td>
                <td><?php echo $user->name; ?></td>
                <td><?php echo $user->username; ?></td>
                <td></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <form method="post" action="/users.php" class="form-horizontal">
        <div class="row">
            <div class="col-md-6">
                <h3>New user</h3>
                <hr>
                <div class="form-group">
                    <label class="col-md-3">Name:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="name" placeholder="Name of user">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">Username:</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">Password:</label>
                    <div class="col-md-9">
                        <input type="password" class="form-control" name="password" placeholder="User password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create user</button>
            </div>
        </div>
    </form>
</div>
<?php
include_once('views/foot_view.php');