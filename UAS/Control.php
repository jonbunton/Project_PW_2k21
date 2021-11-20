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

  ?>