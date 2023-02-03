<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css?v=5">
</head>

<body>
    <?php

    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
        // unset($_SESSION['customer_id']);
    }

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
    <div style="margin-left: 250px; margin-bottom: 30px; margin-top: 30px;">
    <p>Customer Name: <?php echo $customer_name ?></p>
    <p>Customer Contact: <?php echo $customer_contact ?></p>
    <p>Customer Email: <?php echo $customer_email ?></p>
    </div>

    <h3 style="margin-left: 200px;">Bill Invoice</h3><br>
    <div class="table-responsive">
        <table class="tbl-30" style="margin-left: 250px;">
            <tr>
                <th width="40%">Item Name</th>
                <th width="10%">Quantity</th>
                <th width="20%">Price</th>
                <th width="15%">Total</th>
                <!-- <th width="5%">Action</th> -->
            </tr>
            <?php

            if (!empty($_SESSION["shopping_cart"])) {
                $total = 0;
                foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            ?>
                    <tr>
                        <td><?php echo $values["item_name"]; ?></td>
                        <td><?php echo $values["item_quantity"]; ?></td>
                        <td>Rs. <?php echo $values["item_price"]; ?></td>
                        <td>Rs. <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                        <!-- <td><a href="cart.php?action=delete&id=<?php //echo $values["item_id"]; 
                                                                    ?>"><span class="text-danger">Remove</span></a></td> -->
                    </tr>
                <?php
                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                }
                ?>
                <tr style="background-color: #E5E4E2;">
                    <td colspan="3" align="right">Total</td>
                    <td align="right">Rs. <?php echo number_format($total, 2); ?></td>

                </tr>
            <?php
            }
            ?>
        </table>
        <br><br>
        <button class="btn btn-primary" style="margin-left: 250px;" onclick="window.print()">Download bill</button>
        <a href="index.php" class="btn btn-primary">Go to Home page</a>

    </div>
    </div>



    <?php include('partials-front/footer.php'); ?>