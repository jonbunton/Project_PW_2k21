<?php
    require_once("connection.php");

    $stmt = $pdo->query("SELECT * FROM product");
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_SESSION["login"]))
    {
        $user_login=$_SESSION["login"];
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$user_login["email"]]);
        $user =$stmt->fetch(PDO::FETCH_ASSOC);
        //$saldo=$user["saldo"];
    }
    // echo "<pre>";
    // var_dump($_SESSION["cart"]);
    // echo "</pre>";
    
   

    if(isset($_SESSION["cart"])){
        //ini untuk add jumlah product otomatis
        require_once("refreshcart.php");  
        $carts=$_SESSION["cart"]; 
    }
    else{
        $carts=[];
    }
    if(isset($_SESSION["login"]))
    {
        $user=$_SESSION["login"];
        $balance=$user["saldo"];
    }else{
        $user=[];
        $balance=0;
    }
    if(isset($_POST['logout']))
    {
        unset($_SESSION["login"]);
        unset($_SESSION["cart"]);
        header("location:login.php");
    } 

    if(isset($_SESSION["cart"]))
    {
        $size=sizeof($_SESSION["cart"]);
        $subtot=0;
        $subjum=0;
        for($i=0;$i<$size;$i++){ 
            $sum=0;

            $price =$_SESSION["cart"][$i][0]["harga"]; 
            $jum =  $_SESSION["cart"][$i][1]; 
            $sum=$price*$jum;
            $subjum+=$jum;
            $subtot+=$sum;
        }

    }
    if(isset($_SESSION["message"])){
        echo "<script>alert('$_SESSION[message]')</script>";
        unset($_SESSION["message"]);
    }
    if(isset($_POST["order"]))
    { 
            $balance=$user["saldo"];
            $subtot+=15000;
            if($subtot<$balance)
            { 
                if($subtot>15000)
                {
                    $carts = $_SESSION['cart'];
                    $email = $user["email"];
                    try{
                        $pdo->beginTransaction();  
                        $stmt = $pdo->prepare("INSERT INTO htrans(email,total) values(?,?)");
                        $result = $stmt->execute([$email,$subtot]);
                        $h_trans_id = $pdo->lastInsertId();
                        foreach ($carts as $key => $value) {
                          $ongkir=15000;
                          $nama=$carts[$key][0]["nama"];
                          $harga=$carts[$key][0]["harga"];
                          $jum=$carts[$key][1];
                          $subtot2=($harga*$jum); 
                          $id_product=$value[0]["id_product"];
                          $stmt = $pdo->prepare("INSERT INTO dtrans(id_htrans,id_product, nama_product,jumlah,subtotal,harga) values(?,?,?,?,?,?)");
                          $result = $stmt->execute([$h_trans_id,$id_product ,$nama,$jum,$subtot2,$harga ]);
                        }
                        $balance-=$subtot;
                        $stmt = $pdo->prepare("UPDATE user SET saldo=:saldo WHERE email = :id");
                        $stmt->bindParam(":saldo", $balance); 
                        $stmt->bindParam(":id", $email);
                        $result = $stmt->execute();

                        unset($_SESSION["cart"]);
                        $pdo->commit();
                    }catch(PDOException $e){
                      $pdo->rollBack();
                      throw $e;
                    } 
                    $_SESSION["message"]="Berhasil beli ".$subjum." produk ,seharga IDR".$subtot;
                    $id2=$user["email"];
                    $stmt = $pdo->query("SELECT * FROM user WHERE email='$id2'");
                    $edi2 = $stmt->fetch(PDO::FETCH_ASSOC);
                    unset($_SESSION["login"]);
                    $_SESSION["login"]=$edi2; 

                }
                else{
                    $_SESSION["message"]="Anda Belum memilih item";
                    echo "<script>alert('$_SESSION[message]')</script>";
                }
            }
            else{
                $_SESSION["message"]="saldo tidak cukup";
            }
            header("Location: cart.php");
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="mycss.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />

</head>
<body>
    <div class="container">

        <div class="header" id="top">    
            <div class="nav">
                <img class="logo" src="gallery/logo.png" alt="">
                <a class="ar" href="#top">Home</a>
                <a class="ar" href="#top">About Us</a>
                <a class="ar" href="#top">Location</a>
                <a class="ar" href="menu.php">Menu</a>
                <a class="ar" href="cart.php">Cart</a>
                <?php
                    if($user!=null){
                ?>
                    <div style="display: flex; justify-content: flex-end; flex-grow: 1;">
                        <a class="ar" href="profile.php">ようこそ, <?= $user["nama"]?></a>
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
                
        <div class="cartbg bgcart">
            <!-- cart -->
            <center>
                <div class="cart blur2">
                <!--detail cart -->
                    <div class="cleft">
                        <div  class="textCart"><h1>Shopping Cart</h1></div>
                        <div class="tabCart">
                            <table>
                                <thead>
                                    <th colspan = "2">PRODUCT DETAILS</th>
                                    <th>QUANTITY</th>
                                    <th>PRICE</th>
                                    <th>TOTAL</th>
                                </thead>
                                <tbody>
                                <?php
                                    if($carts!=null)
                                    {
                                        $ctr=0;
                                        foreach($carts as $key => $values)
                                        {
                                ?>
                                        <tr id="<?= $ctr?>">
                                            <td><div class="gmbr_cart"><img class="gmbr_cart" src="gallery/<?=$values[0]["id_product"]+1?>.jpg" alt=""></div></td>
                                            <td><?=$values[0]["nama"]?> <br> <?=$values[0]["deskripsi"]?></td>
                                            <td>
                                                <div style="display: flex; flex-direction: row; justify-content:flex-start;" class="value">
                                                    <!-- <form style="width: 20px; height: 20px; margin-right:20px;" action="Control.php" method="post">
                                                        <input type="hidden" name="action" value="minorder">
                                                        <input type="hidden" name="key" value="<?=$key?>">
                                                        <button class="buttoncart" name="btn_cart_minus">-</button>
                                                    </form> -->
                                                    <form style="width: 20px; height: 20px; margin-right:20px;" action="" method="post" class="minus">
                                                         <button class="buttoncart btn_cart_minus" name="btn_cart_minus" value="<?=$key?>">-</button>
                                                    </form>  
                                                        <p class="val <?= $ctr?>" style="width: 30px; height: 20px; text-align: center;"><?=$values[1]?></p>
                                                    <!-- <form style="width: 20px; height: 20px; margin-left:20px;" action="Control.php" method="post">
                                                        <input type="hidden" name="action" value="plusorder">
                                                        <input type="hidden" name="key" value="<?=$key?>">
                                                        <button class="buttoncart" name="btn_cart_plus">+</button>
                                                    </form> -->
                                                    <form style="width: 20px; height: 20px; margin-left:20px;" action="" method="post">
                                                        <!-- <input type="hidden" name="key" value="<?=$key?>"> -->
                                                        <button class="buttoncart btn_cart_plus" ctr="<?= $ctr?>" name="btn_cart_plus" value="<?=$key?>">+</button>
                                                    </form>
                                                    
                                                </div>
                                          
                                            </td>
                                            <td> 
                                                <input type="hidden" class="hargahidden<?= $ctr?>" ctrharga="<?= $ctr?>" name="id" value=<?=$values[0]["harga"]?>>
                                                <p class="harganew<?= $ctr?>"> IDR <span><?=$values[0]["harga"]?></span></p>
                                            </td>
                                            <td>
                                                <input type="hidden" class="totalhidden<?= $ctr?>" ctrharga="<?= $ctr?>" name="id" value=<?=$values[0]["harga"]*$values[1]?>>
                                                IDR<p class="totalnew<?= $ctr?>"> <span><?=$values[0]["harga"]*$values[1]?></span> </p>
                                        
                                            </td>
                                            <input type="hidden" name="id" value=<?=$values[0]["id_product"]?>>
                                        </tr>
                                        <?php
                                            $ctr++;
                                        }
                                    }else{
                                ?>
                                <tr id="<?= $ctr?>">
                                            <td colspan="5">Your Cart is Empty</td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                            <!-- summary -->
                    <div class="cright blur2">
                        <div  class="textCart4">ORDER SUMMARY</div>
                        <hr>
                        <div  class="textCart3">
                            <div class="t1">
                            <!-- <?php if(isset($subjum)) echo $subjum;
                            else echo "0"?> -->

                            <?php if(isset($subjum)){
                            ?>
                                <input type="hidden" class="total" name="" value="<?=$subjum?>">
                                <p class="subjumlah" ><?=$subjum?></p>
                            <?php 
                                }
                                else{
                            ?>
                                <p class="subjumlah">0
                            <?php }
                            
                            ?>
                            </div>
                            <div class="t2">
                                Items
                            </div>
                            <div class="t3"> 
                                <div>
                                IDR &nbsp;
                                </div>
                                <?php if(isset($subtot)){
                                ?>
                                    <input type="hidden" class="total2" name="" value="<?=$subtot?>">
                                    <p class="subtotal" >  <?=$subtot?></p>
                                <?php 
                                    }
                                    else{
                                ?>
                                    <p class="subtotal">  0</p>
                                <?php }

                                ?>
                            </div>
                        </div>
                        <div  class="textCart3">
                            <div class="t1">
                                Shipping Cost
                            </div>
                            <div class="t3">
                                IDR&nbsp;&nbsp;&nbsp; 15000
                            </div>
                        </div>
                        <hr>
                        <div  class="textCart3"> 
                            <div class="t1">
                                Grand Total
                            </div>
                            <div class="t3">
                                IDR&nbsp;
                                <?php if(isset($subtot)){
                                        $subtot+=15000;
                                ?>
                                    <input type="hidden" class="total3" name="" value="<?=$subtot?>">
                                    <p class="grandtotal" >  <?=$subtot?></p>
                                <?php 
                                    }
                                    else{
                                ?> 
                                    <p class="grandtotal">IDR 0</p>
                                <?php }

                                ?>
                            </div>
                        </div>
                        <div class="textC4">
                            Your Balance is IDR <?=$balance?>
                        </div>
                        <form action="" method="post">
                            <button class="buttonco" name="order">Check Out</button>
                        </form>       
                    </div>
                </div>
            </center>
                            <!-- DETAIL CART  -->
        </div>
        <div id="container">

        </div>
        <div class="foot">
            <p class="copy">Copyright 2021 © Amazake</p>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
		 
        // $(".minus").on("click","form",function(e){
        //     e.preventDefault();
        // }); 

		$(".btn_cart_minus").click(function(a){   
            a.preventDefault(); 
            var postForm = $(this).val();  
            var total= $(".total").val();
            $.ajax({
                method:"post",
                url:"ajax_cart_minus.php",
                data: {idxproduct: postForm},
                success: function(data){
                    var temp = data;
                    var stat=1;
                    if(temp>0){
                        $("."+postForm).text(temp);
                    }else{
                        stat=0;
                        
                    }
                    var harga= $(".hargahidden"+postForm).val();  
                    var tot=Number(harga)*Number(temp);
                    //total
                    $(".totalnew"+postForm).text(+tot);
                    $(".totalhidden"+postForm).val(tot); 

                    //ORDER SUMMARY
                    //subtotal= total items di order summary
                    var subjum= Number(total)-1; 
                    $(".total").val(subjum);
                    $(".subjumlah").text(subjum+""); 
                    
                    var tempsubtot= $(".total2").val();
                    var subtot=Number(tempsubtot)-Number(harga);
                    $(".total2").val(subtot);
                    $(".subtotal").text(subtot); 

                    //grand total
                    var tempgrandtot= $(".total3").val();
                    var grandtot=Number(tempgrandtot)-Number(harga);
                    $(".total3").val(grandtot);
                    $(".grandtotal").text(grandtot);
                    if(stat==0)
                    {
                        $("#"+postForm).html("");
                    }

                    
                }
            });   
		});     

        $(".btn_cart_plus").click(function(a){
            a.preventDefault(); 
            var postForm = $(this).val();  
            var total= $(".total").val();
            
            $.ajax({
                method:"post",
                url:"ajax_cart_plus.php",
                data: {idxproduct: postForm},
                success: function(data){
                    //CART

                    //qty
                    //temp=quantity
                    var temp = data;
                    $("."+postForm).text(temp); 
                    var harga= $(".hargahidden"+postForm).val();  
                    var tot=Number(harga)*Number(temp);
                    //total
                    $(".totalnew"+postForm).text(tot);
                    $(".totalhidden"+postForm).val(tot); 

                    //ORDER SUMMARY
                    //subtotal= total items di order summary
                    var subjum= Number(total)+1; 
                    $(".total").val(subjum);
                    $(".subjumlah").text(subjum+""); 
                    
                    var tempsubtot= $(".total2").val();
                    var subtot=Number(tempsubtot)+Number(harga);
                    $(".total2").val(subtot);
                    $(".subtotal").text(subtot); 

                    //grand total
                    var tempgrandtot= $(".total3").val();
                    var grandtot=Number(tempgrandtot)+Number(harga);
                    $(".total3").val(grandtot);
                    $(".grandtotal").text(grandtot);
                }
            });
        }); 
		
	});
	</script> 
</body>
</html>