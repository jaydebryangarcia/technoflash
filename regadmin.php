<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
    <form action="regadmin.php" method="post">
        <input type="text" name="name" placeholder="name">
        <input type="email" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <button type="submit" name="submit" value="ok">Submit</button>
    </form>

    </body>
</html>
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
if (isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $conn = database();
    $query = $conn->prepare('INSERT INTO admin (user_name, user_email, user_password) VALUES (:user_name, :user_email, :user_password)');
    $query->execute(array(':user_name' => $name, ':user_email' => $email, ':user_password' => $password));
}