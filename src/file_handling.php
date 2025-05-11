//Vivian Tran file_handling.php, stores the responses from the user

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $comment = trim($_POST["comment"]);

    if (!empty($comment)) {
        $filename = "comments.txt";
        file_put_contents($filename, $comment . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    
    header("Location: chat_forum.php");
    exit();
}
?>
