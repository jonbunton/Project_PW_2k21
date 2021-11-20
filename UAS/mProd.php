<?php
    require_once("connection.php");

    $stmt = $pdo->query("SELECT * FROM product");
    $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT * FROM kategori");
    $kate = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

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
                    <a class="ar" href="mUser.php">Master User</a>
                    <a class="ar" href="mProd.php">Master Product</a>
                    <a class="ar" href="Hist_trans.php">Transaction History</a>
                    <a class="ar" href="Hist_top.php">TopUp History</a>
                    <div style="display: flex; justify-content: flex-end; flex-grow: 1;"></div>
                        <a class="ar" href="login.php">Login / Register</a>
                </div>
            </div>

            
    
            <div class="product">
                <h2 class="ar">Add Product</h2>

                <form method="POST" action="Control.php">
                    <input type="hidden" name="action" value="addprod">
                    <label for="nama"><b>Nama</b></label>
                    <input type="text" placeholder="Enter Nama Product" name="Nama" id="Nama" >

                    <label for="email"><b>Jenis</b></label>
                    <select name="genre_id" id="">
                    <?php
                            if ($kate !== null) {
                                foreach ($kate as $key => $values) {
                            ?>
                        <option value="<?= $values['id_jenis']?>"><?= $values['jenis']?></option>
                    <?php
                                    }
                                }
                        ?>
                    </select>

                    <label for="psw"><b>Harga (Dalam Rupiah)</b></label>
                    <input type="text" placeholder="Enter Harga" name="hrg" id="hrg" >

                    <label for="psw-repeat"><b>Deskripsi</b></label>
                    <input type="text" placeholder="Deskripsi" name="des" id="des" ><br>  
                    <button class="searchbtn">Add Product</button>
                </form>
                <br>
            
                <h2 class="ar">List Product</h2>
                <br>
                <div class="table100 ver3 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
                                    <th class="cell100 column1">ID.</th>
									<th class="cell100 column2">Nama</th>
									<th class="cell100 column7">jenis</th>
                                    <th class="cell100 column8">Harga</th>
									<th class="cell100 column9">Deskripsi</th>
								</tr>
							</thead>
						</table>
					</div>

                    <div class="table100-body js-pscroll">
						<table>
							<tbody>
                                <?php
                                    if ($prod !== null) {
                                        $idx=1;
                                        foreach ($prod as $key => $value) {
                                            foreach ($kate as $key => $values) {
                                                if($value['id_jenis']==$values['id_jenis']){
                                                    $namas=$values['jenis'];
                                    ?>
                                        <tr class="row100 body">
                                            <td class="cell100 column1"><?= $value['id_product']?></td>
                                            <td class="cell100 column2"><?= $value['nama']?></td>
                                            <td class="cell100 column7"><?= $namas?></td>
                                            <td class="cell100 column8"><?= $value['harga']?></td>
                                            <td class="cell100 column9"><?= $value['deskripsi']?></td>
                                            
                                        </tr>
                                    <?php
                                    $idx++;
                                        }
                                    }}
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