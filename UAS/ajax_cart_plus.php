<?php
session_start();
$index = $_POST["idxproduct"];
$jum=$_SESSION['cart'][$index][1];
$_SESSION['cart'][$index][1]=$jum+1;
$sum=$jum+1;
echo $sum;
?>