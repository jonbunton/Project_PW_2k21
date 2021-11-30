<?php
    require_once("connection.php");

    if(isset($_POST["submit"]))
    {
            $name=$_POST["name"];
            $pass=$_POST["password"];
            if($name == "" || $pass == "")
            {
                echo "<script>alert('Masukan semua inputan')</script>";
            }
            else
            {
                // if($name=="admin" && $_POST["password"]=="admin"){
                //     $status=2;
                //     $_SESSION["login"]="admin";
                //     header("Location: admin.php");
                // }
                // else{
                    $status=0;
                    $temp=[];
                    $stmt = $pdo->query("SELECT * FROM user");
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if($users != null){
                        foreach($users as $key =>$value)
                        {
                            if($value["email"]==$name && $value["password"]==$_POST["password"])
                            { 
                                $temp=$value;
                                $status=1;
                                break;
                            }else if($value["email"]==$name)
                            {
                                $status=-1;
                            }
                        }
                    }
                    if($status==1)
                    {
                        $_SESSION["login"]=$temp;
                        header("Location: sushi.php");
                    }
                    else if($status==0){
                        echo "<script>alert('email Belum Didaftarkan')</script>";
                    }else{
                        echo "<script>alert('password tidak cocok  ')</script>";
                    }

                // }
            }
    }
    if(isset( $_SESSION["login"]))
    {
        if($_SESSION["login"]=="admin")header("Location: mUser.php");
        else header("Location: sushi.php");
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
                <a class="ar" href="#top">Home</a>
                <a class="ar" href="sushi.php">Menu</a>
                <a class="ar" href="cart.php">Cart</a>
                <a class="ar" href="#top">About Us</a>
                <div style="display: flex; justify-content: flex-end; flex-grow: 1;">
                    <a class="ar" href="login.php">Login / Register</a>
                </div>
            </div>
        </div>
                
        <div class="login1">
            <div class="log blur">
                <h2>Login</h2><br><br>
                <form action="#" method="post">
                    <label for="email">Email:</label><br>
                    <input type="email" name="name" id="email" placeholder="example@example.com"><br>
                    <label for="pass">Password:</label><br>
                    <input type="password" name="password" id="pass"><br>
                    <p>Don't have account? <a  style="color: rgb(243, 215, 178);" href="regist.php">Register Here</a> </p> 
                    <button type="submit" name="submit">Login</button>
                </form>    
            </div>
        </div>
                
        <div class="foot">
            <p class="copy">Amazake social media</p>
        </div>
    </div>
                    
</body>
</html>