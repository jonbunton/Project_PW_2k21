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
        $_SESSION["message"]="Mohon Login Terlebih dahulu"; 
        unset($_SESSION["cart"]);
        header("location:login.php");
    }
    if(isset($_SESSION["message"])){
        echo "<script>alert('$_SESSION[message]')</script>";
        unset($_SESSION["message"]);
    }
    function rupiah($angka){
	    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah; 
    }

    if(isset($_GET["desk"])){
        $cek=$_GET["desk"];
        $stmt = $pdo->prepare("SELECT * FROM product WHERE id_product = ?");
        $keyword = $cek;
        $stmt->execute([$keyword]);
        $det = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
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
                                <a class="ar" href="menu.php">Menu</a>
                                <a class="ar" href="cart.php">Cart</a>
                                <?php
                                    if($user!=null){
                                ?>
                                    <div style="display: flex; justify-content: flex-end; flex-grow: 1;">
                                        <a class="ar title99" href="profile.php">ようこそ, <?= $user["nama"]?></a>
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
                                        <p>Sushi</p>
                                 </div>
                                <div class ="path2"></div>
                                <br>
                                </center>
                                <br>

                                <!-- menu -->
                                <div class="tempMenu with-border-image">
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
                                                    <div class="mup"><img onclick="myFunction2(<?=$values['id_product']?>)" class="mup" src="gallery/<?=$values["id_product"]+1?>.jpg" alt=""></div>
                                                    <div class="mdown">
                                                        <div class="mdleft">
                                                            <div class="mname title99"><?=$values["nama"]?></div>
                                                            <div class="mdes"><?=$values["deskripsi"]?></div>
                                                        </div>
                                                        <div class="mdright">
                                                            <div class="harga"><?=rupiah($values["harga"])?></div>
                                                            <div class="addcart"><button onclick="myFunction()" class="btn_cart" name="cart" value=<?=$values["id_product"]?>>Add to cart</button></div>
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
                             <p class="copy">Copyright 2021 © Amazake</p>
                                <!-- <form action="" method="post">
                                    <button name="logout">Logout</button>
                                </form> -->
                            </div>
                    </div>
                    </div>

                    <div id="myModal" class="modal">
                        <!-- Modal content -->

                        <div class="modal-content">
                        <span class="close">&times;</span>
                            <h1>Menu Has Been Added To Cart</h1>
                            
                        </div>
                    </div>
                    </div>

                    <div id="myModal2" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                <span class="close2">&times;</span>
                    <h1>Deskripsi Produk</h1>
                    <?php
                        foreach($det as $key => $values)
                        {
                    ?>
                    <img class="mup" src="gallery/<?=$values["id_product"]+1?>.jpg" alt="">
                    <h2><?=$values["deskripsi"]?></h2>
                    <?php
                        }
                    ?> 
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

    window.onload = function() {
        let params = new URLSearchParams(location.search);
        if(params.has('desk')== true){
            myFunction3();     
        }
        
    };
    function myFunction() {
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            var span = document.getElementsByClassName("close")[0];
            span.onclick = function() {
            modal.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

        } 

        function myFunction2(x) {
            window.location.href="sushi.php?desk="+x;

        }

        function myFunction3() {
            var modal2 = document.getElementById("myModal2");
            modal2.style.display = "block";
            var span2 = document.getElementsByClassName("close2")[0];
            span2.onclick = function() {
            modal2.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == modal2) {
                    modal2.style.display = "none";
                }
            }

        }
	</script>
</body>
</html>