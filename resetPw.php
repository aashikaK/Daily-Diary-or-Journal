<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password Reset</title>
<style>
body { 
    background-color: #b8d6f5; 
    margin: 0; 
    font-family: sans-serif; 
}
h1 {
     text-align: center;
      margin-top: 100px; 
      color: #333; 
    }
.container {
    background-color: #d3e8f1;
    width: 300px;
    padding: 30px;
    margin: 50px auto;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
label { 
    font-weight:bold;
 }
form input {
    display: block;
    width: 90%;
    margin: 10px auto;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
form button {
    display: block;
    width: 95%;
    margin: 15px auto 0 auto;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    font-weight:bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
form button:hover { 
    background-color: #45a049;
     }
</style>
</head>
<body>

<h1>Reset Password</h1>
<div class="container">
    <form action="" method="post">
 <p style="font-size:13px; color:rgb(22, 1, 117); padding-top:40px;">Enter you Username and Email to reset your password. </p>

    
        <label for="un">Username:</label>
        <input type="text" name="username" id="un" placeholder="Username">
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Email">

         <label for="pw">New Password:</label>
        <input type="password" name="newpassword" id="pw" placeholder="New Password">

        <button type="submit" name="reset">Reset Password</button>
    </form>

</div>
</body>
</html>

<?php
require "connect.php";
if(isset($_POST['reset'])){
$username=$_POST['username'];
$email=$_POST['email'];
$newPw=md5($_POST['newpassword']);

$sql="select * from users where username=? and email=?";
$stmt=$pdo->prepare($sql);
$stmt->execute([$username,$email]);
$result=$stmt->fetch(PDO::FETCH_ASSOC);

if($result){
    $update="update users set password=? where username=? and email=?";
    $ustmt=$pdo->prepare($update);
    $ustmt->execute([$newPw,$username,$email]);

    echo "<script>
    alert('Password changed successfully');
    window.location.href='login.php';
    </script>";
}
else{
    echo "<script>
    alert('No matching user found');
    </script>";
}
}