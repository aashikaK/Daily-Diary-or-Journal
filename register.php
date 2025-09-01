<?php
require "connect.php";

if(isset($_POST['register'])){
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $email=$_POST['email'];

    $sql="SELECT * FROM users WHERE username=? OR email=?";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$username,$email]);

    if($stmt->rowCount() > 0){
        echo "<script>
                alert('Username or Email already exists!');
                window.location.href='register.html';
              </script>";
        exit;
    }
$sql="INSERT INTO users(username,email,password) VALUES(?,?,?)";
$stmt=$pdo->prepare($sql);
$stmt->execute([$username,$email,$password]);

echo "<script>
alert('Registration successful');
 window.location.href='login.php';
</script>";
}