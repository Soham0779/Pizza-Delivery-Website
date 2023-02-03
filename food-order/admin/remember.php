<?php

include('../config/constants.php');

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pass = md5($password);

    // Check login
    $sql = "SELECT * from tbl_admin WHERE username='$username' AND password='$pass'";

    $res = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($res);

    if ($row > 0) {
        //session
        $data = mysqli_fetch_assoc($res);
        $_SESSION['id'] = $data['id'];

        if (!empty($_POST['remember_checkbox'])) {
            // check checkbox
            $remember_checkbox = $_POST['remember_checkbox'];

            // set cookie
            setcookie('username',$username,time()+3600*24*7);
            setcookie('password',$password,time()+3600*24*7);
        }else{
            //expire cookie
            setcookie('username',$username,30);
            setcookie('password',$password,30);
        }
        // redirect
        // header("location:" . SITEURL . 'admin/');
    } else {
        echo "Invalid login";
    }
}
