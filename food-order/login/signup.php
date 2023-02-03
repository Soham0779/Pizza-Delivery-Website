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
        <div class="text-center">
            <h1>Sign-Up</h1>
            <br><br>

            <?php
            // if (isset($_SESSION['add'])) {
            //     echo $_SESSION['add']; // display session message
            //     unset($_SESSION['add']); // remove the session message
            // }
            ?>

            <!-- <input id="text" type="text" name="first_name" placeholder="First Name *"><br><br>
            <input id="text" type="text" name="last_name" placeholder="Last Name *"><br><br>
            <input id="text" type="email" name="email" placeholder="email * e.g. abc@gmail.com"><br><br>
            <input id="text" type="password" name="password" placeholder="enter password *"><br><br>
            <input id="text" type="password" name="confirm_password" placeholder="confirm password *"><br><br>
            <input id="text" type="text" name="contact" pattern="[0-9]{10}" placeholder="mobile_no (It should be 10 digit) *"><br><br> -->

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="customer_name" placeholder="First Name *" required><br><br></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="customer_email" placeholder="email * e.g. abc@gmail.com" required><br><br></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input style="margin-top:10px;" type="password" name="password" pattern=".{8,}" placeholder="enter password (8 or more char) *" required><br><br></td>
                    </tr>
                    <tr>
                        <td>Contact:</td>
                        <td><input style="margin-top:10px;" type="text" name="customer_contact" pattern="[0-9]{10}" placeholder="Enter 10 digit mobile no." required><br><br></td>
                    </tr>  
                        
                    
                </table>

                <input type="submit" name="submit" value="Sign Up" class="btn-secondary"><br><br>

                <a href="<?php echo SITEURL; ?>login/login.php">Login</a>
            </form>

        </div>
    </div>


    <?php
    // process the value from form and save it in database

    // check whether the button is clicked or not

    if (isset($_POST['submit'])) {
        // button Clicked
        // 1. Get the data from form
        $customer_name = $_POST['customer_name'];
        $customer_email = $_POST['customer_email'];
        $password = md5($_POST['password']); // Encryption with md5
        $customer_contact = $_POST['customer_contact'];

        // 2. SQL query to save data in database
        $sql = "INSERT INTO tbl_customer SET
        customer_name = '$customer_name',
        customer_email = '$customer_email',
        password = '$password',
        customer_contact = '$customer_contact'
        ";
        // 3. database connection done in config/constants.php
        // 4. query execution

        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // 5. Check data is inserted or query is executed and display appropriate message
        if ($res == true) {
            //Data inserted
            //Create session variable
            $_SESSION['add'] = "<div class='success'>Customer added successfully </div>";
            //redirect to manage-admin page
            header("location:" . SITEURL . 'login/login.php');
        } else {
            //Failed to insert data
            //Create session variable
            $_SESSION['add'] = "<div class='error'>Failed to add admin </div>";
            //redirect to manage-admin page
            header("location:" . SITEURL . 'login/signup.php');
        }
    }

    ?>


</body>