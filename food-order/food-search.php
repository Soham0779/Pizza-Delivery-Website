<?php include('partials-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <?php

        // Get the search keyword
        $search = $_POST['search'];


        ?>

        <h2>Foods on Your Search <a href="#" class="text-white"><?php echo $search; ?></a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php

        //sql to get food based on search
        $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
        //exe
        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        // check whether food available or not
        if ($count > 0) {
            //food available
            while ($row = mysqli_fetch_assoc($res)) {
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
            //food not availble 
            echo "<div class='error'>Food not found</div>";
        }

        ?>

        <div class="clearfix"></div>



    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>