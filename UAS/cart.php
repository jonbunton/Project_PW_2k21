<?php
    require_once("connection.php");

    $stmt = $pdo->query("SELECT * FROM product");
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_SESSION["login"]))
    {
        $user_login=$_SESSION["login"];
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$user_login["email"]]);
        $user =$stmt->fetch(PDO::FETCH_ASSOC);
        //$saldo=$user["saldo"];
    }
    
    
   

    if(isset($_SESSION["cart"])){
        //ini untuk add jumlah product otomatis
        require_once("refreshcart.php");  
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
    if(isset($_POST['logout']))
    {
        unset($_SESSION["login"]);
        unset($_SESSION["cart"]);
        header("location:login.php");
    } 

    if(isset($_SESSION["cart"]))
    {
        $size=sizeof($_SESSION["cart"]);
        $subtot=0;
        $subjum=0;
        for($i=0;$i<$size;$i++){ 
            $sum=0;

            $price =$_SESSION["cart"][$i][0]["harga"]; 
            $jum =  $_SESSION["cart"][$i][1]; 
            $sum=$price*$jum;
            $subjum+=$jum;
            $subtot+=$sum;
        }

    }

    if(isset($_POST["order"]))
    { 
            $balance=$user["saldo"];
            $subtot+=15000;
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
                      $ongkir=15000;
                      $nama=$carts[$key][0]["nama"];
                      $harga=$carts[$key][0]["harga"];
                      $jum=$carts[$key][1];
                      $subtot2=($harga*$jum); 
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
                <a class="ar" href="menu.php">Menu</a>
                <a class="ar" href="cart.php">Cart</a>
                <a class="ar" href="#top">About Us</a>
                       
                <?php
                    if($user!=null){
                ?>
                <div style="display: flex; justify-content: flex-end; flex-grow: 1;"></div>
                <!-- <p class="h">saldo anda <?= $saldo?></p> -->
                            
                <?php
                    }else{
                ?>
                <div style="display: flex; justify-content: flex-end; flex-grow: 1;">
                    <a class="ar" href="login.php">Login / Register</a>
                </div>

                        <?php
                            }
                        ?>
            </div>
        </div>
                
        <div class="product bgcart">
            <!-- cart -->
            <center>
                <div class="cart blur2">
                <!--detail cart -->
                    <div class="cleft">
                        <div  class="textCart"><h1>Shopping Cart</h1></div>
                        <div class="tabCart">
                            <table>
                                <thead>
                                    <th colspan = "2">PRODUCT DETAILS</th>
                                    <th>QUANTITY</th>
                                    <th>PRICE</th>
                                    <th>TOTAL</th>
                                </thead>
                                <tbody>
                                <?php
                                    if($carts!=null)
                                    {
                                        foreach($carts as $key => $values)
                                        {
                                ?>
                                        <tr>
                                            <td>gambar</td>
                                            <td><?=$values[0]["nama"]?> <br> <?=$values[0]["deskripsi"]?></td>
                                            <td>
                                                <div style="display: flex; flex-direction: row; justify-content:flex-start;">
                                                    <form style="width: 20px; height: 20px; margin-right:20px;" action="Control.php" method="post">
                                                        <input type="hidden" name="action" value="minorder">
                                                        <input type="hidden" name="key" value="<?=$key?>">
                                                        <button class="buttoncart" name="btn_cart">-</button>
                                                    </form>
                                                    
                                                    <?=$values[1]?> 
                                                    
                                                    <form style="width: 20px; height: 20px; margin-left:20px;" action="Control.php" method="post">
                                                        <input type="hidden" name="action" value="plusorder">
                                                        <input type="hidden" name="key" value="<?=$key?>">
                                                        <button class="buttoncart" name="btn_cart">+</button>
                                                    </form>
                                                </div>
                                          
                                            </td>
                                            <td>IDR <?=$values[0]["harga"]?></td>
                                            <td>IDR <?=$values[0]["harga"]*$values[1]?></td>
                                            <input type="hidden" name="id" value=<?=$values[0]["id_product"]?>>
                                        </tr>
                                        <?php
                                        }
                                    }else{
                                ?>
                                Your Cart is Empty
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                            <!-- summary -->
                    <div class="cright blur2">
                        <div  class="textCart4">ORDER SUMMARY</div>
                        <hr>
                        <div  class="textCart3">
                            <div class="t1">
                            <?php if(isset($subjum)) echo $subjum;
                            else echo "0"?>
                            </div>
                            <div class="t2">
                                Items
                            </div>
                            <div class="t3">
                                IDR <?php if(isset($subtot)) echo $subtot;
                                else echo "0"?> <!--tinggal gnt jumlahnya aj pake php IDR-nya biarin -->
                            </div>
                        </div>
                        <div  class="textCart3">
                            <div class="t1">
                                Shipping Cost
                            </div>
                            <div class="t3">
                                IDR 15000
                            </div>
                        </div>
                        <hr>
                        <div  class="textCart3"> 
                            <div class="t1">
                                Grand Total
                            </div>
                            <div class="t3">
                                 IDR <?php if(isset($subtot)) echo $subtot+=15000;
                                else echo "0"?> <!--tinggal gnt jumlahnya aj pake php IDR-nya biarin -->
                            </div>
                        </div>
                        <br><br><br><br><br><br><br><br><br>
                        <form action="" method="post">
                            <button class="buttonco" name="order">Check Out</button>
                        </form>       
                    </div>
                </div>
            </center>
                            <!-- DETAIL CART  -->
        </div>

        <div class="foot">
            <p class="copy">Amazake social media</p>
            <!-- <form action="" method="post">
                <button name="order">Order</button>
            </form>
            <form action="" method="post">
                <button name="logout">Logout</button>
            </form> -->
        </div>

    </div>
   
</body>
</html>