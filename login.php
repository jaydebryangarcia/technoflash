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
        <title>Login</title>
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
        <div>
            <!--Navigation-->
            <nav id="navigation" class="nav-extended yellow ">
                <div class="nav-wrapper container black-text">
                    <a href="index.php" class="brand-logo"><img class="responsive-img" src="images/technoflash.jpg" alt=""  style="width: 60px; height: auto"></a>
                </div>
            </nav>
            <!--Login Error Handler-->
            <div class="container">
                <?php
                    if (isset($_GET['user'])){
                        $errorMsg = $_GET['user'];
                        loginErr($errorMsg);
                    }
                ?>
            </div>
            <br>
            <!--Content-->
            <div class="row">
                <div class="col s12 m5 l7">
                    <div class="sidenav-fixed">
                        <img src="images/technoflash.jpg" alt="" class="circle responsive-img center" style="width: 460px; height: auto">
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m7 l5">
                        <div class="card hoverable grey lighten-4">
                            <form action="login.php" method="post">
                                <div class="card-content">
                                    <span class="card-title"><h4>Login</h4></span>
                                    <hr>
                                    <div class="row">
                                        <div class="input-field col s12 pink-text">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input id="email" type="email" class="validate" name="user_email">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 pink-text">
                                            <i class="material-icons prefix">vpn_key</i>
                                            <input id="password" type="password" class="validate" name="user_password">
                                            <label for="password">Password</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <button type="submit" class="btn btn-large waves-effect waves-red green black-text right" name="loginButton" value="ok">
                                            <i class="material-icons right">send</i>Login
                                        </button>
                                    </div>
                                </div>
                                <div class="card-action">
                                    No account yet?
                                    <a href="register.php" class="orange-text">Register Here</a>
                                </div>
                            </form>
                            <!--Submit Login-->
                            <?php
                                if (isset($_POST['loginButton'])){
                                    $user_email = $_POST['user_email'];
                                    $user_password = md5($_POST['user_password']);
                                    login($user_email, $user_password);
                                }
                            ?>
                        </div>
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
            function loginErr($errorVal){
                switch ($errorVal){
                    case 'notfound':
                        echo ' <div class="card-panel yellow lighten-2" id="errFade">Incorrect Email or Password!</div>';
                        break;
                    case 'notlogin':
                        echo ' <div class="card-panel yellow lighten-2" id="errFade">Login to access the page!</div>';
                        break;
                }
            }
        ?>
        <!--JavaScript at end of body for optimized loading-->
        <script src="js/googelcdn.jquery.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>

        <script>
            $(window).on('load', function (e) {
                $('#preLoad').fadeOut(1000);
            });
            $(document).ready(function () {
                $('.tooltipped').tooltip();
                $('.sidenav').sidenav();
                $('#errFade').delay(2000).fadeOut(500);
            });
        </script>
    </body>
</html>