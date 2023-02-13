<?php
$msg = '';
$connect = new PDO("mysql:host=localhost; dbname=eksh_commission_gov_bd", "eksh_commission_gov_bd", "Open@1234");
if (isset($_POST['login'])) {
    $name = $_POST['user_email'];
    $password = $_POST['user_password'];
    $query = "select * from admin where user_email ='$name' and user_password='$password' ";
    $select = $connect->query($query);
    $fetch = $select->fetch();
    $username = $fetch['user_email'];
    $userpassword = $fetch['user_password'];
    if ($name == $username && $password == $userpassword) {
        session_start();
        $_SESSION['user_email'] = $username;
        $_SESSION['user_password'] = $password;
        header("Location:dashboard.php");
    } else {
        header("Location:login.php");
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <br />
    <div class="container">
        <h2 align="center">Admin Login</h2>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Login</div>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="user_email" id="user_email" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="user_password" id="user_password" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" id="login" class="btn btn-info" value="Login" />
                    </div>
                </form>
            </div>
        </div>
        <br />
    </div>
</body>

</html>