<?php
    // Ashley Rabino - Sign Up Page

    session_start();

    $db = mysqli_connect("studentdb-maria.gl.umbc.edu", "aroka1", "aroka1", "aroka1");

    if (mysqli_connect_errno()) {
        exit("Error - could not connect to MySQL: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // Check if username or email already exists
        $stmt = mysqli_prepare($db, "SELECT user_id FROM USERS WHERE username = ? OR email = ?");
        mysqli_stmt_bind_param($stmt, "ss", $user, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $message = "Error: Username or email already exists.";
        } else {
            // Insert new user into the database using prepared statement
            $insert_stmt = mysqli_prepare($db, "INSERT INTO USERS (username, email, phone, password) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert_stmt, "ssss", $user, $email, $phone, $hashed_password);

            if (mysqli_stmt_execute($insert_stmt)) {

                $new_user_id = mysqli_insert_id($db);

                // Stores user ID in session for profile creation
                $_SESSION['user_id'] = $new_user_id;

                // Redirect to the create_profile.php
                header("Location: create_profile.php");
                exit();
            } else {
                $message = "Error: " . mysqli_error($db);
            }
            mysqli_stmt_close($insert_stmt);
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RetrieverGram</title>
    <link rel="stylesheet" href="create_profile.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,600;1,600&family=Quicksand:wght@300..700&display=swap');
    </style>
</head>

<body>
    <!--Sign Up Form -->
	<div class="register">
	    <h1>Sign Up</h1>

		<form id="form" action="sign_up.php" method="post">
			<label for="email">School Email</label><br>
            <input type="email" name="email" required></label><br>
			<label for="phone">Phone Number</label><br>
            <input type="tel" name="phone" required></label><br>
			<label for="user">Username</label><br>
            <input type="text" name="user" required><br>
            <label for="pass">Password</label><br>
            <input type="password" name="pass" required><br>
			
            <button type="submit">Sign Up</button>
        </form>
	</div>
</body>
</html>
