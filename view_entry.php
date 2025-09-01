<?php
session_start();
require "connect.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id'])){
    echo "No entry selected!";
    exit;
}

$entry_id = $_GET['id'];

$sql = "SELECT * FROM entries WHERE id = ? AND user_id = ? LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$entry_id, $user_id]);
$entry = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$entry){
    echo "Entry not found!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($entry['title']); ?> - Diary</title>
    <style>
        body { font-family: Arial; background: #f3f6fa; margin:0; padding:0; }
        .container { width: 60%; margin:auto; padding:20px; }
        h1 { color:#333; text-align:center; }
        .entry { background:#fff; padding:20px; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1);}
        small { color:#888; }
        p { color:#444; white-space:pre-wrap; }
        a { text-decoration:none; color:#4CAF50; }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php">&larr; Back to all entries</a>
        <div class="entry">
            <h1><?= htmlspecialchars($entry['title']); ?></h1>
            <small>
                    <?php 
                            if($entry['entry_date']){
                                echo "Entry Date: " . date("F j, Y", strtotime($entry['entry_date']));
                            } else {
                                    echo "Entry Date: __ , "; // or "Not specified"
                                    } ?>
                            </small>

            <small>Created at: <?= date("F j, Y, g:i a", strtotime($entry['created_at'])); ?></small>
            <p><?= nl2br(htmlspecialchars($entry['content'])); ?></p>
        </div>
    </div>
</body>
</html>
