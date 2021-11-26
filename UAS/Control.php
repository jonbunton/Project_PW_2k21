<?php
    require_once("connection.php"); 
$action = $_REQUEST["action"];
  if($action=="addprod"){
    $nama = $_POST["Nama"];
    $price = $_POST["hrg"];
    $jenis = $_POST["genre_id"];
    $des = $_POST["des"];
    
    $result =false;

    if(isset($nama) && $nama!=""){
    $stmt = $pdo->prepare("INSERT INTO product(id_jenis,nama, harga, deskripsi) VALUES(?,?,?,?)");
    $result = $stmt->execute([$jenis, $nama, $price, $des]);
    }
    
    if($result){
    $_SESSION["message"] = "Berhasil add nih";
    }else{
    $_SESSION["message"] = "Gagal add nih!";
    }
    header("Location: mProd.php");
  }
  else if($action=="plusorder")
  {
    $index=$_POST["key"];
    $jum=$_SESSION['cart'][$index][1];
    $_SESSION['cart'][$index][1]=$jum+1;
    header("Location: cart.php");
    echo "Plus";
    echo "<pre>";
    var_dump($_SESSION["cart"]);
    echo "</pre>";
  }
  else if($action=="minorder")
  {
    $index=$_POST["key"];
    $jum=$_SESSION['cart'][$index][1];
    if($jum>1)
    {
      $_SESSION['cart'][$index][1]=$jum-1;
    }else{
      unset ($_SESSION['cart'][$index]);
      $_SESSION['cart']=array_values($_SESSION['cart']);
    }
    echo "minus";
    echo "<pre>";
    var_dump($_SESSION["cart"]);
    echo "</pre>";
    header("Location: cart.php");
  }
  
?>