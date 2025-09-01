<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form</title>
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

<h1>Login Form</h1>
<div class="container">
    <form action="" method="post">

        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Email">

        <label for="pw">Password:</label>
        <input type="password" name="password" id="pw" placeholder="Password">


        <button type="submit" name="login">Login</button>
    </form>
    <!-- for password reset -->
        <p style="font-size:13px; color:rgb(22, 1, 117); padding-top:40px;">Forgot Password ? Click the button below to reset password. </p>

     <a href="resetPw.php" style="width: 95%;
    margin: 15px auto 0 auto;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    font-weight:bold;
    border: none;
    border-radius: 5px;
    cursor: pointer; text-decoration:none">Reset Password</a>
    

</div>
</body>
</html>

<?php
require "connect.php";
session_start();

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=md5($_POST['password']);

    $sql="SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([$email]);
    $user= $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && $user['password']===$password){
        $_SESSION['user_id']=$user['id'];
        $_SESSION['username']=$user['username'];

        echo "<script> 
        alert(`Login successful.Welcome!, {$user['username']} `);
        window.location.href= 'index.php';
        </script> " ;
    }
    else {
        echo "<script>
                alert('Invalid email or password!');
                window.location.href='login.php';
              </script>";
    }
    
}