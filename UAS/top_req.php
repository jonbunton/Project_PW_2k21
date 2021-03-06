<?php
    require_once("connection.php");


    $stmt = $pdo->query("SELECT * FROM pending");
    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_GET["detail"])){
        $Nama_org = $_GET["detail"];
    
        $stmt = $pdo->prepare("SELECT * FROM pending WHERE id_pending = :Nama_org");
        $result = $stmt->execute(["Nama_org"=>$Nama_org]);
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($user as $key => $value) {
            $email=$value['email'];
            $waktu=$value['waktu'];
            $tanggal=$value['tanggal'];
            $saldo=$value['jumlah'];
        }

        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :Nama_org");
        $result = $stmt->execute(["Nama_org"=>$email]);
        $user2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($user2 as $key => $value) {
            $saldo2=$value['saldo'];
        }
        $saldo3=$saldo+$saldo2;

        $stmt = $pdo->prepare("INSERT INTO denied(waktu,tanggal,jumlah,email) VALUES(?,?,?,?)");
        $result = $stmt->execute([$waktu, $tanggal, $saldo, $email]);

        $stmt = $pdo->prepare("DELETE FROM pending WHERE id_pending = :Nama_org");
        $result = $stmt->execute([
        "Nama_org"=>$Nama_org
        ]);

        header("Location: top_req.php");
    }

    if(isset($_GET["detail2"])){
        $Nama_org = $_GET["detail2"];

        $stmt = $pdo->prepare("SELECT * FROM pending WHERE id_pending = :Nama_org");
        $result = $stmt->execute(["Nama_org"=>$Nama_org]);
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($user as $key => $value) {
            $email=$value['email'];
            $waktu=$value['waktu'];
            $tanggal=$value['tanggal'];
            $saldo=$value['jumlah'];
        }

        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :Nama_org");
        $result = $stmt->execute(["Nama_org"=>$email]);
        $user2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($user2 as $key => $value) {
            $saldo2=$value['saldo'];
        }
        $saldo3=$saldo+$saldo2;

        $stmt = $pdo->prepare("INSERT INTO history(waktu,tanggal,saldo,email) VALUES(?,?,?,?)");
        $result = $stmt->execute([$waktu, $tanggal, $saldo, $email]);

        $stmt = $pdo->prepare("UPDATE user SET saldo='$saldo3' WHERE email = '$email'");
        $result = $stmt->execute();
        
        $stmt = $pdo->prepare("DELETE FROM pending WHERE id_pending = :Nama_org");
        $result = $stmt->execute(["Nama_org"=>$Nama_org]);

        header("Location: top_req.php");

    }
    
    if(isset($_SESSION["message"])){
        echo "<script>alert('$_SESSION[message]')</script>";
        unset($_SESSION["message"]);}

        if (isset($_POST['submit'])) {
        
            if($_POST['urut']=="turun"){
                if ($_POST['urut2']=="id") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY id_pending DESC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                else if ($_POST['urut2']=="email") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY email DESC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                elseif ($_POST['urut2']=="wkt") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY waktu DESC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                elseif ($_POST['urut2']=="tgl") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY tanggal DESC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                elseif ($_POST['urut2']=="saldo") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY jumlah DESC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                
            }
            else if($_POST['urut']=="naik"){
                if ($_POST['urut2']=="id") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY id_pending ASC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                else if ($_POST['urut2']=="email") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY email ASC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                elseif ($_POST['urut2']=="wkt") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY waktu ASC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                elseif ($_POST['urut2']=="tgl") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY tanggal ASC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                elseif ($_POST['urut2']=="saldo") {
                    $stmt = $pdo->prepare("SELECT * FROM pending ORDER BY jumlah ASC");
                    $stmt->execute();
                    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            
        }
        if(isset($_GET["status"])){
            unset($_SESSION["login"]);
                
            header("Location: index.php");
        }
        function rupiah($angka){
            $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
            return $hasil_rupiah; 
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazake</title>
    <link href="mycssadmin.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

</head>
<body>
        <div class="container">
    
            <div class="header" id="top">    
                <div class="nav">
                    <img class="logo" src="gallery/logo.png" alt="">
                    <a class="ar" href="mUser.php">List User</a>
                    <a class="ar" href="mProd.php">Master Product</a>
                    <a class="ar" href="Hist_trans.php">Transaction History</a>
                    <a class="ar" href="top_req.php">TopUp Request</a>
                    <a class="ar" href="Hist_top.php">TopUp History</a>
                    <div style="display: flex; justify-content: flex-end; flex-grow: 1;"></div>
                    <a class="ar" href="mUser.php?status=log">Log Out</a>
                </div>
            </div>
    
            <div class="product4">
                <form action="#" method="get">
                    <h2 class="ar">Search User</h2> 
                    <br>
                    <input type="text" name="keyword" id="" class="search"> <br>
                    <button  class="searchbtn">Search</button>
                </form>
                <br>
                <form action="" method="post">
                <h2 class="ar">Sort</h2> 
                    <select name="urut" class="search">
                        <option value="" disabled selected>Choose Sort Order</option>
                        <option value="turun">Descending</option>
                        <option value="naik">Ascending</option>
                    </select>
                    <br>
                    <select name="urut2" class="search">
                        <option value="" disabled selected>Choose Sort Header</option>
                        <option value="id">ID</option>
                        <option value="email">Email</option>
                        <option value="wkt">Waktu</option>
                        <option value="tgl">Tanggal</option>
                        <option value="saldo">Saldo</option>
                    </select>
                    <br>
                    <input type="submit" name="submit" vlaue="Sort Product" class="searchbtn">
                </form>
                <br>
            
                <h2 class="ar">Request Top Up</h2>
                <br>
                <div class="table100 ver3 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">No</th>
									<th class="cell100 column2">Email</th>
									<th class="cell100 column7">Waktu</th>
                                    <th class="cell100 column8">tanggal</th>
									<th class="cell100 column8">Saldo</th>
                                    <th class="cell100 column8">Status</th>
								</tr>
							</thead>
						</table>
					</div>

                    <div class="table100-body js-pscroll">
						<table>
							<tbody>
                                <?php
                                    if ($hist !== null) {
                                        $idx=1;
                                        foreach ($hist as $key => $value) {
                                    ?>
                                        <tr class="row100 body">
                                            <td class="cell100 column1"><?= $value['id_pending']?></td>
                                            <td class="cell100 column2"><?= $value['email']?></td>
                                            <td class="cell100 column7"><?= $value['waktu']?></td>
                                            <td class="cell100 column8"><?= $value['tanggal']?></td>
                                            <td class="cell100 column8">Rp. <?= $value['jumlah']?></td>
                                            <td class="cell100 column8 detailbtn">
                                                <form action="#" method="get">
                                                    <input type="hidden" name="detail" value="<?= $value['id_pending']?>">
                                                    <button onclick="return confirm('Denied top up?')">Denied</button>
                                                </form>
                                                <form action="#" method="get">
                                                    <input type="hidden" name="detail2" value="<?= $value['id_pending']?>">
                                                    <button onclick="return confirm('Accept top up?')">Accept</button>
                                                </form>
                                            </td>
                                            
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
            
            <div class="foot">
                <p class="copy">Amazake social media</p>
            </div>
        </div>

        <script>

            function myFunction() {
                window.confirm("Accept the top up?");
                location.reload();
                
            }
            function myFunction2() {
                window.confirm("Denied the top up?")
                location.reload();
            }
            
        </script>
        
</body>
</html>