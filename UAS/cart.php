<?php
    require_once("connection.php");

    $stmt = $pdo->query("SELECT * FROM product");
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $user_login=$_SESSION["login"];
    $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$user_login["email"]]);
    $user =$stmt->fetch(PDO::FETCH_ASSOC);

    $saldo=$user["saldo"];

    if(isset($_SESSION["cart"])){
        $carts=$_SESSION["cart"];
    }
    else{
        $carts=[];
    }
    if(isset($_SESSION["login"]))
    {
        $user=$_SESSION["login"];
    }else{
        $user=[];
    }
    if(isset($_POST["btn_cart"]))
    {
        //ini untuk add jumlah product otomatis
        if(isset($_SESSION["cart"]))
        {
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
            header("Location: cart.php");
        }
        //  echo "<pre>";
        // var_dump($_SESSION["cart"]);
        // echo "</pre>";
    }

    if(isset($_POST["order"]))
    {
            $size=sizeof($_SESSION["cart"]);
            $subtot=0;
            // $subjum=0;
            for($i=0;$i<$size;$i++){ 
                $sum=0;
                
                $price =$_SESSION["cart"][$i][0]["harga"]; 
                $jum =  $_SESSION["cart"][$i][1]; 
                $sum=$price*$jum;
                // $subjum+=$jum;
                $subtot+=$sum;
            }
 
            $balance=$user["saldo"];
            if($subtot<$balance)
            { 
                $carts = $_SESSION['cart'];
                $email = $user["email"];
                try{
                    $pdo->beginTransaction();  
                    $stmt = $pdo->prepare("INSERT INTO htrans(email,total) values(?,?)");
                    $result = $stmt->execute([$email,$subtot]);
                    $h_trans_id = $pdo->lastInsertId();
                    foreach ($carts as $key => $value) {
                      $nama=$carts[$key][0]["nama"];
                      $harga=$carts[$key][0]["harga"];
                      $jum=$carts[$key][1];
                      $subtot2=$harga*$jum;
                      $id_product=$value[0]["id_product"];
                      $stmt = $pdo->prepare("INSERT INTO dtrans(id_htrans,id_product, nama_product,jumlah,subtotal,harga) values(?,?,?,?,?,?)");
                      $result = $stmt->execute([$h_trans_id,$id_product ,$nama,$jum,$subtot2,$harga ]);
                    }
                    $balance-=$subtot;
                    $stmt = $pdo->prepare("UPDATE user SET saldo=:saldo WHERE email = :id");
                    $stmt->bindParam(":saldo", $balance); 
                    $stmt->bindParam(":id", $email);
                    $result = $stmt->execute();

                    unset($_SESSION["cart"]);
                    $pdo->commit();
                }catch(PDOException $e){
                  $pdo->rollBack();
                  throw $e;
                } 
                $_SESSION["message"]="Berhasil beli".$subjum." produk ,seharga".$subtot;
            }
            else{
                $_SESSION["message"]="saldo tidak cukup";
            }
            header("Location: cart.php");
    }
    if(isset($_SESSION["message"])){
        echo "<script>alert('$_SESSION[message]')</script>";
        unset($_SESSION["message"]);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="mycss.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

</head>
<body>
            <div class="container">
                
                <div class="header" id="top">    
                    <div class="nav">
                        <img class="logo" src="gallery/logo.png" alt="">
                        <a class="ar" href="#top">Home</a>
                        <a class="ar" href="sushi.php">Menu</a>
                        <a class="ar" href="cart.php">Cart</a>
                        <a class="ar" href="#top">About Us</a>
                        <?php
                            if($user!=null){
                        ?>
                            <div style="display: flex; justify-content: flex-end; flex-grow: 1;"></div>
                            <p class="h">saldo anda <?= $saldo?></p>
                            
                        <?php
                            }else{
                        ?>
                            <div style="display: flex; justify-content: flex-end; flex-grow: 1;"></div>
                                <a class="ar" href="login.php">Login / Register</a>
                            </div>
                        <?php
                            }
                        ?>
                </div>
                
                     <div class="product">
                     <a href="sushi.php">Back</a>
                         <center>
                        <p class="h">Your Cart</p><br>
                        <hr>
                        <br>
                        </center>
                        <br>

                        <!-- menu -->
                        <div class="tempMenu">
                            <!-- tempMakanan -->
                            <?php
                                if($carts!=null)
                                {
                                    foreach($carts as $key => $values)
                                    {
                            ?>
                                <div class="menue">
                                <form action="" method="post">
                                    <input type="hidden" name="id" value=<?=$values[0]["id_product"]?>>
                                    <div class="mup">ini gambar</div>
                                    <div class="mdown">
                                        <div class="mdleft">
                                            <div class="mname"><?=$values[0]["nama"]?></div>
                                            <div class="mdes"><?=$values[0]["deskripsi"]?></div>
                                        </div>
                                        <div class="mdright">
                                            <div class="addcart">Jumlah Order: <?=$values[1]?></div>
                                            <div class="harga">Total :Rp. <?=$values[0]["harga"]*$values[1]?></div>
                                            
                                        </div>
                                    </div>
                                </form>
                                </div> 
                            <?php
                                    }
                                }else{
                            ?>
                            Your Cart is Empty
                            <?php
                                }
                            ?>
                            <!-- tempMakanan -->
                        </div>
                         <!-- menu -->
                        <center>
                        <form action="" method="post">
                            <button name="order">Order</button>
                        </form>
                        </center>
                    </div> 
                     <div class="foot">
                        <p class="copy">Amazake social media</p>
                    </div>
            </div>
            </div>
   
</body>
</html>