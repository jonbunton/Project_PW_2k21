<?php
    require_once("connection.php");

    if(isset($_POST['logout']))
    {
        unset($_SESSION["login"]);
        unset($_SESSION["cart"]);
        header("location:login.php");
    } 
    if(isset($_POST["submit"]))
    {
        if(isset($_POST['name']) &&isset($_POST['email']) && isset($_POST['pass'])&& isset($_POST['cpass'])  && isset($_POST['alamat']) && isset($_POST['kota']) )
        {
            $name=$_POST['name'];
            $email=$_POST['email'];
            $pass=$_POST['pass'];
            $cpass=$_POST['cpass'];
            $alamat=$_POST['alamat'];
            $kota=$_POST['kota']; 
            $status=1;
            // var_dump($_SESSION['list_user']);
           if($name!=""&& $email!=""&&$pass!=""&&$cpass!=""&&$alamat!=""&&$kota!=""){
            if( $_POST['email']!="admin@gmail.com" ) 
            {
                 if($_POST["pass"] != $_POST["cpass"])
                 {
                     echo "<script>alert('Password Tidak Sama')</script>";
                 }
                 else{ 
                     $status=true;
                     $stmt = $pdo->query("SELECT * FROM user");
                     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                     if($users != null){
                         foreach($users as $key =>$value)
                         { 
                             if($value["email"]==$email)
                             {
                                 echo "<script>alert('Email Sudah Ada ')</script>";
                                 $status=false;
                                 break;
                             }
                         }
                     }
                     if($status==true)
                     {
                         $stmt = $pdo->prepare("INSERT INTO user(email,password, nama,saldo,alamat,kota) VALUES(?,?,?,?,?,?)");
                         $result = $stmt->execute([
                           $email, $pass,$name,0,$alamat,$kota
                         ]);
                         header("Location:login.php");
                     }
                 }  
            }
            else{
                echo "<script>alert(' email tidak boleh admin@gmail.com !')</script>";
               }

           }
           else{
            echo "<script>alert('Semua input harus diisi !')</script>";
            } 
        }
        else{
            echo "<script>alert('Semua input harus diisi !')</script>";
        } 
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
                                <div style="display: flex; justify-content: flex-end; flex-grow: 1;"></div>
                                    <a class="ar" href="login.php">Login/Register</a>
                                </div>
                             </div>
                
                             <div class="login1">
                                <div class="log blur">
                                    <h2>Registration</h2><br><br>
                                    <form method="post">
                                        <label for="nm">Nama :</label>
                                        <input type="text" id="nm" name="name"><br>
                                        <label for="email">Email :</label>
                                        <input type="email" id="email" placeholder="example@example.com" name="email"><br>
                                        <label for="pass">Set your password :</label>
                                        <input type="password" id="pass" name="pass"><br>
                                        <label for="pass1">Confrim password :</label>
                                        <input type="password" id="pass1" name="cpass"><br> 
                                        <label for="alm">Alamat :</label>
                                        <input type="text" id="alm"name="alamat"><br>
                                        <label for="kt">Kota :</label>
                                        <input type="text" id="kt" name="kota"><br> 
                                      
                    
                                        <p>Already have an account? <a style="color: rgb(243, 215, 178);" href="login.php">Login Here</a> </p> 
                                        <button type="submit" name="submit">Register</button>
                                    </form>      
                                    
                                   
                                </div>
                            </div>
                            
                
                             <div class="foot">
                                <p class="copy">Copyright 2021 © Amazakea</p>
                            </div>
                    </div>
                    </div>
</body>
</html>