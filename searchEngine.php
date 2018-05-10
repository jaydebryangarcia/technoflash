<?php
    $conn = database();
    $output = '';
    $selectItem = $conn->prepare('SELECT * FROM item WHERE item_name LIKE :keyword ');
    $selectItem->execute(array(':keyword' => '%'.$_POST['search'].'%'));
    $selectItemResult = $selectItem->rowCount();

    if ($selectItemResult > 0){
        while ($fetch = $selectItem->fetch(PDO::FETCH_ASSOC)){
            $id = $fetch['item_id'];
            $name = $fetch['item_name'];
            $output .= '<a href="viewitem.php?item='.$name.'&id='.$id.'" class="collection-item teal-text">'.$name.'</a>';
        }
        echo $output;
    }
    else{
        $output .='<a class="collection-item red-text">No Item found</a>';
        echo $output;
    }
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

