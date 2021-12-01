<?php
    require_once("connection.php");
    if(isset($_POST["topup"])){
        $username= $_SESSION["login"]["email"];
        $tot=$_POST["jum"];
        $stmt = $pdo->prepare("INSERT INTO pending(jumlah,email) values(?,?)");
        $stmt->execute([$tot,$username]);
        header("Location:Menu.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Masukan jumlah topup <br>
    <form action="" method="post">
        <input type="number" name="jum" id="" min="0">
        <br>
        <button name="topup">Top Up</button>
    </form>
</body>
</html>