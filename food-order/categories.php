<?php include('partials-front/menu.php'); ?>



<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods by Categories</h2>

        <?php

        // Display all categories that are active
        $sql = "SELECT * FROM tbl_category where active='Yes'";
        //exe
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        // Check whether caegories available or not
        if ($count > 0) {
            //cat available
            while ($row = mysqli_fetch_assoc($res)) {
                // Get the values
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
        ?>

                <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php 
                        
                        if($image_name==""){
                            //Not available
                            echo "<div class='error'>Image not available</div>";
                        }else{
                            // availble
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
            // Not available
            echo "<div class='error'>Categories not available</div>";
        }

        ?>



        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->


<?php include('partials-front/footer.php'); ?>