<?php
    require_once("connection.php");

    if(isset($_GET["keyword"])){
        
        $stmt = $pdo->prepare("SELECT * FROM history WHERE email like ?");
    $keyword = "%".$_GET["keyword"]."%";
    $stmt->execute([$keyword]);
    $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);

     }
     else{
       $stmt = $pdo->query("SELECT * FROM history");
       $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     if(isset($_GET["detail"])){
        $cek=$_GET["detail"];
        $cek=$_GET["kurang"];
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id_htrans = ?");
        $keyword = $cek;
        $stmt->execute([$keyword]);
        $det = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $test=$_GET["detail"];
     }


     if(isset($_SESSION["login"]))
    {
        $login=$_SESSION["login"];
        if($login!="admin"){
            header("location:Menu.php");
        }
    }
    else{
        header("location:Menu.php");
    }
    if(isset($_POST['logout']))
    {
        unset($_SESSION["login"]);
        unset($_SESSION["cart"]);
        header("location:login.php");
    } 
    if (isset($_POST['submit'])) {
        
        if($_POST['urut']=="turun"){
            if ($_POST['urut2']=="id") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY id_history DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else if ($_POST['urut2']=="email") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY email DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="wkt") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY waktu DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="tgl") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY tanggal DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="saldo") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY saldo DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
        }
        else if($_POST['urut']=="naik"){
            if ($_POST['urut2']=="id") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY id_history ASC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else if ($_POST['urut2']=="email") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY email ASC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="wkt") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY waktu ASC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="tgl") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY tanggal ASC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="saldo") {
                $stmt = $pdo->prepare("SELECT * FROM history ORDER BY saldo ASC");
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
            
                <h2 class="ar">History Top Up</h2>
                <br>
                <div class="table100 ver3 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">ID</th>
									<th class="cell100 column2">Email</th>
									<th class="cell100 column3">Waktu</th>
                                    <th class="cell100 column4">tanggal</th>
									<th class="cell100 column5">Saldo</th>
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
                                            <td class="cell100 column5"><?= rupiah($value['saldo'])?></td>
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