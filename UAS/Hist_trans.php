<?php
    require_once("connection.php");

    if(isset($_GET["keyword"])){

        $originalDate = $_GET["keyword"];
        $newDate = date("Y-m-d", strtotime($originalDate));

        $originalDate = $_GET["keyword2"];
        $newDate2 = date("Y-m-d", strtotime($originalDate));

        $stmt = $pdo->prepare("SELECT * FROM htrans WHERE tanggal >= ? AND tanggal <= ?");
        $stmt->execute([$newDate,$newDate2]);
        $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
     else{
       $stmt = $pdo->query("SELECT * FROM htrans");
       $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     if(isset($_GET["detail"])){
        $cek=$_GET["detail"];
        $stmt = $pdo->prepare("SELECT * FROM dtrans WHERE id_htrans = ?");
        $keyword = $cek;
        $stmt->execute([$keyword]);
        $det = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $test=$_GET["detail"];
     }
     else{
        $stmt = $pdo->query("SELECT * FROM dtrans");
        $det = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY id_htrans DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="email") {
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY email DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="total") {
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY total DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="tgl") {
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY tanggal DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="wkt") {
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY waktu DESC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
        }
        else if($_POST['urut']=="naik"){
            if ($_POST['urut2']=="id") {
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY id_htrans ASC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="email") {
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY email ASC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="total") {
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY total ASC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="tgl") {
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY tanggal ASC");
                $stmt->execute();
                $hist = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="wkt") {
                $stmt = $pdo->prepare("SELECT * FROM htrans ORDER BY waktu ASC");
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
    
            <div class="product3">
            
                <form action="#" method="get">
                    <h2 class="ar">Search Date</h2> 
                    <br>
                    <p>from: </p>
                    <input type="date" name="keyword" id="" class="search"> <br>
                    <p>To: </p>
                    <input type="date" name="keyword2" id="" class="search"> <br>
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
                        <option value="total">Total</option>
                        <option value="tgl">Tanggal</option>
                        <option value="wkt">Waktu</option>
                    </select>
<br>
                    <input type="submit" name="submit" vlaue="Sort Product" class="searchbtn">
                </form>
            <br>
                <h2 class="ar">History Transaksi</h2>
                <br>
                <div class="table100 ver3 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">ID</th>
									<th class="cell100 column2">Email</th>
									<th class="cell100 column3">total</th>
                                    <th class="cell100 column4">tanggal</th>
									<th class="cell100 column5">Waktu</th>
                                    <th class="cell100 column6">Detail</th>
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
                                            <td class="cell100 column1"><?= $value['id_htrans']?></td>
                                            <td class="cell100 column2"><?= $value['email']?></td>
                                            <td class="cell100 column3"><?=rupiah( $value['total'])?></td>
                                            <td class="cell100 column4"><?= $value['tanggal']?></td>
                                            <td class="cell100 column5"><?= $value['waktu']?></td>
                                            <td class="cell100 column6 detailbtn">
                                            <form action="#" method="get">
                                                <input type="hidden" name="detail" value="<?= $value['id_htrans']?>">
                                                <button onclick="myFunction()">Detail</button>
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
                                        <th class="cell100 column1">ID </th>
                                        <th class="cell100 column2">ID Product</th>
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
                                            foreach ($det as $key => $values) {
                                        ?>
                                            <tr class="row100 body">
                                                <td class="cell100 column1"><?= $values['id_htrans']?></td>
                                                <td class="cell100 column2"><?= $values['id_product']?></td>
                                                <td class="cell100 column3"><?= $values['nama_product']?></td>
                                                <td class="cell100 column4"><?= ($values['jumlah'])?></td>
                                                <td class="cell100 column5"><?= rupiah($values['subtotal'])?></td>
                                                <td class="cell100 column6"><?= rupiah($values['harga'])?></td>    
                                                
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
                else{

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
            
        </script>

        
</body>
</html>