<?php
    require_once("connection.php");
    $sushi="1";
    $stmt = $pdo->query("SELECT * FROM product where id_jenis='$sushi' ");
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stat=0;
    // if(isset($_POST["cart"]))
    // {
    //         if(isset($_SESSION["login"]))
    //         {
    //             $index=$_POST["cart"];
    //             $stmt = $pdo->query("SELECT * FROM product where id_product='$index' ");
    //             $product_cart = $stmt->fetch(PDO::FETCH_ASSOC);
    //             //index 0 = object product,index 1 = jumlah
    //             $_SESSION["cart"][] = array($product_cart,1); 
    //         }else{
    //             $_SESSION["message"]="Mohon Login Terlebih dahulu"; 
    //             unset($_SESSION["cart"]);
    //             header("location:login.php");
    //         } 
            
    // } 
    if(isset($_POST['logout']))
    {
        unset($_SESSION["login"]);
        unset($_SESSION["cart"]);
        header("location:login.php");
    }
    if(isset($_SESSION["login"]))
    {
        $user=$_SESSION["login"];
    }else{
        $user=[]; 
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
    <title>Amazake</title>
    <link href="mycss.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

</head>
<body>
                    <div class="container">
                
                        <div class="header" id="top">    
                            <div class="nav">
                                <img class="logo" src="gallery/logo.png" alt="">
                                <a class="ar" href="#top">Home</a>
                                <a class="ar" href="#top">About Us</a>
                                <a class="ar" href="menu.php">Menu</a>
                                <a class="ar" href="cart.php">Cart</a>
                                <?php
                                    if($user!=null){
                                ?>
                                    <div style="display: flex; justify-content: flex-end; flex-grow: 1;">
                                        <a class="ar" href="#top">ようこそ, <?= $user["nama"]?></a>
                                    </div>  
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
                
                             <div class="product bgSushi">
                                 <center>
                                 <div class="htop color">
                                        <p>Drink</p>
                                 </div>
                                <div class ="path2"></div>
                                <br>
                                </center>
                                <br>

                                <!-- menu -->
                                <div class="tempMenu with-border-image drink">
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
                                                            <div class="addcart"><button class="btn_cart" name="cart" value=<?=$values["id_product"]?>>Add to cart</button></div>
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
                            <div id="container">
                            
                            </div>
                             <div class="foot">
                             <p class="copy">Copyright 2019 © Amazake</p>
                                <!-- <form action="" method="post">
                                    <button name="logout">Logout</button>
                                </form> -->
                            </div>
                    </div>
                    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
		
	
		
		$(".btn_cart").click(function(a){  
            a.preventDefault();
            var index = $(this).val(); 
            $("#container").load("ajax_menu.php?cari="+index); 
		});  
		
		
	});
	</script>
</body>
</html>