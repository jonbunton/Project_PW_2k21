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
    <link href="index.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

</head>
<body>
                    <div class="container">
                
                        <div class="header" id="top">    
                            <div class="nav">
                                <img class="logo" src="gallery/logo.png" alt="">
                                <a class="ar" href="#top">Home</a>
                                <a class="ar" href="#top">About Us</a>
                                <a class="ar" href="#top">Location</a>
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

                            <div class="judul">
                                <center>
                                <div class="a1">Welcome To</div>
                                <div class="a2">Amazake</div>
                                </center>
                            
                            </div>
                        </div>

                        <div class="product2" id="about">
                            <div class="arrow">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                            
                            </div>
                                <div class="up">

                                    <div class="upk">
                                        <div id="sld">
                                        </div>
                                    </div>
                                    <div class="upb">
                                        
                                        <div class="hst">History</div>
                                        <div class="hso">of</div>
                                        <div class="hsa">Amazake</div>
                                         <br><br>
                                       <div>
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lorem ipsum dolor, sit amet consectetur adipisicing elit. Debitis necessitatibus veritatis veniam esse quo saepe fugit quis ipsum cupiditate repellat minus impedit harum, architecto a reprehenderit at quos. Ad, maiores!
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id corrupti quam laborum deserunt eveniet ducimus saepe. Laudantium ducimus hic ab, ratione corporis accusantium delectus corrupti sit soluta qui nobis quibusdam.
                                        

                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lorem ipsum dolor, sit amet consectetur adipisicing elit. Debitis necessitatibus veritatis veniam esse quo saepe fugit quis ipsum cupiditate repellat minus impedit harum, architecto a reprehenderit at quos. Ad, maiores!
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id corrupti quam laborum deserunt eveniet ducimus saepe. Laudantium ducimus hic ab, ratione corporis accusantium delectus corrupti sit soluta qui nobis quibusdam.
                                       </div>
                                    </div>
                                </div>
                                <center>
                                <h1>-Our History Food-</h1>
                                </center>
                                
                               
                        </div>
                
                             <div class="foot">
                                <p class="copy">Copyright 2019 © Amazake</p>
                            </div>
                    </div>
                    </div>
</body>
</html>
