<?php
    require_once("connection.php");

    $stmt = $pdo->query("SELECT * FROM product");
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST["cart"]))
    {
        $index=$_POST["cart"];
        $stmt = $pdo->query("SELECT * FROM product where id_product='$index' ");
        $product_cart = $stmt->fetch(PDO::FETCH_ASSOC);
        //index 0 = object product,index 1 = jumlah
        $_SESSION["cart"][] = array($product_cart,1); 
    } 
    if(isset($_SESSION["login"]))
    {
        $user=$_SESSION["login"];
    }else{
        $user=[];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazake</title>
    <link rel="stylesheet" href="mycss.css">

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
                                    <p class="h">Welcome <?= $user["nama"]?></p>
                                    
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
                                 <center>
                                <p class="h">Pick Your Favourite Sushi</p><br>
                                <hr>
                                <br>
                                </center>
                                <br>

                                <!-- menu -->
                                <div class="tempMenu">
                                    <!-- tempMakanan -->
                                    <?php
                                        if($products!=null)
                                        {
                                            foreach($products as $key => $values)
                                            {
                                    ?>
                                        <div class="menue">
                                        <form action="" method="post">
                                            <input type="hidden" name="id" value=<?=$values["id_product"]?>>
                                            <div class="mup">ini gambar</div>
                                            <div class="mdown">
                                                <div class="mdleft">
                                                    <div class="mname"><?=$values["nama"]?></div>
                                                    <div class="mdes"><?=$values["deskripsi"]?></div>
                                                </div>
                                                <div class="mdright">
                                                    <div class="harga">Rp. <?=$values["harga"]?></div>
                                                    <div class="addcart"><button name="cart" value=<?=$values["id_product"]?>>Add to cart</button></div>
                                                </div>
                                            </div>
                                        </form>
                                        </div> 
                                    <?php
                                            }
                                        }
                                    ?>
                                    <!-- tempMakanan -->
                                </div>
                                 <!-- menu -->
                
                            </div>
                                        
                            <form action="cart.php" method="post">
                                <button name="btn_cart">Go To Cart</button>
                            </form>
                             <div class="foot">
                                <p class="copy">Amazake social media</p>
                            </div>
                    </div>
                    </div>
</body>
</html>