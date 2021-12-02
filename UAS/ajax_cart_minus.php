<?php
session_start();
$index = $_POST["idxproduct"];
$jum=$_SESSION['cart'][$index][1];
if($jum>1)
  {
    $_SESSION['cart'][$index][1]=$jum-1;
    $sum=$jum-1;
  }else{
    unset ($_SESSION['cart'][$index]);
    $_SESSION['cart']=array_values($_SESSION['cart']);
    require_once("refreshcart.php");
    $sum=0;
  }


  
echo $sum;  
?>