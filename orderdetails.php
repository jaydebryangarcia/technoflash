<?php
    ob_start();
    date_default_timezone_set('Asia/Manila');
    session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <!--Import Google JQuery-->
        <script src="js/googelcdn.jquery.min.js"></script>

        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="icon" href="images/technoflash.jpg">
        <title>Order Review</title>
        <style>
            img{
                padding: 5px;
                width: 150px;
            }
            #preLoad{
                background-color: rgba(255,255,255,0.65);
                text-align: center;
                padding: 20%;
                width: 100%;
                height: 100%;
                position: absolute;
                z-index: 4;
            }
            body{
                background-image: url("images/b1.jpg");
                background-repeat: repeat;
            }
        </style>
    </head>
    <body>
        <div id="preLoad">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <!--Navigation-->
            <nav id="navigation" class="nav-extended red">
                <div class="nav-wrapper container black-text">
                    <a href="index.php" class="brand-logo"><img class="responsive-img" src="images/technoflash.jpg" alt=""  style="width: 60px; height: auto"></a>
                    <a href="" data-target="mobile-demo" class="sidenav-trigger" id="sideNavTrigger"><i class="material-icons right">menu</i></a>
                    <ul class="right hide-on-med-and-down">
                        <!--User Login Status-->
                        <?php
                            if (isset($_SESSION['user_email'])){
                                $post_email = $_SESSION['user_email'];
                                $post_pass = $_SESSION['user_password'];
                                $post_quantity = $_POST['quantity'];
                                $post_id = $_POST['id'];
                                userSession($post_email);
                            }
                            else{
                                session_unset();
                                session_destroy();
                                header('Location:login.php?user=notlogin');
                            }
                        ?>
                    </ul>
                    <!--Side Nav Trigger-->
                    <ul class="sidenav" id="mobile-demo">
                        <div class="container">
                            <div class="card-image" style="padding-bottom: 1%">
                                <img src="images/technoflash.jpg" alt="" class="responsive-img" width="300px" style="display: block; height: auto; width: 100%">
                            </div>
                            <!-- Modal Trigger -->
                            <?php
                                if (isset($_SESSION['user_email'])){
                                    echo '
                                        <li><a href="myOrders.php" class="modal-trigger"><i class="material-icons left">shopping_cart</i>My Orders</a></li>
                                        <li><a href="logout.php" class="modal-trigger"><i class="material-icons left">arrow_forward</i>Logout</a></li>
                                    ';
                                }
                                else{
                                    echo '<li><a href="#loginModal" class="modal-trigger"><i class="material-icons left">account_circle</i>Login</a></li>';
                                }
                            ?>
                        </div>
                    </ul>
                    <ul class="right">
                        <li><a href="index.php">Back to shop<i class="material-icons prefix right">arrow_forward</i></a></li>
                    </ul>
                </div>
                <!-- Dropdown Structure -->
                <ul id="userAccountOption" class="dropdown-content">
                    <li><a href="myOrders.php">My Orders</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>

            <!--Content-->
            <div class="container" style="padding-left: 4%; padding-right: 4%">
                <div class="card">
                    <div class="card-title">
                        <h3>Order Sumary</h3>
                    </div>
                    <div class="card-content">
                        <?php showDetail($post_id, $post_quantity, $post_email); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--PHP Logic-->
        <?php
            function database(){
                $host = 'mysql:host=localhost;dbname=technoflash';
                $dbUsername = 'root';
                $dbPassword = '';
                try{
                    $conn = new PDO($host, $dbUsername, $dbPassword);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $conn;
                }
                catch (PDOException $e){
                    echo 'Connection Error at: '. $e->getMessage();
                }
            }
            function showDetail($id, $qty, $user){
                $conn = database();
                $selectItem = $conn->prepare('SELECT * FROM item WHERE item_id = :item_id');
                $selectItem->execute(array(':item_id' => $id));
                while ($fetch = $selectItem->fetch(PDO::FETCH_ASSOC)){
                    $id = $fetch['item_id'];
                    $name = $fetch['item_name'];
                    $price = $fetch['item_price'];
                    $description = $fetch['item_description'];
                    $img = $fetch['item_image'];
                    $category = $fetch['item_category'];
                    $created_at = $fetch['created_at'];
                    $total = $price * $qty;
                    echo '
                        <h5>Product Name: <text class="teal-text">'.$name.'</text></h5>
                        <h5>Price: <text class="teal-text">'.$price.'</text></h5>
                        <h5>Quantity: <text class="teal-text">'.$qty.'</text></h5>
                        <h5>Total: <text class="teal-text">'.$total.'</text></h5>
                        <hr>
                        <form action="ordersuccess.php" method="post">
                            <input type="hidden" name="user_email" value="'.$user.'">
                            <input type="hidden" name="item_name" value="'.$name.'">
                            <input type="hidden" name="item_id" value="'.$id.'">
                            <input type="hidden" name="item_quantity" value="'.$qty.'">
                            <input type="hidden" name="total" value="'.$total.'">
                            <button type="submit" name="placeOrder" value="ok" class="btn btn-block btn-large">
                                Place Order<i class="material-icons right">send</i>
                            </button>
                        </form>
                        
                    ';
                }
            }
            function userSession($sessionEmail){
                $conn = database();
                $selectUser = $conn->prepare('SELECT * FROM customers WHERE user_email = :user_email');
                $selectUser->execute(array(':user_email' => $sessionEmail));
                $selectUserResult = $selectUser->rowCount();
                if ($selectUserResult > 0){
                    while ($getName = $selectUser->fetch(PDO::FETCH_ASSOC)){
                        $userName = $getName['user_name'];
                    }
                    echo '<li><a class="dropdown-trigger" data-target="userAccountOption">'.$userName.'</a></li>';
                }
            }
        ?>
        <!--JavaScript at end of body for optimized loading-->
        <script src="js/googelcdn.jquery.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>

        <script>
            $(document).ready(function () {
                $('.tooltipped').tooltip();
                $('.sidenav').sidenav();
                $('.collapsible').collapsible();
                $('.modal').modal();
                $('.dropdown-trigger').dropdown();
            });
            $(window).on('load', function () {
                $('#preLoad').fadeOut(1000);
            });
        </script>
    </body>
</html>

