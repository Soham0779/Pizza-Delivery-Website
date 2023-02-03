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
        // if (isset($_SESSION['login'])) {
        //     echo $_SESSION['login']; // display session message
        //     unset($_SESSION['login']); // remove the session message
        // }
        // if (isset($_SESSION['no-login-message'])) {
        //     echo $_SESSION['no-login-message']; // display session message
        //     unset($_SESSION['no-login-message']); // remove the session message
        // }
        ?>

        <br><br>

        <!-- Login form starts here -->
        <form action="" method="POST" class="text-center">
            Email: <br>
            <input type="text" name="customer_email" placeholder="Enter your email" value="">
            <br><br>
            Password: <br>
            <input type="password" name="password" placeholder="Enter your password" value="">
            <br><br>

            <!-- <input type="checkbox" name="remember_checkbox"> Remember Me
            <br><br> -->

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>

            <a href="<?php echo SITEURL; ?>login/signup.php">Sign-Up</a><br><br>
        </form>

        <?php

        // check submit button clicked or not
        if (isset($_POST['submit'])) {
            // process for login
            // 1. get the data from login form
            $customer_email = $_POST['customer_email'];
            $password = md5($_POST['password']);

            // 2. SQL query to check user with name and pass exists
            $sql = "SELECT * FROM tbl_customer WHERE customer_email='$customer_email' AND password='$password'";

            // 3. Execute the query
            $res = mysqli_query($conn, $sql);

            // 4. Count rows to check whether the user exist or not
            $count = mysqli_num_rows($res);

            // echo $count;
            // echo $sql;

            if ($count == 1) {

                $row = mysqli_fetch_assoc($res);
                $id = $row['id'];
                $customer_name = $row['customer_name'];
                //user available and login success
                $_SESSION['login'] = "<div class='success'>Hello, <h1>$customer_name </h1></div>";
                $_SESSION['customer_id'] = $id;
                // $_SESSION['user'] = $customer_name; // To check user logged in or not and log out will unset it

                //redirect to home page
                header("location:" . SITEURL . 'index.php');
            } else {
                //user not available
                //user available and login success
                $_SESSION['login'] = "<div class='error text-center'>Incorrect email or password</div>";
                //redirect to home page
                header("location:" . SITEURL . 'login/login.php');
            }
        }

        ?>

        <p class="text-center">Created by Pizzeria</p>
    </div>
</body>

</html>