<?php
    require_once("connection.php");
    $index = $_GET['cari']; 
    // if(isset($_POST["cart"]))
    // {
            if(isset($_SESSION["login"]))
            { 
                $stmt = $pdo->query("SELECT * FROM product where id_product='$index' ");
                $product_cart = $stmt->fetch(PDO::FETCH_ASSOC);
                //index 0 = object product,index 1 = jumlah
                $_SESSION["cart"][] = array($product_cart,1);  
            }else{
                $_SESSION["message"]="Mohon Login Terlebih dahulu"; 
                unset($_SESSION["cart"]);
                header("location:login.php");
            } 
    // }   
?>  