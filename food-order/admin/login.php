<?php include('../config/constants.php') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pizzeria</title>
    <link rel="stylesheet" href="../css/admin.css?v=2">
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php
        if (isset($_SESSION['login_admin'])) {
            echo $_SESSION['login_admin']; // display session message
            unset($_SESSION['login_admin']); // remove the session message
        }
        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message']; // display session message
            unset($_SESSION['no-login-message']); // remove the session message
        }
        ?>

        <br><br>

        <!-- Login form starts here -->
        <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter your username" value="<?php if(isset($_COOKIE['username'])){ echo $_COOKIE['username'];} ?>">
            <br><br>
            Password: <br>
            <input type="password" name="password" placeholder="Enter your password" value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password'];} ?>">
            <br><br>

            <!-- <input type="checkbox" name="remember_checkbox"> Remember Me
            <br><br> -->

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
        </form>

        <p class="text-center">Created by Pizzeria</p>
    </div>
</body>

</html>

<?php

// check submit button clicked or not
if (isset($_POST['submit'])) {
    // process for login
    // 1. get the data from login form
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // 2. SQL query to check user with name and pass exists
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    // 3. Execute the query
    $res = mysqli_query($conn, $sql);

    // 4. Count rows to check whether the user exist or not
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        //user available and login success
        $_SESSION['login'] = "<div class='success'>Logged In Successfully</div>";
        $_SESSION['user'] = $username; // To check user logged in or not and log out will unset it

        //redirect to home page
        header("location:" . SITEURL . 'admin/');
    } else {
        //user not available
        //user available and login success
        $_SESSION['login_admin'] = "<div class='error text-center'>Incorrect username or password</div>";
        //redirect to home page
        header("location:" . SITEURL . 'admin/login.php');
    }
}

?>