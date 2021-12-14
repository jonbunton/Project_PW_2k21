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
        if($_SESSION["login"]=="admin"){
            header("location:muser.php");
        }
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
                                <a class="ar" href="#about">About Us</a>
                                <a class="ar" href="#low">Reach Us</a>
                                <a class="ar" href="menu.php">Menu</a>
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
                                     <div class="a1"> いらっしゃいませ</div>
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
                                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Officiis aspernatur explicabo dolore voluptate architecto commodi sit minus molestiae mollitia ipsum? Nemo hic laboriosam, earum quasi perspiciatis animi voluptatem reiciendis nulla.

                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lorem ipsum dolor, sit amet consectetur adipisicing elit. Debitis necessitatibus veritatis veniam esse quo saepe fugit quis ipsum cupiditate repellat minus impedit harum, architecto a reprehenderit at quos. Ad, maiores!
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id corrupti quam laborum deserunt eveniet ducimus saepe. Laudantium ducimus hic ab, ratione corporis accusantium delectus corrupti sit soluta qui nobis quibusdam.
                                       </div>
                                    </div>
                                </div>
                                <br>
                                <center>
                                <h1 style="font-family: myFt; height: 80px; margin-top: 20px;">Our Historical Food</h1>
                                </center>
                                
                                <div class="up1">
                                    
                                    <div class="coba">
                                        <div class="card cbg1" ></div>
                                        
                                        <div class="bcard" >
                                            
                                            <div class="text">
                                                <h2>Edo Period</h2>
                                                <br>
                                            qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="coba">
                                        <div class="card cbg2" ></div>
                                        
                                        <div class="bcard" >
                                            
                                            <div class="text">
                                                <h2>Meiji Period</h2>
                                                <br>
                                            qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="coba">
                                        <div class="card cbg3" ></div>
                                        
                                        <div class="bcard" >
                                            
                                            <div class="text">
                                                <h2>Taishou Period</h2>
                                                <br>
                                            qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="coba">
                                        <div class="card cbg4" ></div>
                                        
                                        <div class="bcard" >
                                            
                                            <div class="text">
                                                <h2>Shōwa Period</h2>
                                                <br>
                                            qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="coba">
                                        <div class="card cbg5" ></div>
                                        
                                        <div class="bcard" >
                                            
                                            <div class="text">
                                                <h2>Heisei Period</h2>
                                                <br>
                                            qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="coba">
                                        <div class="card cbg6" ></div>
                                        
                                        <div class="bcard" >
                                            
                                            <div class="text">
                                                <h2>Reiwa Period</h2>
                                                <br>
                                            qui veritatis. Fugit quaerat sit porro, facere minus eaque consequuntur distinctio.
                                            </div>
                                        </div>
                                    </div>
            
                                </div>
                            </div>

                            <div class="product3" id="low">
                                <div class="p31">
                                <img class="logo" src="gallery/logo2.png" alt="" style="width:400px; height:100px;" >
                                <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia corrupti cum consectetur quae, amet corporis reiciendis reprehenderit beatae debitis deserunt ut ad mollitia architecto. Blanditiis quis itaque earum laborum nisi?
                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, asperiores suscipit ullam aliquid rerum eligendi facilis consequuntur ab sapiente ea quaerat porro vero tenetur odit totam vel accusamus aspernatur temporibus.
                                   </p>
                                    <br><br>
                                    <P style="font-family: myFt;">Thank you our loyal customer</P> 
                                    <br><br>

                                </p>
                                </div>

                                    <!-- 2 -->
                                <div class="p32">
                                    <center>
                                        <h1>Opening Hours</h1>
                                        <br><br>
                                        Monday to Friday <br><br>
                                        08:00 until 15:00 <br>
                                        16:00 until 21:00 <br><br><br>

                                        Saturday to Sunday <br><br>
                                        08:00 until 15:00 <br>
                                        16:00 until 23:00 <br>
                                    </center>
                                    
                                </div>

                                    <!-- 3 -->
                                <div class="p33">
                                    <center>
                                        <h1>Contact Us</h1>
                                    </center> 
                                        <br><br>
                                        <img src="gallery/ig.png" alt="">
                                        &nbsp;&nbsp;&nbsp;Amazake.ig <br>
                                        <img src="gallery/TW.png" alt="">
                                        &nbsp;&nbsp;&nbsp;Amazake.twt <br>
                                        <img src="gallery/fb.png" alt="">
                                        &nbsp;&nbsp;&nbsp;Amazake Indonesia <br><br>
                                        <hr><br>
                                        <center>
                                            Contact Person <br>
                                            Jonathan  +62123123123 <br>
                                            Kevin S +62123123123 <br>
                                            Veronica +62123123123 <br>
                                        </center>
                                       
                                    

                                </div>
                                

                            </div>
                
                             <div class="foot">
                                <p class="copy">Copyright 2021 © Amazake</p>
                            </div>
                    </div>
                    
<script language :"javascript">

</script>
</body>
</html>