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
        <title>Technoflash</title>
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
            <nav id="navigation" class="nav-extended blue">
                <div class="nav-wrapper container black-text">
                    <a href="index.php" class="brand-logo"><img class="responsive-img" src="images/technoflash.jpg" alt=""  style="width: 60px; height: auto; padding: 5px"></a>
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
                                echo '
                                    <li>
                                        <a href="#loginModal" class="modal-trigger">
                                        <i class="material-icons right">account_circle</i>Login</a>
                                    </li>
                                ';
                            }
                        ?>
                    </ul>
                    <!--Search Button-->
                    <ul class="right">
                        <li><a id="searchToggle"><i class="material-icons right">search</i></a></li>
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
                        <img src="images/technoflash.jpg" alt="" style="width: 60px; height: auto">
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
                <div class="col s12 m3 l2">
                    <div class="sidenav-fixed">
                        <ul class="collection with-header card">
                            <li class="collection-header"><h5>Category</h5></li>
                            <li><a href="index.php" class="collection-item">All Item</a></li>
                            <?php Category(); ?>
                        </ul>
                    </div>
                </div>
                <div class="row col s12 m9 l10">
                    <!--Category Choice PHP-->
                    <?php
                        if (isset($_GET['category'])){
                            $categoryChoice = $_GET['category'];
                            showCategoryItem($categoryChoice);
                        }
                        else{
                            getAllItem();
                        }
                    ?>
                </div>
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
            function getAllItem(){
                $conn = database();
                $selectItem = $conn->prepare('SELECT * FROM item ORDER BY created_at DESC');
                $selectItem->execute();
                $selectItemResult = $selectItem->rowCount();
                if ($selectItemResult > 0){
                    while ($fetch = $selectItem->fetch(PDO::FETCH_ASSOC)){
                        $id = $fetch['item_id'];
                        $name = $fetch['item_name'];
                        $price = $fetch['item_price'];
                        $description = $fetch['item_description'];
                        $img = $fetch['item_image'];
                        $category = $fetch['item_category'];
                        $created_at = $fetch['created_at'];
                        echo '
                            <div class="col s12 m6 l3 container">
                                <div class="card hoverable" id="itemCard">
                                    <div class="card-image" >
                                        <img src="data:image;base64,'.$img.'" class="responsive-img">
                                    </div>
                                    <div class="card-content">
                                        <p>'.$name.'</p>
                                        <span class="card-title activator grey-text text-darken-4">View More<i class="material-icons right">more_vert</i></span>
                                        <small>Posted: '.$created_at.'</small>
                                    </div>
                                    <div class="card-reveal">
                                        <span class="card-title grey-text text-darken-4">'.$name.'<i class="material-icons right">close</i></span>
                                        <p class="flow-text green-text">'.$price.'</p>
                                        <div class="divider"></div>
                                        <p>'.$description.'</p>
                                        <div class="divider"></div>
                                        <p>Item Category: '.$category.'</p>
                                    </div>
                                    <div class="card-action">
                                        <a href="viewitem.php?category='.$category.'&item='.$name.'&id='.$id.'&price='.$price.'" class="green-text darken-3">View Item<i class="material-icons left prefix">send</i></a>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
                else{
                    echo '
                        <div class="col s12 m6 l3 container">
                            <div class="card center-align">
                                <div class="card-content">
                                    <h4>No Item found!</h4>
                                </div>
                            </div>
                        </div>
                    ';
                }

            }
            function showCategoryItem($catChoice){
                $conn = database();
                $selectItem = $conn->prepare('SELECT * FROM item WHERE item_category = :item_category ORDER BY created_at DESC');
                $selectItem->execute(array(':item_category' => $catChoice));
                $selectItemResult = $selectItem->rowCount();
                if ($selectItemResult > 0){
                    while ($fetch = $selectItem->fetch(PDO::FETCH_ASSOC)){
                        $id = $fetch['item_id'];
                        $name = $fetch['item_name'];
                        $price = $fetch['item_price'];
                        $description = $fetch['item_description'];
                        $img = $fetch['item_image'];
                        $category = $fetch['item_category'];
                        $created_at = $fetch['created_at'];
                        echo '
                            <div class="col s12 m6 l3 container">
                                <div class="card hoverable">
                                    <div class="card-image">
                                        <img src="data:image;base64,'.$img.'" class="responsive-img">
                                    </div>
                                    <div class="card-content">
                                        <span class="card-title activator grey-text text-darken-4">'.$name.'<i class="material-icons right">more_vert</i></span>
                                        <small>Posted: '.$created_at.'</small>
                                    </div>
                                    <div class="card-reveal">
                                        <span class="card-title grey-text text-darken-4">'.$name.'<i class="material-icons right">close</i></span>
                                        <p class="flow-text green-text">'.$price.'</p>
                                        <div class="divider"></div>
                                        <p>'.$description.'</p>
                                        <div class="divider"></div>
                                        <p>Item Category: '.$category.'</p>
                                    </div>
                                    <div class="card-action">
                                        <a href="viewitem.php?category='.$category.'&item='.$name.'&id='.$id.'&price='.$price.'" class="green-text darken-3">View Item<i class="material-icons left prefix">send</i></a>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
                else{
                    echo '
                        <div class="col s12 m6 l3 container">
                            <div class="card center-align">
                                <div class="card-content">
                                    <h4>No Item found!</h4>
                                </div>
                            </div>
                        </div>
                    ';
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
                else{
                    $selectAdmin = $conn->prepare('SELECT * FROM admin WHERE user_email = :user_email AND user_password = :user_password');
                    $selectAdmin->execute(array(':user_email' => $sessionEmail, ':user_password' => $sessionPassword));
                    $selectAdminResult = $selectAdmin->rowCount();
                    if ($selectAdminResult > 0){
                        while ($getAdmin = $selectAdmin->fetch(PDO::FETCH_ASSOC)){
                            $adminName = $getAdmin['user_name'];
                        }
                        echo '
                            <li><a>Log in as: '.$adminName.'</a></li>
                            <li><a href="adminpage.php">Admin Panel</a></li>
                            <li><a href="logout.php">Logout<i class="material-icons prefix right">arrow_forward</i></a></li>
                        ';
                    }

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
                    header('Location:index.php');
                }
                else{
                    $selectIfAdmin = $conn->prepare('SELECT * FROM admin WHERE user_email = :user_email AND user_password = :user_password');
                    $selectIfAdmin->execute(array(':user_email' => $email, ':user_password' => $password));
                    $selectIfAdminResult = $selectIfAdmin->rowCount();
                    if ($selectIfAdminResult > 0){
                        $_SESSION['user_email'] = $email;
                        $_SESSION['user_password'] = $password;
                        header('Location:adminpage.php');
                    }
                    else{
                        header('Location:login.php?user=notfound');
                    }
                }
            }
            function Category(){
                $conn = database();
                $getCat = $conn->prepare('SELECT * FROM category');
                $getCat->execute();
                while ($fetchCat = $getCat->fetch(PDO::FETCH_ASSOC)){
                    $category = $fetchCat['product_category'];
                    echo '<li><a href="index.php?category='.$category.'" class="collection-item">'.$category.'</a></li>';
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

            });
            $(window).on('load', function () {
                $('#preLoad').fadeOut(1000);
            });
        </script>
    </body>
</html>

