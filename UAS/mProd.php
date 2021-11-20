<?php
    require_once("connection.php");

     $stmt = $pdo->query("SELECT * FROM product");
       $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <a class="ar" href="#top">Master User</a>
                    <a class="ar" href="#top">Master Product</a>
                    <a class="ar" href="#top">Transaction History</a>
                    <a class="ar" href="#top">TopUp Approval</a>
                    <div style="display: flex; justify-content: flex-end; flex-grow: 1;"></div>
                        <a class="ar" href="login.php">Login / Register</a>
                </div>
            </div>
            
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
                                            <td class="cell100 column6"><?= $value['saldo']?></td>
                                            
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