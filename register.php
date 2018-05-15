<?php
ob_start();
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

        <link rel="icon" href="images/technoflash.jpg">
        <title>Register</title>
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
        </div>
        <div>
            <!--Navigation-->
            <nav id="navigation" class="nav-extended blue-grey darken-1 ">
                <div class="nav-wrapper container black-text">
                    <a href="index.php" class="brand-logo"><img class="responsive-img" src="images/technoflash.jpg" alt=""  style="width: 60px; height: auto"></a>
                    <ul class="right">
                        <li><a href="index.php">Shop <i class="material-icons prefix right">arrow_forward</i></a></li>
                    </ul>
                </div>
            </nav>
            <br>
            <!--Content-->
            <div class="container">
                <?php
                    if (isset($_POST['registerButton'])){
                        $firstName = $_POST['firstName'];
                        $lastName = $_POST['lastName'];
                        $userName = ucfirst($firstName).' '.ucfirst($lastName);
                        $userEmail = $_POST['email'];
                        $userPassword = md5($_POST['password']);
                        $userAddress = $_POST['address'];
                        register($userName, $userEmail, $userPassword, $userAddress);
                    }
                ?>
                <div class="row card hoverable">
                    <div class="card-title">
                        <h4>Register Form</h4>
                    </div>
                    <div class="divider"></div>
                    <div class="card-content">
                        <div class="card-title">
                            <h6>Basic Info</h6>
                        </div>
                        <form action="register.php" method="post" class="col s12 m12">
                            <div class="input-field col s12 m12 l6 pink-text">
                                <i class="material-icons prefix left">create</i>
                                <input id="firstName" type="text" class="validate" name="firstName" required>
                                <label for="firstName">First Name</label>
                            </div>
                            <div class="input-field col s12 m12 l6 pink-text">
                                <i class="material-icons prefix left">create</i>
                                <input id="lastName" type="text" class="validate" name="lastName" required>
                                <label for="lastName">Last Name</label>
                            </div>
                            <div class="input-field col s12 m12 l6 pink-text">
                                <i class="material-icons prefix left">account_box</i>
                                <input id="email" type="email" class="validate" name="email" required>
                                <label for="email">Email</label>
                                <span class="helper-text" data-error="Please input correct email!" data-success="right"></span>
                            </div>
                            <div class="input-field col s12 m12 l6 pink-text">
                                <i class="material-icons prefix left">vpn_key</i>
                                <input id="password" type="password" class="validate" name="password" required>
                                <label for="password">Password</label>
                            </div>
                            <div class="input-field col s12 pink-text">
                                <i class="material-icons prefix left">chat</i>
                                <textarea id="address" class="materialize-textarea validate" name="address"></textarea>
                                <label for="address">Address</label>
                            </div>
                            <div class="col s12 m12 l12">
                                <button type="submit" class="btn btn-flat btn-large waves-effect waves-green right" name="registerButton" value="ok">
                                    <i class="material-icons prefix right">send</i>
                                    Register
                                </button>
                            </div>
                        </form>
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
            function register($name, $email, $password, $address){
                $conn = database();
                $selectUser = $conn->prepare('SELECT * FROM customers WHERE user_email = :user_email AND user_password = :user_password');
                $selectUser->execute(array(':user_email' => $email, ':user_password' => $password));
                $selectUserResult = $selectUser->rowCount();
                if ($selectUserResult > 0){
                    echo ' <div class="card-panel yellow lighten-2" id="regMsg">User Exist!</div>';
                }
                else{
                    $insertQuery = 'INSERT INTO customers (user_name, user_email, user_password, user_address) VALUES (:user_name, :user_email, :user_password, :user_address)';
                    $insertNewCustomer = $conn->prepare($insertQuery);
                    $insertNewCustomer->execute(
                        array(
                            ':user_name' => $name,
                            ':user_email' => $email,
                            ':user_password' => $password,
                            ':user_address' => $address
                        )
                    );
                    echo ' <div class="card-panel green lighten-2" id="regMsg">Register Success!</div>';
                    header("Refresh:2; url:index.php");
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
                $('#regMsg').delay(2000).fadeOut(500);
            });
        </script>
    </body>
</html>