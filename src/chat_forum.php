<!--Author: Vivian Tran-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat Forum</title>
    <link rel="stylesheet" href="forum.css">
</head>
<body>
    <header>
        <h1>Chat Forum</h1>
        <nav>
            <ul class="navbar">
                <li><a href="MainFeed.html">Home</a></li>
                <li><a href="profile.html">Profile</a></li>
                <li><a href="messages.html">Messages</a></li>
            </ul>
        </nav>
    </header>


    <main>
        <section class="intro">
            <p>Welcome to the Forum! This page allows you to answer a Question of the Day. Refresh the page for a new one!</p>
            <img src="img/banner.png" alt="banner" width="100%">
        </section>


        <section class="qotd">
            <h2>QOTD:</h2>
            <p class="question">
                <?php
                $questions = [
                    "What made you smile today?",
                    "What is your favorite hobby?",
                    "What's a new skill you'd like to learn?",
                    "What was your favorite part of the week?",
                    "If you could travel anywhere right now, where would you go?",
                    "If you had a wish right now, what would you wish for?"
                ];
                $randomIndex = array_rand($questions);
                echo $questions[$randomIndex];
                ?>
            </p>
        </section>


        <section class="response-form">
            <h2>Your Answer:</h2>
            <form action="file_handling.php" method="POST">
                <textarea name="answer" rows="5" placeholder="Write your answer here..." required></textarea><br>
                <input type="submit" value="Post Answer">
            </form>
        </section>


        <section class="comment-form">
            <h2>Leave a Comment</h2>
            <form action="php/file_handling.php" method="POST">
                <textarea name="comments" rows="5" placeholder="Leave your thoughts..." required></textarea><br>
                <input type="submit" value="Post Comment">
            </form>
        </section>


        <section class="comments-section">
    <h2>Previous Comments</h2>
    <div class="comments">
 
 
 
 <?php
       
	$filename = "comments.txt";
	
	if (file_exists($filename)) {
	
		$comments = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		
		foreach ($comments as $comment) {
		
			echo "<p>" . htmlspecialchars($comment) . "</p>";
		}
	} else {
	
		echo "<p>No comments yet. Be the first!</p>";
		
	}
?>


    </div>
</section>


    </main>


    <footer>
        <p>� 2025 RetrieverGram. All rights reserved.</p>
    </footer>
</body>
</html>
