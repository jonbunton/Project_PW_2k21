<?php
    require_once("connection.php");

    if(isset($_GET["keyword"])){
        
        $stmt = $pdo->prepare("SELECT * FROM user WHERE nama like ?");
        $keyword = "%".$_GET["keyword"]."%";
        $stmt->execute([$keyword]);
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(isset($user)){
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email like ?");
    $keyword = "%".$_GET["keyword"]."%";
    $stmt->execute([$keyword]);
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     }
     else{
       $stmt = $pdo->query("SELECT * FROM history");
       $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     if(isset($_GET["detail"])){

        $cek=$_GET["detail"];
        $stmt = $pdo->prepare("DELETE FROM namadb WHERE id = :iddb");

        $result = $stmt->execute([
        "iddb"=>$cek
        ]);

        if($result){
        $_SESSION["message"] = "Berhasil denied ";
        }else{
        $_SESSION["message"] = "Gagal denied !";
        }
        
        header("Location: top_req.php");
     }

     if(isset($_GET["detail2"])){
        $cek=$_GET["detail2"];
        $cek=$_GET["kurang"];

        $id = $_GET["edit"];
        $stmt = $pdo->query("SELECT * FROM namadb WHERE id='$cek'");
        $edi = $stmt->fetch(PDO::FETCH_ASSOC);

        $wkt=$edi['waktu'];
        $tgl=$edi['tanggal'];
        $sld=$edi['saldo'];
        $eml=$edi['email'];

        $stmt = $pdo->prepare("INSERT INTO history(waktu,tanggal, saldo, email) VALUES(?,?,?,?)");
        $result = $stmt->execute([$wkt, $tgl, $sld, $eml]);
        
        
        if($result){
            $_SESSION["message"] = "Berhasil add nih";
        }else{
        $_SESSION["message"] = "Gagal add nih!";
        }}
     

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
    <link href="mycssadmin.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

</head>
<body>
        <div class="container">
    
            <div class="header" id="top">    
                <div class="nav">
                    <img class="logo" src="gallery/logo.png" alt="">
                    <a class="ar" href="mUser.php">Master User</a>
                    <a class="ar" href="mProd.php">Master Product</a>
                    <a class="ar" href="Hist_trans.php">Transaction History</a>
                    <a class="ar" href="top_req.php">TopUp Request</a>
                    <a class="ar" href="Hist_top.php">TopUp History</a>
                    <div style="display: flex; justify-content: flex-end; flex-grow: 1;"></div>
                        <a class="ar" href="login.php">Login / Register</a>
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
            
                <h2 class="ar">Request Top Up</h2>
                <br>
                <div class="table100 ver3 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">No</th>
									<th class="cell100 column2">Email</th>
									<th class="cell100 column3">Waktu</th>
                                    <th class="cell100 column4">tanggal</th>
									<th class="cell100 column5">Saldo</th>
                                    <th class="cell100 column6">Status</th>
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
                                            <td class="cell100 column1"><?= $value['id_history']?></td>
                                            <td class="cell100 column2"><?= $value['email']?></td>
                                            <td class="cell100 column3"><?= $value['waktu']?></td>
                                            <td class="cell100 column4"><?= $value['tanggal']?></td>
                                            <td class="cell100 column5"><?= $value['saldo']?></td>
                                            <td class="cell100 column6 detailbtn">
                                                <form action="#" method="get">
                                                    <input type="hidden" name="detail" value="<?= $value['id_history']?>">
                                                    <button>Denied</button>
                                                </form>
                                                <form action="#" method="get">
                                                    <input type="hidden" name="detail2" value="<?= $value['id_history']?>">
                                                    <input type="hidden" name="kurang" value="<?= $value['saldo']?>">
                                                    <button>Accept</button>
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
        
</body>
</html>