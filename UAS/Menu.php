<?php
    require_once("connection.php");
    $sushi="1";
    $stmt = $pdo->query("SELECT * FROM product where id_jenis='$sushi' ");
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stat=0; 
    if(isset($_POST['logout']))
    {
        unset($_SESSION["login"]);
        unset($_SESSION["cart"]);
        header("location:login.php");
    }
    if(isset($_SESSION["login"]))
    {
        $user=$_SESSION["login"];
        if($_SESSION["login"]=="admin"){
            header("location:muser.php");
        } 
        
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
                                <a class="ar" href="index.php#top">Home</a>
                                <a class="ar" href="index.php#about">About Us</a>
                                <a class="ar" href="index.php#low">Reach Us</a>
                                <a class="ar" href="#top">Menu</a>
                                <a class="ar" href="cart.php">Cart</a>
                                <?php
                                    if($user!=null){
                                ?>
                                    <div style="display: flex; justify-content: flex-end; flex-grow: 1;">
                                        <a class="ar" href="profile.php">ようこそ, <?= $user["nama"]?></a>
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
                        </div>
                
                             <div class="product">
                                 <center>
                                     <div class="htop">
                                        <p>Pick Category</p>
                                     </div>
                                    <div class ="path"></div>
                                    
                                    <div class="cards">
                                        <a class="circle"href="sushi.php">
                                            <img class="img" src="gallery/sushic.jpg" alt="">
                                            <div class="overlay">
                                                <h2>Sushi</h2>
                                            </div>
                                        </a>

                                        <a class="circle"href="ramen.php">
                                            <img src="gallery/ramenc.jpg" alt="">
                                            <div class="overlay">
                                                <h2>Ramen</h2>
                                            </div>
                                        </a>

                                        <a class="circle"href="rice.php">
                                            <img src="gallery/ricec.jpg" alt="">
                                            <div class="overlay">
                                                <h2>Rice</h2>
                                            </div>
                                        </a>

                                        <a class="circle"href="drink.php">
                                            <img src="gallery/sakec.jpg" alt="">
                                            <div class="overlay">
                                                <h2>Drink</h2>
                                            </div>
                                        </a>
                                    
                                        <a class="circle"href="dessert.php" style="text-decoration:none;display:block;">
                                            <img src="gallery/mochir.jpg" alt="">   
                                            <div class="overlay">
                                                <h2>Dessert</h2>
                                            </div>
                                        </a>

                                    </div>
                                </center>
                            </div>
                
                             <div class="foot">
                                <p class="copy">Copyright 2021 © Amazake</p>
                            </div>
                    </div>
                    </div>
</body>
</html>
