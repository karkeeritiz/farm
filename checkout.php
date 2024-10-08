<?php

include_once "resource/session.php";
include_once "resource/database.php";
$finalPrice = 0;
$priceInd = "$ ";
$deliveryCharge = 50;
if (isset($_POST["orderProduct"])) {

    $id = $_SESSION["orderid"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $mobile = $_POST["mobile"];
    $address = $_POST["address"];
    $near = $_POST["near"];
    $state = $_POST["state"];
    $city = $_POST["city"];

    if ($_POST["state"] == "Select State") {
        ?>
        <script type="text/javascript">
            alert("Please Select a State");
        </script>

        <?php
    } else {
        $payment = 2000 + $_SESSION["total"];
        $sql = "INSERT INTO delivery(id, firstname, lastname, mobile, address, city, near, price, state, status) 
				VALUES('$id', '$fname', '$lname', '$mobile', '$address', '$city', '$near', '$payment',  '$state','PENDING')";

        $result = mysqli_query($conn, $sql);
        echo $sql;

        if ($result) {
            ?>
            <script type="text/javascript">
                alert("Successful Order");
                window.location.href = "buyerProfile.php";
            </script>
            <?php
        } else {
            echo $sql;
        }

    }


}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Farm Connect: Buy and Sell Raw Product Online</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="css/heroic-features.css" rel="stylesheet">


</head>

<body style="padding-top: 30px;">

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><strong>Farm Connect</strong></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="buyerProfile.php" style="padding-right: 100px;"><strong>View Profile</strong></a>
                </li>

                <li>
                    <a href="logout.php" style="padding-right: 391px;">Logout</a>

                <li>
                    <?php
                    if (!isset($_SESSION["shopping_cart"])) {
                        $count = 0;
                    } else {
                        $count = count($_SESSION["shopping_cart"]);
                    }
                    ?>
                    <a id="viewcart" class="cart" style="cursor: pointer; color: #f9a023;"><i class=" fa fa-cart-plus"
                                                                                              style="color:#f9a023; height: 30%; "></i>
                        <strong> <?php echo $count; ?> Item(s)</strong></a>
                </li>
                <li style="padding-top: 10px;">
                    <form method="post">

                        <button name="checkout" class="btn" style="float: right; background: #f9a023;"><strong>Proceed
                                to CheckOut</strong></button>

                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>
</br>

</br>
</br>


<div class="container">

    <div class="row text-center" style="border: outset; ">

        <div class="table-responsive" id="tbl_cart" style="width : 75% ;padding: 30px;">
            <h1 align="left">Items In Cart</h1>
            <table class="table table-bordered">
                <tr>
                    <th width="10%">Item</th>
                    <th width="20%">Item Name</th>
                    <th width="5%">Quantity</th>
                    <th width="20%">Price</th>
                    <th width="10%">Seller</th>

                </tr>
                <?php
                $sql = "SELECT order.category, order.quantity, order.price, products.image, products.CompanyName FROM `order`, `products` WHERE 
			order.Buyer = '$_SESSION[username]' AND products.id = order.productid ";
                $run_user = mysqli_query($conn, $sql);

                $check_user = mysqli_num_rows($run_user);

                if ($check_user > 0) {
                    while ($row = mysqli_fetch_array($run_user)) {
                        $finalPrice+=$row["price"];
                        ?>


                        <tr>
                            <th width="10%"><?php echo '<img  style = " border-radius: 10px;height: 45px; width: 45px;"src = "data:image/jpeg;base64,' . base64_encode($row["image"]) . '">'; ?></th>
                            <th width="20%"><?php echo $row["category"]; ?></th>
                            <th width="5%"><?php echo $row["quantity"]; ?></th>
                            <th width="20%"><?php echo $row["price"]; ?></th>
                            <th width="20%" style="color: purple;"><?php echo $row["CompanyName"]; ?></th>

                        </tr>
                        <?php
                    }
                }
                ?>


            </table>
        </div>

    </div>
    <br/>
    <br/>


</div>

<div class="container">

    <div class="row text-center" style="border: outset; ">
        <div style="padding: 20px;">
            <h1 align="left">Checkout</h1>

            <div style="border-top: ridge; border-bottom: ridge;  width: 95%; ">
                <div style="border-bottom: ridge;">
                    <h3 align="left" style="color: purple;">Add Delievry Address <b style="color: #ffbe58;">(Pay On
                            Delivery)</b></h3>
                    <p style="float: right; color: grey;"><i>Your delivery address determines delivery charges</i></p>
                    <br/>
                </div>

                <br/>
                <div style="width: 65%; padding-left: 30px; ">
                    <form method="post">
                        <div class="form-group ">
                            <input type="text" class="form-control" minlength="3" placeholder="Firstname" name="fname"
                                   required>
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="form-group ">
                            <input type="text" class="form-control" minlength="6" placeholder="Lastname" name="lname"
                                   required>
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="form-group ">
                            <input type="text" class="form-control" minlength="11" placeholder="Mobile Number"
                                   name="mobile" required>
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="form-group ">
                            <input type="text" class="form-control" minlength="10" placeholder="Street Address"
                                   name="address" required>
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="form-group ">
                            <input type="text" class="form-control" minlength="5" placeholder="City" name="city"
                                   required>
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="form-group ">
                            <input type="text" class="form-control" minlength="10"
                                   placeholder="Opposite, Next to, Near By..." name="near" required>
                            <i class="fa fa-user"></i>
                        </div>


                        <div class="form-group ">
                            <select name="state" style="width: 100%;" required>
                                <option value="Select State">Select State</option>
                                <option value="Abia">Abia</option>
                                <option value="Adamawa">Adamawa</option>
                                <option value="Akwa Ibom">Akwa Ibom</option>
                                <option value="Bauchi">Bauchi</option>
                                <option value="Bauchi">Bauchi</option>
                                <option value="Bayelsa">Bayelsa</option>
                                <option value="Benue">Benue</option>
                                <option value="Borno">Borno</option>
                                <option value="Cross River">Cross River</option>
                                <option value="Delta">Delta</option>
                                <option value="Ebonyi">Ebonyi</option>
                                <option value="Enugu">Enugu</option>
                                <option value="Edo">Edo</option>
                                <option value="Ekiti">Ekiti</option>
                                <option value="Gombe">Gombe</option>
                                <option value="Imo">Imo</option>
                                <option value="Jigawa">Jigawa</option>
                                <option value="Kaduna">Kaduna</option>
                                <option value="Kano">Kano</option>
                                <option value="Kastina">Kastina</option>
                                <option value="Kebbi">Kebbi</option>
                                <option value="Kogi">Kogi</option>
                                <option value="Kwara">Kwara</option>
                                <option value="Lagos">Lagos</option>
                                <option value="Nasarawa">Nasarawa</option>
                                <option value="Niger">Niger</option>
                                <option value="Ogun">Ogun</option>
                                <option value="Ondo">Ondo</option>
                                <option value="Osun">Osun</option>
                                <option value="Oyo">Oyo</option>
                                <option value="Plateau">Plateau</option>
                                <option value="Rivers">Rivers</option>
                                <option value="Sokoto">Sokoto</option>
                                <option value="Taraba">Taraba</option>
                                <option value="Yobe">Yobe</option>
                                <option value="Zamfara">Zamfara</option>
                                <option value="FCT(Abuja)">FCT(Abuja)</option>

                            </select>
                            <i class="fa fa-user"></i>
                        </div>


                </div>

            </div>

        </div>


    </div>
    <br/>
    <br/>


</div>
<div class="order"
     style=" height: 200px; background: #333; opacity: 0.7; filter:alpha (opacity =70); padding-left: 50px; padding-right: 50px; padding-top: 20px;">
    <div style="float: left; width: 40%; border: 2px solid #fff; border-radius: 5px; padding-left: 10px;padding-right: 10px;  margin-bottom: 20px;">
        <h3 style="color: #ff8400;">Order Summary</h3>
        <p style="color: #fff;">Purchase Bill: <?php echo $priceInd?><?php echo number_format($finalPrice, 2); ?><br/>
            Delivery Charges: <?php echo $priceInd?><?php
            echo number_format($deliveryCharge, 2); ?><br/><br/>
            TOTAL: <?php echo $priceInd?><?php echo number_format($deliveryCharge + $finalPrice, 2) ?>

        </p>

    </div>
    <div style="float: right; color: #fff; width: 50%;" align="right">
        <p>
        <h3 style="color: #ff8400;"><strong><?php echo $priceInd?><?php echo number_format($deliveryCharge + $finalPrice, 2) ?></strong></h3>
        <button name="orderProduct" type="submit" class="btn btn-primary"
                style="text-shadow: none;height: 50px; color: #fff; font-size:20px; border-radius:5px; background: #333;">
            Order Now
        </button>

        </p></div>
</div>

</form>

<div style="padding: 1em 0 2em 0;">

    <footer id="footer" class="container" style="background: #fff; color: black; width: 100%; ">
        <hr style="border-top: 1px solid #ccc;">
        <br/><br/><br/>
        <p align="center">Contact Us: (234) 8133936723
            &copy; FarmConnect. All rights reserved</p>

    </footer>

</div>

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>