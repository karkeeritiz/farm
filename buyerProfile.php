<?php

ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

include_once "resource/session.php";


include_once "resource/database.php";


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

<body style="padding-top: 0px;">

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
                    <a href="cart.php?page=1">x<strong>Buy Products</strong></a>
                </li>
                <li>
                    <a href="logout.php"><strong>Logout</strong></a>
                </li>

            </ul>
        </div>
    </div>
</nav>
</br>

</br>
</br>
<div class="container">
    <header class="jumbotron hero-spacer"
            style="background: url(assets/img/background.jpg); margin-top: 0px; background-size: cover; height: 200px;">
        <h1 align="center"
            style="color: white; margin-bottom: 0px;"><?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?> </h1>
        <?php
        $sql = "SELECT * FROM Users WHERE `username` = '$_SESSION[username]' ";
        $run_user = mysqli_query($conn, $sql);


        $check_user = mysqli_num_rows($run_user);

        if ($check_user > 0) {
            while ($row = mysqli_fetch_array($run_user)) {

                ?>

                <h3 align="center" style="color: white; margin-top: 0px;"><?php echo $row["email"]; ?></h3>
                <?php
            }
        }
        ?>
    </header>


    <div class="row text-center">
        <div style="float: right; display: inline-block; padding-right: 20px;">
        </div>

        <div class="table table-responsive" id="pending">
            <h1 align="left">Pending Deliveries</h1>

            <table class="table table-bordered">
                <tr>
                    <th width="10%">Order ID</th>
                    <th width="13%">Category</th>
                    <th width="20%">Quantity (Price)</th>
                    <th width="10%">Total Price</th>
                    <th width="10%">Status</th>

                </tr>

                <?php

                try {
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        $sql = "SELECT * FROM `order` 
					WHERE `Buyer` = '$username'";

                        $result = mysqli_query($conn, $sql);


                        $check_user = mysqli_num_rows($result);


                        if (($check_user) > 0) {

                            while ($row = mysqli_fetch_array($result)) {

                                ?>

                                <tr>
                                    <td><?php echo $row["orderid"]; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['quantity']; ?> ($<?php echo $row['price']; ?>)</td>
                                    <td>$<?php echo $row['quantity'] * $row['price']; ?></td>

                                    <td><strong style="color: red;"><?php echo $row["status"] ?><br/>
                                    </td>
                                </tr>


                            <?php
                            if (isset($_POST['update'])){
                            $sql = "UPDATE `register`.`order` SET `status` = 'DELIVERED' WHERE `order`.`id` = '$_POST[hiddenid]'  ";
                            $check = mysqli_query($conn, $sql);

                            if ($check){
                            ?>
                                <script type="text/javascript">
                                    alert("Update Successful");
                                    window.location.href = "buyerProfile.php";

                                </script>
                                <?php
                            }
                            }

                            }

                        }

                    }

                } catch (Exception $exception) {
                    die($exception->getMessage());
                }


                ?>

            </table>
            </br>

        </div>


    </div>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!--	<script src = "showhide.js"></script>-->
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


</div>
<div style="padding: 1em 0 2em 0;">

    <footer id="footer" class="container" style="background: #fff; color: black; width: 100%; ">
        <hr style="border-top: 1px solid #ccc;">
        <br/><br/><br/>
        <p align="center">Contact Us: (234) 8133936723
            &copy; FarmConnect. All rights reserved</p>

    </footer>

</div>


</body>

</html>