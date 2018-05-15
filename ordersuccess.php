<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    header("Refresh:2; url=index.php");
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
        <title>Order Success</title>

        <style>
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
        <div class="container">
            <?php
                if (isset($_SESSION['user_email'])){
                    $user_email = $_POST['user_email'];
                    $item_id = $_POST['item_id'];
                    $item_name = $_POST['item_name'];
                    $item_quantity = $_POST['item_quantity'];
                    $total = $_POST['total'];
                    $created = date('Y-m-d H:i A');
                    orderPlace($user_email, $item_id, $item_name, $item_quantity, $total, $created);
                }
                else{
                    session_unset();
                    session_destroy();
                    header('Location:login.php?user=notlogin');
                }
            ?>
        </div>
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
            function orderPlace($uEmail, $itemID, $itemName , $itemQty, $itemTotal, $created_at){
                $conn = database();
                $getUser = $conn->prepare('SELECT * FROM customers WHERE user_email = :user_email');
                $getUser->execute(array(':user_email' => $uEmail));
                $getItem = $conn->prepare('SELECT * FROM item WHERE item_ID = :item_id');
                $getItem->execute(array(':item_id' => $itemID));

                while ($fetchItem = $getItem->fetch(PDO::FETCH_ASSOC)){
                    $itemPrice = $fetchItem['item_price'];
                }
                while ($fetchUser = $getUser->fetch(PDO::FETCH_ASSOC)){
                    $userID = $fetchUser['user_id'];
                }
                $placeOrder = $conn->prepare('INSERT INTO customers_orders (user_id, item_id, item_name, item_price, item_quantity, total, created_at) VALUES (:user_id, :item_id, :item_name, :item_price, :item_quantity, :total, :created_at)');
                $placeOrder->execute(
                    array(
                        ':user_id' => $userID,
                        ':item_id' => $itemID,
                        ':item_name' => $itemName,
                        ':item_price' => $itemPrice,
                        ':item_quantity' => $itemQty,
                        ':total' => $itemTotal,
                        ':created_at' => $created_at
                    )
                );
                echo '
                    <div class="card">
                        <div class="card-content hoverable">
                            <h1>Success <i class="material-icons prefix medium green-text">done</i></h1>
                            <h3>Thank you for purchasing products in Technoflash</h3>
                            <small>Redirecting to my orders....</small>
                        </div>
                    </div>
                ';
            }
        ?>
        <!--JavaScript at end of body for optimized loading-->
        <script src="js/googelcdn.jquery.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>

        <script>
            $(document).ready(function () {
            });
            $(window).on('load', function () {
                $('#preLoad').fadeOut(1000);
            });
        </script>
    </body>
</html>