<?php
session_start();
require "connect.php";

if(!isset($_SESSION['user_id'])){
    header("Location:login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
$username=$_SESSION['username'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
     $entry_date = !empty($_POST['entry_date']) ? $_POST['entry_date'] : NULL;
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO entries (user_id, title, content, entry_date, created_at) 
        VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $title, $content, $entry_date]);
        header("Location: index.php"); 
        exit;
    }
}

// fetch old entries
$sql = "SELECT * FROM entries WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Diary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f6fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            background: #aec5dfff;
            padding: 20px;
            padding-left:20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }
        button:hover {
            background: #45a049;
        }
        .entry {
            background: #fff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }
        .entry h2 {
            margin: 0;
            color: #2c3e50;
        }
        .entry small {
            color: #888;
        }
        .entry p {
            margin-top: 10px;
            color: #444;
        }
    </style>
</head>
<body> <p style="margin-left:900px; font-size:19px;"> <?php echo $username ;?>, Click on the Logout button to logout:  
    <a href="login.php" style="background-color:red;color:white;text-decoration:none;padding:10px; 
     margin-top:10px; font-size:15px; border-radius:25px;">Logout</a></p>
     
    <div class="container">
        <h1>Welcome to Your Diary</h1>
        
        <form method="POST">
            <input type="text" name="title" placeholder="Entry Title" required>
            <input type="date" name="entry_date">
            <textarea name="content" rows="20" placeholder="Write your thoughts..." required></textarea>
            <button type="submit">Save Entry</button>
        </form>

        <h2>Previous Entries</h2>
        <?php if ($entries): ?>
            <?php foreach ($entries as $entry): ?>
                <div class="entry">

                   <h2>
                    <a href="view_entry.php?id=<?= $entry['id']; ?>" style="text-decoration:none; color:#2c3e50;">
                    <?= htmlspecialchars($entry['title']); ?>
                    </a>
                    </h2>
                    <small>
                    <?php 
                            if($entry['entry_date']){
                                echo "Entry Date: " . date("F j, Y", strtotime($entry['entry_date']));
                            } else {
                                    echo "Entry Date: __ , "; // or "Not specified"
                                    } ?>
                            </small>

                    <small><?= date("F j, Y, g:i a", strtotime($entry['created_at'])); ?></small>
                    <p><?= nl2br(htmlspecialchars(substr($entry['content'], 0, 150))) ?>...</p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No entries yet. Start writing!</p>
        <?php endif; ?>
    </div>
</body>
</html>