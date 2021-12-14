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
        }else{
            $balance=$user["saldo"];
        }
        
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

    if(isset($_GET["detail"])){
        $cek=$_GET["detail"];
        $stmt = $pdo->prepare("SELECT * FROM history WHERE email = ?");
        $keyword = $cek;
        $stmt->execute([$keyword]);
        $det = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $test=$_GET["detail"];
     }
     else{
        $stmt = $pdo->query("SELECT * FROM history");
        $det = $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     if(isset($_GET["edit"])){
        $id = $_GET["edit"];
      $stmt = $pdo->query("SELECT * FROM user WHERE email='$id'");
      $edi = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if(isset($_POST['edit']))
    {
        $id = $_GET["edit"];
        $nama = $_POST["Nama"];
        $psw = $_POST["psw"];
        $alm = $_POST["alm"];
        $psw2 = $_POST["psw2"];
        $kota = $_POST["kota"];
        
        $result =false;
        if(isset($nama) && $nama!=""){
            if(isset($alm) && $alm!=""){
                if(isset($kota) && $kota!=""){
                    if ($psw==$psw2) {
                        $stmt = $pdo->prepare("UPDATE user SET password='$psw', nama='$nama', alamat='$alm', kota='$kota' WHERE email = '$id'");
                        $result = $stmt->execute();

                        
                    }
                    
                }   
            }
        }	
        $id2=$user["email"];
        $stmt = $pdo->query("SELECT * FROM user WHERE email='$id2'");
        $edi2 = $stmt->fetch(PDO::FETCH_ASSOC);
        unset($_SESSION["login"]);
        $_SESSION["login"]=$edi2;   
        header("Location: profile.php");
            
    }

    if(isset($_GET["detail3"])){
        $cek=$_GET["detail3"];
        $stmt = $pdo->prepare("SELECT * FROM dtrans WHERE id_htrans = ?");
        $keyword = $cek;
        $stmt->execute([$keyword]);
        $det2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
     else{
        // $stmt = $pdo->query("SELECT * FROM history");
        // $det = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $stmt = $pdo->query("SELECT * FROM history");
        // $det = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                        <a class="ar title99" href="#top">ようこそ, <?= $user["nama"]?></a>
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
                                <div class ="inprofile blur2">

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
                                            <form action="#" method="get">
                                                <input type="hidden" name="edit" value="<?= $user["email"]?>">
                                                <button onclick="myFunction()" class="buttonto2">Edit User</button>
                                            </form>
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
                                            <br>
                                            <form action="#" method="get">
                                                <input type="hidden" name="detail" value="<?= $user["email"]?>">
                                                <button onclick="myFunction()" class="buttonto2">History Top Up</button>
                                            </form>
                                        </div>
                                        
                                      <br>
                                      <center>
                                        <h2 class="title99">Purchase History</h2>
                                      </center>
                                      
                                       <br>
                                        <div class="htrans">
                                            
                                            <table>
                                                <thead>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Detail</th>
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
                                                        <td><form action="#" method="get">
                                                            <input type="hidden" name="detail3" value="<?= $value['id_htrans']?>">
                                                            <button onclick="myFunction()">Detail</button>
                                                        </form></td>
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
                                                <button class="buttonlo"name="logout"> Logout</button>
                                            </form> 
                                        </div>
                                   
                                    </div>
                                </div>

                            </div>
                
                             <div class="foot">
                                <p class="copy">Copyright 2021 © Amazake</p>
                            </div>
                    </div>

                    <!-- Untuk pop up box detail -->
                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                        <!-- Modal content -->

                        <div class="modal-content">
                        <span class="close">&times;</span>
                            <h1>Detail Transaction</h1>
                            <div class="table100 ver3 m-b-110">
                                <div class="table100-head">
                                    <table>
                                        <thead>
                                            <tr class="row100 head">
                                                <th class="cell100 column1">ID</th>
                                                <th class="cell100 column2">Email</th>
                                                <th class="cell100 column3">Waktu</th>
                                                <th class="cell100 column4">Tanggal </th>
                                                <th class="cell100 column5">Saldo</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="table100-body js-pscroll">
                                    <table>
                                        <tbody>
                                            <?php
                                                if ($det !== null) {
                                                    $idx=1;
                                                    foreach ($det as $key => $values) {
                                                ?>
                                                    <tr class="row100 body">
                                                        <td class="cell100 column1"><?= $values['id_history']?></td>
                                                        <td class="cell100 column2"><?= $values['email']?></td>
                                                        <td class="cell100 column3"><?= $values['waktu']?></td>
                                                        <td class="cell100 column4"><?= $values['tanggal']?></td>
                                                        <td class="cell100 column5"><?= $values['saldo']?></td>
                                                        
                                                    </tr>
                                                <?php
                                                $idx++;
                                                    }
                                                }
                                            ?>
                                            
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Untuk pop up box edit -->
            <div id="myModal2" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                <span class="close2">&times;</span>
                    <h1>Edit User <?php echo $_GET["edit"] ?></h1>
                    <form method="post" enctype="multipart/form-data">
                
                    <label for="nama"><b>Nama</b></label>
                    <input type="text" placeholder="Enter Nama Product" name="Nama" id="Nama" value="<?=$edi['nama']?>">

                    <label for="pass"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" id="psw" value="<?=$edi['password']?>">
                    
                    <label for="pass"><b>Confirm Password</b></label>
                    <input type="password" placeholder="Confirm Password" name="psw2" id="psw2"value="<?=$edi['password']?>">

                    <label for="alam"><b>Alamat</b></label>
                    <input type="text" placeholder="Enter Alamat" name="alm" id="alm" value="<?=$edi['alamat']?>" >

                    <label for="Kota"><b>Kota</b></label>
                    <input type="text" placeholder="Enter Kota" name="kota" id="kota" value="<?=$edi['kota']?>" ><br>

                    <input type="submit" value="Edit User" name="edit" class="searchbtn">
                </form>
                </div>

            </div>
            <!-- Untuk pop up box detail -->
            <!-- The Modal -->
            <div id="myModal3" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                <span class="close3">&times;</span>
                    <h1>Detail Transaction</h1>
                    <div class="table100 ver3 m-b-110">
                        <div class="table100-head">
                            <table>
                                <thead>
                                    <tr class="row100 head">
                                        <th class="cell100 column1">ID </th>
                                        <th class="cell100 column3">Nama</th>
                                        <th class="cell100 column4">Jumlah</th>
                                        <th class="cell100 column5">Sub Total</th>
                                        <th class="cell100 column6">Harga</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="table100-body js-pscroll">
                            <table>
                                <tbody>
                                    <?php
                                        if ($det !== null) {
                                            $idx=1;
                                            foreach ($det2 as $key => $values) {
                                        ?>
                                            <tr class="row100 body">
                                                <td class="cell100 column1"><?= $values['id_htrans']?></td>
                                                <td class="cell100 column3"><?= $values['nama_product']?></td>
                                                <td class="cell100 column4"><?= $values['jumlah']?></td>
                                                <td class="cell100 column5">Rp. <?= $values['subtotal']?></td>
                                                <td class="cell100 column6">Rp. <?= $values['harga']?></td>    
                                                
                                            </tr>
                                        <?php
                                        $idx++;
                                            }
                                        }
                                    ?>
                                    
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

                    </div>

                    <script>
                        window.onload = function() {
                            let params = new URLSearchParams(location.search);
                            if(params.has('detail')== true){
                                myFunction2();     
                            }
                            else if(params.has('edit')== true){
                                myFunction3();     
                            }
                            else if(params.has('detail3')== true){
                                myFunction4();     
                            } 
                        };

                        function myFunction() {
                            location.reload();
                            
                        }
                        function myFunction2() {
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

                        function myFunction4() {
                            var modal3 = document.getElementById("myModal3");
                            modal3.style.display = "block";
                            var span3 = document.getElementsByClassName("close3")[0];
                            span3.onclick = function() {
                            modal3.style.display = "none";
                            }
                            window.onclick = function(event) {
                                if (event.target == modal3) {
                                    modal3.style.display = "none";
                                }
                            }
                        }
                        
                    </script>
</body>
</html>
