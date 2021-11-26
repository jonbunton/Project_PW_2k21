<?php
    $size=sizeof($_SESSION["cart"]);
    $carts = $_SESSION['cart']; 
    for($i=0;$i<$size;$i++){
        $id1=$_SESSION["cart"][$i][0]["id_product"]; 
        for($j=$size-1;$j>$i;$j--)
        {
            $id2=$_SESSION["cart"][$j][0]["id_product"];   
            if($id1==$id2) 
            { 
                unset($_SESSION["cart"][$j]); 
                $_SESSION['cart']=array_values($_SESSION['cart']);
                $size=sizeof($_SESSION["cart"]);
                $j=$size;
                $jum= $_SESSION["cart"][$i][1];
                $_SESSION["cart"][$i][1]=$jum+1;
            }
        }
    }  
?>