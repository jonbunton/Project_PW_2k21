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
                                 <div class="split">
                                    <div class="kotak1"></div>
                                    <div class="kotak2"></div>
                                 </div>

                                 <div class="split">
                                    <div class="kotak3"></div>
                                    <div class="kotak4"></div>
                                 </div>
                                
                                 <div class="judul">
                                     <center>
                                     <div class="a1">Welcome To</div>
                                     <div class="a2">Amazake</div>
                                     </center>
                                    
                                 </div>
                            </div>

                            <div class="product2">
                                <div class="up">

                                    <div class="upk">
                                        <img src="gallery/" alt="">
                                    </div>
                                    <div class="upb">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem ipsum omnis tenetur excepturi repudiandae distinctio dignissimos! Tempore voluptatum odit eveniet facere labore, earum quo, praesentium numquam sequi repellendus, necessitatibus vitae.
                                    </div>

                                </div>
                                <div class="up1">
                               
                                    
                                    <div class="bcard">
                                        <div class="card">
                                            
                                        </div>
                                        <div class="text">
                                            <h2>Edo Period</h2>
                                            <br>
                                        qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                        </div>
                                    </div>

                                    <div class="bcard">
                                            <div class="card">
                                            
                                            </div>
                                        <div class="text">
                                            <h2>Meiji Period</h2>
                                            <br>
                                        qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                        </div>
                                    </div>
                                    <div class="bcard">
                                            <div class="card">
                                            
                                            </div>
                                        <div class="text">
                                            <h2>Taishō period</h2>
                                            <br>
                                        qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                        </div>
                                    </div>
                                    <div class="bcard">
                                            <div class="card">
                                            
                                            </div>
                                        <div class="text">
                                            <h2>Shōwa period</h2>
                                            <br>
                                        qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                        </div>
                                    </div>
                                    <div class="bcard">
                                            <div class="card">
                                            
                                            </div>
                                        <div class="text">
                                            <h2>Heisei period</h2>
                                            <br>
                                        qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.</div>
                                    </div>

                                    <div class="bcard">
                                        <div class="card">
                                            
                                            </div>
                                        <div class="text">
                                            <h2>Reiwa period</h2>
                                            <br>
                                        qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.</div>
                                    </div>
            
                                </div>
                            </div>

                            <div class="product3">
                                
                                

                            </div>
                
                             <div class="foot">
                                <p class="copy">Copyright 2021 © Amazake</p>
                            </div>
                    </div>
                    </div>

</body>
</html>