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
        $balance=$user["saldo"];
    }else{
        $user=[]; 
        $balance=0;
    }
    if(isset($_POST["topup"])){
        $username= $_SESSION["login"]["email"];
        $tot=$_POST["jum"];
        $stmt = $pdo->prepare("INSERT INTO pending(jumlah,email) values(?,?)");
        $stmt->execute([$tot,$username]);
        header("Location:profile.php");
    }
    
    if(isset($_SESSION["message"])){
        echo "<script>alert('$_SESSION[message]')</script>";
        unset($_SESSION["message"]);
    }
    $email=$user['email'];
    $stmt = $pdo->query("SELECT * FROM htrans where email='$email'");
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                            <h1>Name<span style="padding-left:45px;">: <?=$user["nama"]?></span></h1><br>
                                            <h1>Email<span style="padding-left:45px;">: <?=$user["email"]?></span></h1><br>
                                            <h1>Address<span style="padding-left:15px;">: <?=$user["alamat"]?> </span></h1><br>
                                            <h1>City <span style="padding-left:60px;">: <?=$user["kota"]?></span></h1><br>
                                        </div>

                                    </div>

                                    <div class="pright">
                                        <h2 style="color: #ffffff;">Your Balance is IDR <?=$balance?></h2><br>
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
                                        <h3>Purchase History</h3>
                                      </center>
                                      
                                       <br>
                                        <div class="htrans">
                                            
                                            <table>
                                                <thead>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($history !== null) {
                                                        $idx=1;
                                                        foreach ($history as $key => $value) {
                                                    ?>
                                                    <tr id="<?= $ctr?>">
                                                        <td><?= $value['tanggal']?></td>
                                                        <td>IDR <?= $value['total']?></td>
                                                    </tr>
                                                    <?php
                                                    $idx++;
                                                        }
                                                    }
                                                    if($idx == 1){
                                                    ?>
                                                    <td colspan="2">You don't have any transaction history</td>
                                                    <?php
                                                    }
                                                    ?>
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
