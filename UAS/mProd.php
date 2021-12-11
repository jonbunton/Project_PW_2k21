<?php
    require_once("connection.php");

    if(isset($_GET["keyword"])){
        
        $stmt = $pdo->prepare("SELECT * FROM product WHERE nama like ?");
        $keyword = "%".$_GET["keyword"]."%";
        $stmt->execute([$keyword]);
        $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->query("SELECT * FROM kategori");
        $kate = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
     }
     else{
        $stmt = $pdo->query("SELECT * FROM product");
        $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $stmt = $pdo->query("SELECT * FROM kategori");
        $kate = $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

    if(isset($_SESSION["message"])){
        echo "<script>alert('$_SESSION[message]')</script>";
        unset($_SESSION["message"]);
    }

    if(isset($_SESSION["message1"])){
        echo "<script>alert('$_SESSION[message1]')</script>";
        unset($_SESSION["message1"]);
    }

    if(isset($_POST['submit']))
{
    $nama = $_POST["Nama"];
    $price = $_POST["hrg"];
    $jenis = $_POST["genre_id"];
    $des = $_POST["des"];
    $file = $_FILES["fileToUpload"];

    $stmt = $pdo->query("SELECT * FROM product");
    $tangka = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $angka=1;
    foreach ($tangka as $key => $valuess) {
        $angka++;
    }
    $angka++;
    
    $result =false;

		$target_dir = "gallery/";
	
	    //$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	    $target_file = $target_dir . $angka.".jpg";
	    
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		  if($check !== false) {
            $_SESSION["message1"] = "File is an image - " . $check["mime"] . ".";
			
			$uploadOk = 1;
		  } else {
            $_SESSION["message1"] = "File is not an image.";
			
			$uploadOk = 0;
		  }
		}

		// Check if file already exists
		if (file_exists($target_file)) {
            $_SESSION["message1"] = "Sorry, file already exists.";
		  
		  $uploadOk = 0;
		}

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
            $_SESSION["message1"] = "Sorry, your file is too large.";
		  
		  $uploadOk = 0;
		}

		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
            $_SESSION["message1"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		  
		  $uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		  
          $_SESSION["message1"] = "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		 if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            if(isset($nama) && $nama!=""){
                $stmt = $pdo->prepare("INSERT INTO product(id_jenis,nama, harga, deskripsi) VALUES(?,?,?,?)");
                $result = $stmt->execute([$jenis, $nama, $price, $des]);
                }
                
                if($result){
                  $_SESSION["message"] = "Berhasil add nih";
                }else{
                $_SESSION["message"] = "Gagal add nih!";
                }
			
		  }
           else {
            $_SESSION["message1"] = "Sorry, there was an error uploading your file.";
			
		  }
		}
        header("Location: mProd.php");
        
}
if(isset($_GET["edit"])){
    $id = $_GET["edit"];
  $stmt = $pdo->query("SELECT * FROM product WHERE id_product='$id'");
  $edi = $stmt->fetch(PDO::FETCH_ASSOC);
}

if(isset($_POST['edit']))
{
    $id = $_GET["edit"];
    $nama = $_POST["Nama"];
    $price = $_POST["hrg"];
    $jenis = $_POST["genre_id"];
    $des = $_POST["des"];
    
    $result =false;
    if(isset($nama) && $nama!=""){
        if(isset($price) && $price!=""){
            if(isset($des) && $des!=""){
                $stmt = $pdo->prepare("UPDATE product SET id_jenis='$jenis', nama='$nama', harga='$price', deskripsi='$des' WHERE id_product = '$id'");
                    $result = $stmt->execute();
                
                if($result){
                $_SESSION["message"] = "Berhasil edit nih";
                }else{
                $_SESSION["message"] = "Gagal edit nih!";
                }
            }   
        }
    }	
		
    header("Location: mProd.php");
        
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

    if (isset($_POST['submit2'])) {
        if($_POST['urut']=="turun"){
            if ($_POST['urut2']=="id") {
                $stmt = $pdo->prepare("SELECT * FROM product ORDER BY id_product DESC");
                $stmt->execute();
                $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="nama") {
                $stmt = $pdo->prepare("SELECT * FROM product ORDER BY id_jenis DESC");
                $stmt->execute();
                $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="jenis") {
                $stmt = $pdo->prepare("SELECT * FROM product ORDER BY nama DESC");
                $stmt->execute();
                $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="hrg") {
                $stmt = $pdo->prepare("SELECT * FROM product ORDER BY harga DESC");
                $stmt->execute();
                $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
        }
        else if($_POST['urut']=="naik"){
            if ($_POST['urut2']=="id") {
                $stmt = $pdo->prepare("SELECT * FROM product ORDER BY id_product ASC");
                $stmt->execute();
                $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="nama") {
                $stmt = $pdo->prepare("SELECT * FROM product ORDER BY id_jenis ASC");
                $stmt->execute();
                $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="jenis") {
                $stmt = $pdo->prepare("SELECT * FROM product ORDER BY nama ASC");
                $stmt->execute();
                $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            elseif ($_POST['urut2']=="hrg") {
                $stmt = $pdo->prepare("SELECT * FROM product ORDER BY harga ASC");
                $stmt->execute();
                $prod = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        
    }
    if(isset($_GET["status"])){
        unset($_SESSION["login"]);
            
        header("Location: index.php");
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

            
    
            <div class="product">
                <h2 class="ar">Add Product</h2>

                <form method="post" enctype="multipart/form-data">
                
                    <label for="nama"><b>Nama</b></label>
                    <input type="text" placeholder="Enter Nama Product" name="Nama" id="Nama" class="search" >

                    <label for="email"><b>Jenis</b></label>
                    <select name="genre_id" id="" class="search">
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
                    <input type="text" placeholder="Enter Harga" name="hrg" id="hrg"class="search" >

                    <label for="psw-repeat"><b>Deskripsi</b></label>
                    <input type="text" placeholder="Deskripsi" name="des" id="des" class="search" ><br>

                    Select image to upload:
                    <input type="file" name="fileToUpload" id="fileToUpload"><br>
                    <input type="submit" value="Add Product" name="submit" class="searchbtn">
                </form>

                <br>
            
                <form action="#" method="get">
                    <h2 class="ar">Search Product</h2> 
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
                        <option value="nama">Nama</option>
                        <option value="jenis">Jenis</option>
                        <option value="hrg">Harga</option>
                    </select>
                    <br>
                    <input type="submit" name="submit2" vlaue="Sort Product" class="searchbtn">
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
                                    <th class="cell100 column10">Edit</th>
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
                                            <td class="cell100 column10 detailbtn">
                                            <form action="#" method="get">
                                                <input type="hidden" name="edit" value="<?= $value['id_product']?>">
                                                <button onclick="myFunction()">Edit</button>
                                            </form>
                                            </td>

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


            <!-- Untuk pop up box edit -->
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h1>Edit Product <?php echo $_GET["edit"] ?></h1>
                    <form method="post" enctype="multipart/form-data">
                
                    <label for="nama"><b>Nama</b></label>
                    <input type="text" placeholder="Enter Nama Product" name="Nama" id="Nama" value="<?=$edi['nama']?>">

                    <label for="email"><b>Jenis</b></label>
                    <select name="genre_id" id="">
                    <?php
                            if ($kate !== null) {
                                foreach ($kate as $key => $values) {
                                    if($values['id_jenis']==$edi['id_jenis']){
                                        ?>
                                        <option value="<?= $values['id_jenis']?>" selected><?= $values['jenis']?></option> 
                                        <?php               
                                    }else{
                                        ?>
                                        <option value="<?= $values['id_jenis']?>"><?= $values['jenis']?></option>
                                        <?php
                                    }
                            ?>
                        
                    <?php
                                    }
                                }
                        ?>
                    </select>

                    <label for="psw"><b>Harga (Dalam Rupiah)</b></label>
                    <input type="text" placeholder="Enter Harga" name="hrg" id="hrg" value="<?=$edi['harga']?>" >

                    <label for="psw-repeat"><b>Deskripsi</b></label>
                    <input type="text" placeholder="Deskripsi" name="des" id="des" value="<?=$edi['deskripsi']?>" ><br>

                    <input type="submit" value="Edit Product" name="edit" class="searchbtn">
                </form>
                </div>
            </div>

        </div>

        <script>
            window.onload = function() {
                let params = new URLSearchParams(location.search);
                if(params.has('edit')== true){
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