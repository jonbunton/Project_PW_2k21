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
                                        <a class="ar" href="login.php">Login/Register</a>
                                    </div>
                                <?php
                                    }
                                ?>
                             </div>
                        </div>
                
                             <div class="Bprofile">
                                <div class ="inprofile">

                                     <div class="pleft">

                                        <div class="pct_profile">
                                            <div class="prfl">

                                           
                                            </div>    
                                            <center>
                                                <br>
                                                <div class="namepf"><?= $user["nama"]?></div>
                                            </center>
                                            
                                        </div>

                                        <div class="d_profile">
                                            <!-- data user -->
                                            namaaaa
                                        </div>

                                    </div>

                                    <div class="pright">
                                        <h2 style="color: #ffffff;">Your Balance is IDR .......</h2><br>
                                        <div class="topupp">
                                            <h4>Masukan jumlah topup</h4>
                                             <br>
                                            <form action="" method="post">
                                                <input type="number" name="jum" id="" min="0">
                                                <br>
                                                <button class="buttonto" name="topup">Top Up</button>
                                            </form>
                                        </div>
                                      <br><br>
                                      <center>
                                        <h3>History</h3>
                                      </center>
                                      
                                       <br>
                                        <div class="htrans">
                                            
                                            <table>
                                                <thead>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                </thead>
                                                <tbody>
                                                    <tr id="<?= $ctr?>">
                                                        <td>12 Desember 2021</td>
                                                        <td>300000</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="logout">
                                            <form action="" method="post">
                                                <button class="buttonlo"name="logout">Logout</button>
                                            </form> 
                                        </div>
                                   
                                    </div>
                                </div>

                            </div>
                
                             <div class="foot">
                                <p class="copy">Copyright 2019 © Amazake</p>
                            </div>
                    </div>
                    </div>
</body>
</html>
