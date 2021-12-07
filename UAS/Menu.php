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
        // if($_SESSION["login"]="admin"){
        //     unset($_SESSION["login"]);
        //     $user=[]; 
        // }
        
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
                                <a class="ar" href="#top">Menu</a>
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
                                        <a class="ar" href="login.php">Login/Register</a>
                                    </div>
                                <?php
                                    }
                                ?>
                             </div>
                
                             <div class="product">
                                 <center>
                                     <div class="htop">
                                        <p>Pick Category</p>
                                     </div>
                                    <div class ="path"></div>
                                    
                                <div class="cards">
                                    <a href="sushi.php" style="text-decoration:none;">
                                        <div class="circle p1">
                                        
                                        <div class="tag">S</div>
                                        <div class="tag">U</div>
                                        <div class="tag">S</div>
                                        <div class="tag">H</div>
                                        <div class="tag">I</div>
                                        <div class="tag1"></div>
                                        <div class="tag1"></div>
                                        
                                        </div>
                                    </a>

                                    <a href="ramen.php" style="text-decoration:none;">
                                        <div class="circle p2">
                                            <div class="tag">R</div>
                                            <div class="tag">A</div>
                                            <div class="tag">M</div>
                                            <div class="tag">E</div>
                                            <div class="tag">N</div>
                                            <div class="tag1"></div>
                                            <div class="tag1"></div>
                                            
                                            
                                        </div>
                                    </a>

                                    <a href="rice.php" style="text-decoration:none;">
                                        <div class="circle p3">
                                            
                                            <div class="tag">R</div>
                                            <div class="tag">I</div>
                                            <div class="tag">C</div>
                                            <div class="tag">E</div>
                                            <div class="tag1"></div>
                                            <div class="tag1"></div>
                                            <div class="tag1"></div>
                                            
                                            
                                        </div> 
                                    </a>
                                    <a href="drink.php" style="text-decoration:none;">
                                        <div class="circle p4">
                                            
                                            <div class="tag">D</div>
                                            <div class="tag">R</div>
                                            <div class="tag">I</div>
                                            <div class="tag">N</div>
                                            <div class="tag">K</div>
                                            <div class="tag1"></div>
                                            <div class="tag1"></div>
                                            
                                        </div>
                                    </a>
                                    <a href="dessert.php" style="text-decoration:none;">
                                        <div class="circle p5">
                                            
                                            <div class="tag">D</div>
                                            <div class="tag">E</div>
                                            <div class="tag">S</div>
                                            <div class="tag">S</div>
                                            <div class="tag">E</div>
                                            <div class="tag">R</div>
                                            <div class="tag">T</div>

                                            
                                        </div>
                                    </a>
                
                                </div>
                                </center>
                            </div>
                
                             <div class="foot">
                                <p class="copy">Copyright 2019 © Amazake</p>
                            </div>
                    </div>
                    </div>
</body>
</html>
