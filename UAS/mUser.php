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
       $stmt = $pdo->query("SELECT * FROM user");
       $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        header("location:login.php");
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
                    <!--  -->
                    <div>
                        <form action="" method="post">
                            <button class="logout-btn" name="logout">Log Out</button>
                        </form>
                    </div>
                    <!-- <a class="ar" href="Menu.php">Log Out</a>  -->
                </div>
            </div>
    
            <div class="product2">
                <form action="#" method="get">
                    <h2 class="ar">Search User</h2> 
                    <br>
                    <input type="text" name="keyword" id="" class="search"> <br>
                    <button  class="searchbtn">Search</button>
                </form>
                <br>
            
                <h2 class="ar">List User</h2>
                <br>
                <div class="table100 ver3 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">No.</th>
									<th class="cell100 column2">Nama</th>
									<th class="cell100 column3">Email</th>
                                    <th class="cell100 column4">Alamat</th>
									<th class="cell100 column5">Kota</th>
									<th class="cell100 column6">Saldo</th>
								</tr>
							</thead>
						</table>
					</div>

                    <div class="table100-body js-pscroll">
						<table>
							<tbody>
                                <?php
                                    if ($user !== null) {
                                        $idx=1;
                                        foreach ($user as $key => $value) {
                                    ?>
                                        <tr class="row100 body">
                                            <td class="cell100 column1"><?php echo $idx ?></td>
                                            <td class="cell100 column2"><?= $value['nama']?></td>
                                            <td class="cell100 column3"><?= $value['email']?></td>
                                            <td class="cell100 column4"><?= $value['alamat']?></td>
                                            <td class="cell100 column5"><?= $value['kota']?></td>
                                            <td class="cell100 column6">Rp. <?= $value['saldo']?></td>
                                            
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