<?php include('partials-front/menu.php'); ?>

<?php
ob_start();
// check food id is set or not
if (isset($_GET['food_id'])) {
    // get food id and details
    $food_id = $_GET['food_id'];

    // print_r($food_id);

    //     foreach ($_SESSION["shopping_cart"] as $keys => $values) {

    //         $fid = $values['item_id'];

    //         // get details
    //         $sql = "SELECT * FROM tbl_food WHERE id=$fid";
    //         $res = mysqli_query($conn, $sql);
    //         $count = mysqli_num_rows($res);

    //         //check whether data is available
    //         if ($count == 1) {
    //             // we have data
    //             // get data from db
    //             $row = mysqli_fetch_assoc($res);
    //             $title = $row['title'];
    //             $price = $row['price'];
    //             $image_name = $row['image_name'];
    //         } else {
    //             // food not available
    //             header('location:' . SITEURL);
    //         }
    //     }
    // } else {
    //     //redirect
    //     header('location:' . SITEURL);
}

?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>
                <?php
                if (!empty($_SESSION["shopping_cart"])) {
                    $total = 0;
                    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                ?>
                        <table class="tbl-30">
                            <tr style="margin: 0px; padding:0px;">
                                <td class="food-menu-img">
                                    <?php

                                    // img avail or not
                                    if ($values["item_img"] == "") {
                                        // not avail
                                        echo "<div class='error'>Image not available</div>";
                                    } else {
                                        // avail
                                    ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $values["item_img"] ?>" alt="Pizza" style="height:70px; width: 70px; border-radius:10px;">
                                    <?php
                                    }

                                    ?>

                                </td>

                                <td style="padding-right: 30px; padding-left: 30px;"> <b>Title: </b><?php echo $values["item_name"]; ?></td><br>
                                <td style="padding-right: 30px;"><b>Qty: </b><?php echo $values["item_quantity"]; ?></td><br>
                                <td style="padding-right: 30px;"><b>Price: </b>Rs. <?php echo $values["item_price"]; ?></td><br>
                                <td style="padding-right: 30px;"><b>Total: </b>Rs. <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>


                            </tr>
                        </table>
                    <?php
                        $total = $total + ($values["item_quantity"] * $values["item_price"]);
                    }
                    ?>
                    <tr>
                        <br><br>
                        <td colspan="3" align="right">Total</td>
                        <td align="right">Rs. <?php echo number_format($total, 2); ?></td>
                        <td></td>
                    </tr>
                <?php
                }
                ?>

            </fieldset>

            <?php

            if (isset($_SESSION['customer_id'])) {
                $customer_id = $_SESSION['customer_id'];
                // unset($_SESSION['customer_id']);


                $sql2 = "SELECT * FROM tbl_customer WHERE id=$customer_id";
                $res2 = mysqli_query($conn, $sql2);
                // echo $sql2;
                $count = mysqli_num_rows($res2);
                if ($count == 1) {
                    $row2 = mysqli_fetch_assoc($res2);
                    $customer_name = $row2['customer_name'];
                    $customer_contact = $row2['customer_contact'];
                    $customer_email = $row2['customer_email'];
                }
            ?>

                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Enter your name" class="input-responsive" value="<?php if (isset($_SESSION['customer_id'])) {
                                                                                                                            echo $customer_name;
                                                                                                                        } ?>" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" value="<?php if (isset($_SESSION['customer_id'])) {
                                                                                                                        echo $customer_contact;
                                                                                                                    } ?>" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@abc.com" class="input-responsive" value="<?php if (isset($_SESSION['customer_id'])) {
                                                                                                                        echo $customer_email;
                                                                                                                    } ?>" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>
                    <a href="<?php echo SITEURL; ?>bill.php">
                        <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                    </a>
                </fieldset>

            <?php

            } else {
                echo "<h1 class='error'>Please login first</div>";
            }

            ?>

        </form>

        <?php
        if (isset($_POST['submit'])) {
            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                $food = $values['item_name'];
                $price = $values['item_price'];
                $qty = $values['item_quantity'];
                $total = $price * $qty;
                $order_date = date("Y-m-d h:i:sa");
                $status = "Ordered"; // ordered, on delivery, delivered, cancelled
                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];

                //save order in db
                $sql2 = "INSERT INTO tbl_order SET 
                food='$food',
                price=$price,
                qty=$qty,
                total=$total,
                order_date='$order_date',
                status='$status',
                customer_id='$customer_id',
                customer_name='$customer_name',
                customer_contact='$customer_contact',
                customer_email='$customer_email',
                customer_address='$customer_address'
            ";

                // echo $sql2;die();

                $res2 = mysqli_query($conn, $sql2);
            }
            if ($res2 == true) {
                //qry exe
                $_SESSION['order'] = "<div class='success text-center'>Food order placed successfully</div>";
                header('location:' . SITEURL . "bill.php");
            } else {
                // failed
                $_SESSION['order'] = "<div class='error text-center'>Failed to order food</div>";
                header('location:' . SITEURL);
            }
        }


        // //check submit button is clicked or not
        // if (isset($_POST['submit'])) {

        //     // Get all details from form
        //     $food = $_POST['food'];
        //     $price = $_POST['price'];
        //     $qty = $_POST['qty'];
        //     $total = $price * $qty;
        //     $order_date = date("Y-m-d h:i:sa");
        //     $status = "Ordered"; // ordered, on delivery, delivered, cancelled
        //     $customer_name = $_POST['full-name'];
        //     $customer_contact = $_POST['contact'];
        //     $customer_email = $_POST['email'];
        //     $customer_address = $_POST['address'];

        //     //save order in db
        //     $sql2 = "INSERT INTO tbl_order SET 
        //         food='$food',
        //         price=$price,
        //         qty=$qty,
        //         total=$total,
        //         order_date='$order_date',
        //         status='$status',
        //         customer_id='$customer_id',
        //         customer_name='$customer_name',
        //         customer_contact='$customer_contact',
        //         customer_email='$customer_email',
        //         customer_address='$customer_address'
        //     ";

        //     // echo $sql2;die();

        //     $res2 = mysqli_query($conn, $sql2);

        //     if ($res2 == true) {
        //         //qry exe
        //         $_SESSION['order'] = "<div class='success text-center'>Food order placed successfully</div>";
        //         header('location:' . SITEURL);
        //     } else {
        //         // failed
        //         $_SESSION['order'] = "<div class='error text-center'>Failed to order food</div>";
        //         header('location:' . SITEURL);
        //     }
        // }

        ?>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->


<?php include('partials-front/footer.php'); ?>