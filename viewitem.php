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

        <link rel="icon" href="images/Micromatech.png">
        <title>View Item</title>
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
        <div>
            <!--Navigation-->
            <nav id="navigation" class="nav-extended green">
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
                                userSession($email);
                            }
                            else{
                                echo '
                                    <li>
                                        <a href="#loginModal" class="modal-trigger">
                                        <i class="material-icons right">account_circle</i>Login</a>
                                    </li>
                                ';
                            }
                        ?>
                        <li><a href="index.php">Shop <i class="material-icons prefix right">arrow_forward</i></a></li>
                    </ul>
                    <!--Search Button-->
                    <ul class="right">
                        <li><a id="searchToggle"><i class="material-icons right">search</i></a></li>
                    </ul>
                    <!--Side Nav Trigger-->
                    <ul class="sidenav" id="mobile-demo">
                        <div class="container">
                            <div class="card-image" style="padding-bottom: 1%">
                                <img src="images/Micromatechv2.png" alt="" class="responsive-img" width="300px" style="display: block; height: auto; width: 100%">
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
                </div>
                <!--Search Engine-->
                <div class="nav-content container" id="searchBar" style="display: none">
                    <!--Search Bar-->
                    <div class="input-field text-darken-1" id="search">
                        <input id="searchBox" type="text" class="validate" name="searchBox">
                        <label for="searchBox" class="black-text">Search Here</label>
                    </div>
                    <!--Search Content-->
                    <div class="collection" id="searchResult">
                    </div>
                </div>
                <!-- Dropdown Structure -->
                <ul id="userAccountOption" class="dropdown-content">
                    <li><a href="myOrders.php" class="tooltipped" data-position="left" data-tooltip="My Orders">My Orders</a></li>
                    <li><a href="logout.php" class="tooltipped" data-position="left" data-tooltip="Logout">Logout</a></li>
                </ul>
            </nav>

            <!-- Modal Login Form -->
            <div id="loginModal" class="modal">
                <div class="modal-content">
                    <h4>
                        <img src="images/Micromatechv2.png" alt="" style="width: 220px; height: auto">
                        <a class="btn btn-floating modal-action modal-close waves-effect waves-green red right"><i class="material-icons">close</i></a>
                    </h4>
                    <small>Enter your email & password to login</small>
                    <div class="divider"></div>
                    <form class="col s12" method="post" action="index.php">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix left">account_circle</i>
                                <input id="email" type="email" class="validate" name="userEmail">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix left">vpn_key</i>
                                <input id="password" type="password" class="validate" name="userPassword">
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-large green right black-text" name="loginButton" value="ok">
                                Login<i class="material-icons prefix right">send</i>
                            </button>
                            <a href="register.php" class="btn btn-large orange accent-2 left black-text"><i class="material-icons prefix right">create</i> Register</a>
                        </div>
                    </form>
                </div>
            </div>
            <!--Submit Login PHP-->
            <?php
                if (isset($_POST['loginButton'])){
                    $userEmail = $_POST['userEmail'];
                    $userPassword = md5($_POST['userPassword']);
                    login($userEmail, $userPassword);
                }
            ?>
            <!--Content-->
            <div class="row">
                <?php
                    if (isset($_GET['id'])&&isset($_GET['price'])){
                        $itemId = $_GET['id'];
                        $itemPrice = $_GET['price'];
                        showItemDetails($itemId);
                    }
                    else {
                        header('Location: index.php');
                    }
                ?>
            </div>
        </div>
        <!--PHP Logic-->
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
            function showItemDetails($id){
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
                    echo '
                        <div class="col s12 m6 l6">
                            <div class="card hoverable">
                                <img src="data:image;base64,'.$img.'" class="responsive-img" style="width: 100%; height: auto">
                            </div>
                        </div>
                        <div class="col s12 m6 l6">
                            <div class="card hoverable">
                                <div class="card-title">
                                    <h4>'.$name.'</h4><small>'.$created_at.'</small>
                                    <h5>Price: <text class="green-text">'.$price.'</text></h5>
                                </div>
                                <div class="divider"></div>
                                <div class="card-content">
                                    <h5>Description</h5>
                                    <p>'.$description.'</p>
                                    <small>Category: '.$category.'</small>
                                    <div class="divider"></div>
                                    <br>
                                    <div class="row">
                                        <form action="orderdetails.php" method="post">
                                            <div class="input-field col s12 m12 l6">
                                                <i class="material-icons prefix left">add_shopping_cart</i>
                                                <input id="quantity" type="number" class="validate" required name="quantity">
                                                <label for="quantity">Quantity</label>
                                            </div>
                                            <div class="col s12 m12 l6">
                                                <h5>Total: <text id="total"></text></h5>
                                            </div>
                                            <hr>
                                            <input type="hidden" value="'.$id.'" name="id">
                                            <input type="hidden" value="'.$price.'" name="price">
                                            <button type="submit" class="btn btn-large btn-block green waves-effect waves-light" name="buy" value="ok">Checkout<i class="material-icons prefix right">send</i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            function login($email, $password){
                $conn = database();
                $selectUser = $conn->prepare('SELECT * FROM customers WHERE user_email = :user_email AND user_password = :user_password');
                $selectUser->execute(array(':user_email' => $email, ':user_password' => $password));
                $selectUserResult = $selectUser->rowCount();
                if ($selectUserResult > 0){
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_password'] = $password;
                }
                else{
                    header('Location:login.php?user=notfound');
                }
            }
        ?>
        <!--JavaScript at end of body for optimized loading-->
        <script src="js/googelcdn.jquery.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#searchBox').on('keyup', function () {
                    var txt = $(this).val();
                    if (txt == ''){
                        $('#searchResult').fadeOut(500);
                    }
                    else {
                        $.ajax({
                            url: "searchEngine.php",
                            method: "post",
                            data: {search:txt},
                            dataType: "text",
                            success:function (data) {
                                $('#searchResult').fadeIn(500);
                                $('#searchResult').html(data);
                            }
                        });
                    }
                });

                $('.tooltipped').tooltip();
                $('.sidenav').sidenav();
                $('.collapsible').collapsible();
                $('.modal').modal();
                $('.dropdown-trigger').dropdown();


                $('#searchToggle').click(function () {
                    $('#searchBar').toggle(function () {
                    });
                });

                $('#quantity').on('keyup', function () {
                   var quantity =  $('#quantity').val();
                   var price = (<?php echo $_GET['price']; ?>);
                   var total = price * quantity;
                   if (quantity == ''){
                       $('#total').html(0);
                   }
                   else {
                       $('#total').html(total);
                   }
                });
            });
            $(window).on('load', function () {
                $('#preLoad').fadeOut(1000);
            });
        </script>
    </body>
</html>

