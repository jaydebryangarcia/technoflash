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
        <title>Admin Page</title>
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
            li.link{
                cursor: pointer;
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
            <nav id="navigation" class="nav-extended indigo">
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
                                session_unset();
                                session_destroy();
                                header('Location:index.php');
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
                            <li><a href="logout.php" class="modal-trigger"><i class="material-icons left">account_circle</i>Logout</a></li>
                        </div>
                    </ul>
                </div>
                <!-- Dropdown Structure -->
                <ul id="userAccountOption" class="dropdown-content">
                    <li><a href="index.php">View Page</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>

            <!--Content-->
            <div class="row">
                <!--Buttons-->
                <?php
                    //delete button
                    if (isset($_GET['delete'])){
                        $delID = $_GET['delId'];
                        deleteItem($delID);
                    }
                    //add category button
                    if (isset($_POST['addCatBtn'])){
                        $CatValue = ucfirst($_POST['catName']);
                        addCategory($CatValue);
                    }
                    //add item button
                    if (isset($_POST['addItemBtn'])){
                        //check image before uploading item
                        if (getimagesize($_FILES['itemImage']['tmp_name'])==FALSE){
                            echo '
                                <div class="container">
                                    <div class="card yellow lighten-2 center-align" id="msg">
                                        <div class="card-content">
                                            <h4>Please Select Image!</h4>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                        else {
                            //data
                            $item_name = $_POST['itemName'];
                            $price = $_POST['itemPrice'];
                            $description = $_POST['itemDescription'];
                            $category = $_POST['itemCat'];
                            $created_at = date('Y-m-d H:i A');
                            //image
                            $image = addslashes($_FILES['itemImage']['tmp_name']);
                            $name = addslashes($_FILES['itemImage']['name']);
                            $image = file_get_contents($image);
                            $image = base64_encode($image);
                            //add item to database function call
                            addItem($item_name, $price, $description, $category, $image, $name, $created_at);
                        }

                    }
                ?>
                <div class="col s12 m4 l3">
                    <div class="sidenav-fixed">
                        <ul class="collection with-header card">
                            <li class="collection-header"><h5>Controls</h5></li>
                            <li id="addItemButton" class="link"><a class="collection-item pink-text">Add Item</a></li>
                            <li id="addCategoryButton" class="link"><a class="collection-item pink-text">Add Category</a></li>
                            <li id="removeItemButton" class="link"><a class="collection-item pink-text">Remove Item</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row col s12 m8 l9">
                    <div class="card-image hoverable z-depth-2">

                        <!--Add Item Content-->
                        <div id="addItem" style="display: none">
                            <div class="card-title">Add Item</div><hr>
                            <div class="card-content">
                                <form action="adminpage.php" method="post" enctype="multipart/form-data">
                                    <div class="row s12 m12 l12 blue-text">
                                        <div class="input-field col s12">
                                            <input type="text" id="name"  class="validate" placeholder="name" name="itemName" required>
                                            <label for="name">Item Name</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input type="number" id="number"  class="validate" placeholder="price" name="itemPrice" required>
                                            <label for="number">Item Price Name</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <textarea id="textarea1" class="materialize-textarea validate" placeholder="description" name="itemDescription" required></textarea>
                                            <label for="textarea1">Item description</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <select name="itemCat" required>
                                                <option value="" disabled selected>Choose your option</option>
                                                <!--show category funtion call-->
                                                <?php getCat();?>
                                            </select>
                                            <label>Item Category</label>
                                        </div>
                                        <div class="file-field input-field col s12">
                                            <div class="btn">
                                                <span>File</span>
                                                <input type="file" name="itemImage" id="itemImage" required>
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate" type="text" name="imageName">
                                            </div>
                                        </div>
                                        <div class="input-field col s12 ">
                                            <button type="submit" class="btn green" name="addItemBtn" value="ok">
                                                Add Item<i class="material-icons prefix right">send</i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!--Add Category Content-->
                        <div id="addCategory" style="display: none">
                            <div class="card-title">Add Category</div><hr>
                            <div class="card-content">
                                <form action="adminpage.php" method="post">
                                    <div class="row s12 m12 l12 blue-text">
                                        <div class="input-field col s12">
                                            <input type="text" id="cat_name"  class="validate" placeholder="cat_name" name="catName" required>
                                            <label for="cat_name">Category Name</label>
                                        </div>
                                        <div class="input-field col s12 ">
                                            <button type="submit" class="btn green" name="addCatBtn" value="ok">
                                                Add Category<i class="material-icons prefix right">send</i>
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                        <!--Remove Item-->
                        <div id="removeItem" style="display: none">
                            <div class="card-title">Remove Item</div><hr>
                            <div class="card-content">
                                <!--show items to delete function call-->
                                <?php showDeleteItem(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--PHP Functions-->
        <?php
            //database function
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
            //user session function
            function userSession($sessionEmail, $sessionPassword){
                $conn = database();
                $selectUser = $conn->prepare('SELECT * FROM admin WHERE user_email = :user_email AND user_password = :user_password');
                $selectUser->execute(array(':user_email' => $sessionEmail, ':user_password' => $sessionPassword));
                $selectUserResult = $selectUser->rowCount();
                if ($selectUserResult > 0){
                    while ($getName = $selectUser->fetch(PDO::FETCH_ASSOC)){
                        $userName = $getName['user_name'];
                    }
                    echo '<li><a class="dropdown-trigger" data-target="userAccountOption">'.$userName.'</a></li>';
                }
            }
            //add item function
            function addItem($itemName, $itemPrice, $itemDescription, $itemCat, $itemImage, $imageName, $created){
                $conn =  database();
                $checkItem = $conn->prepare('SELECT * FROM item WHERE item_name = :item_name');
                $checkItem->execute(array(':item_name' => $itemName));
                $checkItemResult = $checkItem->rowCount();
                if ($checkItemResult > 0){
                    echo '
                        <div class="container">
                            <div class="card yellow lighten-2 center-align" id="msg">
                                <div class="card-content">
                                    <h4>Item Exist!</h4>
                                </div>
                            </div>
                        </div>
                    ';
                }
                else{
                    $addItem = $conn->prepare('INSERT INTO item (item_name, item_price, item_description, item_category, item_image, image_name, created_at) VALUES (:item_name, :item_price, :item_description, :item_category, :item_image, :image_name, :created_at)');
                    $addItem->execute(array(
                        'item_name' => $itemName,
                        'item_price'=> $itemPrice,
                        'item_description' => $itemDescription,
                        'item_category' => $itemCat,
                        'item_image' => $itemImage,
                        'image_name' => $imageName,
                        'created_at' => $created
                    ));
                    echo '
                        <div class="container">
                            <div class="card green lighten-2 center-align" id="msg">
                                <div class="card-content">
                                    <h4>Item Added!</h4>
                                </div>
                            </div>
                        </div>
                    ';
                }
            }
            //add category function
            function addCategory($value){
                $conn =  database();
                $selectCat = $conn->prepare('SELECT * FROM category WHERE product_category = :catname');
                $selectCat->execute(array(':catname' => $value));
                $selectCatResult = $selectCat->rowCount();
                if ($selectCatResult > 0){
                    echo '
                        <div class="container">
                            <div class="card red center-align" id="msg">
                                <div class="card-content">
                                    <h4>Category Exist!</h4>
                                </div>
                            </div>
                        </div>
                    ';
                }
                else{
                    $insertCat = $conn->prepare('INSERT INTO category (product_category) VALUES (:catname)');
                    $insertCat->execute(array(':catname' => $value));
                    echo '
                        <div class="container">
                            <div class="card green center-align" id="msg">
                                <div class="card-content">
                                    <h4>Category Added!</h4>
                                </div>
                            </div>
                        </div>
                    ';
                }
            }
            //show item for delete function
            function showDeleteItem(){
                $conn =  database();
                $selectItem = $conn->prepare('SELECT * FROM item');
                $selectItem->execute();
                while ($fetchItem = $selectItem->fetch(PDO::FETCH_ASSOC)){
                    $itemId = $fetchItem['item_id'];
                    $itemName = $fetchItem['item_name'];
                    $item_img = $fetchItem['item_image'];
                    $created_at = $fetchItem['created_at'];
                    echo '
                        <div class="row s12">
                            <div class="col s12 m4 l4">
                                <img src="data:image;base64,'.$item_img.'" class="responsive-img">
                            </div>
                            <div class="col s12 m8 l8">
                                <p class="flow-text">'.$itemName.'</p>
                                <p>Item ID: '.$itemId.'</p>
                                <small>'.$created_at.'</small>
                            </div>
                            <div class="input-field">
                                <a href="adminpage.php?delete=yes&delId='.$itemId.'" class="btn btn-large red">Delete</a>
                            </div>
                        </div>
                        
                    ';
                }
            }
            //get category function
            function getCat(){
                $conn = database();
                $getCategory = $conn->prepare('SELECT * FROM category');
                $getCategory->execute();
                while ($fetchCat = $getCategory->fetch(PDO::FETCH_ASSOC)){
                    $cat = $fetchCat['product_category'];
                    echo '<option value="'.$cat.'">'.$cat.'</option>';
                }
            }
            //delete item function
            function deleteItem($value){
                $conn = database();
                $deleteItem = $conn->prepare('DELETE FROM item WHERE item_id = :item_id');
                $deleteItem->execute(array(':item_id' => $value));
                echo '
                    <div class="container">
                        <div class="card yellow lighten-2 center-align" id="msg">
                            <div class="card-content">
                                <h4>Item Deleted!</h4>
                            </div>
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
                $('.sidenav').sidenav();
                $('.collapsible').collapsible();
                $('.modal').modal();
                $('.dropdown-trigger').dropdown();
                $('select').formSelect();

                $('#addItemButton').click(function () {
                    $('#addItem').slideToggle();
                });
                $('#addCategoryButton').click(function () {
                    $('#addCategory').slideToggle();
                })
                $('#removeItemButton').click(function () {
                    $('#removeItem').slideToggle();
                });

                $('#msg').delay(2000).fadeOut(500);
            });
            $(window).on('load', function () {
                $('#preLoad').fadeOut(1000);
            });
        </script>
    </body>
</html>

