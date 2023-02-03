<?php include('partials-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php

if (isset($_SESSION['order'])) {
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}
// if (isset($_SESSION['customer_id'])) {
//     echo $_SESSION['customer_id'];
//     unset($_SESSION['customer_id']);
// }
if (isset($_SESSION['login'])) {
    echo $_SESSION['login']; // display session message
    // unset($_SESSION['login']); // remove the session message
}

?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Featured Categories</h2>

        <?php

        // Create sql to display categories from db
        $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIt 3";
        //exe
        $res = mysqli_query($conn, $sql);
        // COunt rows
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            // category available
            while ($row = mysqli_fetch_assoc($res)) {
                // Get attributes
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];

        ?>

                <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php

                        if ($image_name == "") {
                            //display msg
                            echo "<div class='error'>Image Not available</div>";
                        } else {
                            //image available
                        ?>
                            <img style="height: 475px; width: 375px;" src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                        <?php
                        }

                        ?>

                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                    </div>
                </a>

        <?php
            }
        } else {
            // not available
            echo "<div class='error'>Category Not Available</div>";
        }
        ?>



        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Featured Food</h2>

        <?php

        // Food from db that are active and featured
        $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
        $res2 = mysqli_query($conn, $sql2);

        $count2 = mysqli_num_rows($res2);

        // check food available or not
        if ($count2 > 0) {
            //food available
            while ($row = mysqli_fetch_assoc($res2)) {
                // Get val
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];

        ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php

                        // img avail or not
                        if ($image_name == "") {
                            // not avail
                            echo "<div class='error'>Image not available</div>";
                        } else {
                            // avail
                        ?>
                            <img style="height: 100px ;" src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                        <?php
                        }

                        ?>

                    </div>

                    <form method="post" action="<?php echo SITEURL ?>cart.php?action=add&id=<?php echo $id; ?>">
                        <div class="food-menu-desc">

                            <h4><?php echo $title; ?></h4>
                            <p style="color: grey;"><?php echo $description; ?></p>
                            <h4>Price: <?php echo $price; ?></h4>
                            Quantity: <input type="text" name="quantity" value="1" />
                            <input type="hidden" name="hidden_name" value="<?php echo $title; ?>" />
                            <input type="hidden" name="hidden_img" value="<?php echo $image_name; ?>" />
                            <input type="hidden" name="hidden_price" value="<?php echo $price; ?>" /> <br>
                            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-primary" value="Add to Cart" />
                        </div>
                    </form>
                </div>
        <?php
            }
        } else {
            //food not available
            echo "<div class='error'>Food Not available</div>";
        }

        ?>



        <div class="clearfix"></div>

    </div>

    <p class="text-center">
        <a href="<?php SITEURL ?>foods.php">See All Foods</a>
    </p>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>