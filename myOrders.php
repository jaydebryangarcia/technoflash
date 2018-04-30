<?php
    ob_start();
    session_start();
    date_default_timezone_set('Asia/Manila');
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

        <link rel="icon" href="images/Micromatech.png">
        <title>Order Success</title>

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
        </style>
    </head>
    <body>
        <div id="preLoad">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-green">
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
        <!--Navigation-->
        <nav id="navigation" class="nav-extended blue">
            <div class="nav-wrapper container black-text">
                <a href="index.php" class="brand-logo"><img class="responsive-img" src="images/Micromatechv2.png" alt=""  style="width: 220px; height: auto"></a>
                <a href="" data-target="mobile-demo" class="sidenav-trigger" id="sideNavTrigger"><i class="material-icons right">menu</i></a>
                <!-- User Panel or Login Modal -->
                <ul class="right hide-on-med-and-down">
                    <!--User Login Status-->
                    <?php
                        if (isset($_SESSION['user_email'])){
                            $email = $_SESSION['user_email'];
                            $pass = $_SESSION['user_password'];
                            userSession($email, $pass);
                        }
                        else{
                            session_unset();
                            session_destroy();
                            header('Location:login.php?user=notlogin');
                        }
                    ?>
                    <li><a href="index.php">Shop<i class="material-icons right prefix">arrow_forward</i></a></li>
                </ul>
                <!--Side Nav Trigger-->
                <ul class="sidenav" id="mobile-demo">
                    <div class="container">
                        <div class="card-image" style="padding-bottom: 1%">
                            <img src="images/Micromatechv2.png" alt="" class="responsive-img" width="300px" style="display: block; height: auto; width: 100%">
                        </div>
                        <li><a href="myAccount.php">My Account</a></li>
                        <li><a href="myOrders.php">My Orders</a></li>
                        <li><a href="logout.php">My Logout</a></li>
                        <li><a href="index.php">Shop</a></li>
                    </div>
                </ul>
            </div>
            <!-- Dropdown Structure -->
            <ul id="userAccountOption" class="dropdown-content">
                <li><a href="myAccount.php" >Account</a></li>
                <li><a href="myOrders.php">My Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="container">

            <?php
                if (isset($_GET['dialog'])){
                    $deleteUserId = $_GET['user_id'];
                    $deleteItemId = $_GET['item_id'];
                    dialogDelete($deleteUserId, $deleteItemId);
                }
                if (isset($_GET['delete'])){
                    $delUserID = $_GET['user_id'];
                    $delItemID = $_GET['item_id'];
                    delete($delUserID, $delItemID);
                }
                showOrders($email);
            ?>
        </div>

        <?php
            function database(){
                $host = 'mysql:host=localhost;dbname=micromatech';
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
            function userSession($sessionEmail, $sessionPassword){
                $conn = database();
                $selectUser = $conn->prepare('SELECT * FROM customers WHERE user_email = :user_email AND user_password = :user_password');
                $selectUser->execute(array(':user_email' => $sessionEmail, ':user_password' => $sessionPassword));
                $selectUserResult = $selectUser->rowCount();
                if ($selectUserResult > 0){
                    while ($getName = $selectUser->fetch(PDO::FETCH_ASSOC)){
                        $userName = $getName['user_name'];
                    }
                    echo '<li><a class="dropdown-trigger" data-target="userAccountOption">'.$userName.'</a></li>';
                }
            }
            function showOrders($userEmail){
                $conn = database();
                $selectUser = $conn->prepare('SELECT * FROM customers WHERE user_email = :user_email');
                $selectUser->execute(array(':user_email' =>$userEmail));
                $selectUserResult = $selectUser->rowCount();
                if ($selectUserResult > 0){
                    while ($fetchUser = $selectUser->fetch(PDO::FETCH_ASSOC)){
                        $user_id = $fetchUser['user_id'];
                        $showOrders = $conn->prepare('SELECT * FROM customers_orders INNER JOIN item ON customers_orders.item_id = item.item_id WHERE customers_orders.user_id = :user_id');
                        $showOrders->execute(array(':user_id' => $user_id));
                        while ($fetchOrders = $showOrders->fetch(PDO::FETCH_ASSOC)){
                            $item_id = $fetchOrders['item_id'];
                            $item_name = $fetchOrders['item_name'];
                            $item_price = $fetchOrders['item_price'];
                            $item_quantity =$fetchOrders['item_quantity'];
                            $item_total = $fetchOrders['total'];
                            $img = $fetchOrders['item_image'];
                            $order_at = $fetchOrders['created_at'];
                            echo '
                                <div class="card hoverable">
                                    <div class="row">
                                        <div class="col s12 m4 l2">
                                            <img src="data:image;base64,'.$img.'" alt="" class="responsive-img">
                                        </div>
                                        <div class="col s12 m8 l10">
                                            <h5>Title: '.$item_name.'</h5>
                                            <p>Price: '.$item_price.'</p>
                                            <p>Quantity: '.$item_quantity.'</p>
                                            <p>Total: '.$item_total.'</p>
                                            <small>'.$order_at.'</small>
                                            <a href="myOrders.php?&user_id='.$user_id.'&item_id='.$item_id.'&dialog=show" class="right">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            ';

                        }
                    }
                }
            }
            function dialogDelete($user_id, $item_id){
                echo '
                    <div class="card" id="deleteDialog">
                        <div class="row center-align">
                            <p class="flow-text">Are you sure you want to delete?</p>
                            <a href="myOrders.php?user_id='.$user_id.'&item_id='.$item_id.'&delete=yes" class="btn btn-large green">YES</a>
                            <a href="myOrders.php" class="btn btn-large red">NO</a>
                        </div>
                    </div>
                ';
            }
            function delete($deleteUser_id, $deleteItem_id){
                $conn = database();
                $deleteItem = $conn->prepare('DELETE FROM customers_orders WHERE user_id = :user_id AND item_id = :item_id');
                $deleteItem->execute(array(':user_id' => $deleteUser_id, ':item_id' => $deleteItem_id));
                echo '
                    <div class="card" id="deleteSuccess">
                        <div class="row center-align">
                            <p class="flow-text green-text">Order Deleted!</p>
                        </div>
                    </div>
                ';
                header("Refresh:2; url:myOrders.php");
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

                $('#deleteSuccess').delay(1500).fadeOut(1000);
            });
            $(window).on('load', function () {
                $('#preLoad').fadeOut(1000);
            });
        </script>
    </body>
</html>