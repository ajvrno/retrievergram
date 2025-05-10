<?php
    // Ashley Rabino - Create Profile Page
    session_start();

    // Check if the user is logged in or has just signed up
    if (!isset($_SESSION['user_id'])) {

        header("Location: signup.php");
        exit();
    }

    $db = mysqli_connect("studentdb-maria.gl.umbc.edu", "aroka1", "aroka1", "aroka1");

    if (mysqli_connect_errno()) {
        exit("Error - could not connect to MySQL: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['fname'];
        $last_name = $_POST['lname'];
        $major = $_POST['major'];
        $grad_date = $_POST['grad'];
        $pronouns = $_POST['pronouns'];

        // Get the user ID from the session
        $user_id = $_SESSION['user_id'];

        // Update the USERS table with profile information using prepared statement
        // Assuming your USERS table has columns: fname, lname, major, grad, pronouns
        $update_query = "UPDATE USERS SET fname = ?, lname = ?, major = ?, grad = ?, pronouns = ? WHERE user_id = ?";
        $update_query_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_query_stmt, "sssssi", $first_name, $last_name, $major, $grad_date, $pronouns, $user_id);

        if (mysqli_stmt_execute($update_query_stmt)) {
            $message = "Profile created successfully!";

            header("Location: MainFeed.html");
            exit();
            
        } else {
            $message = "Error updating profile: " . mysqli_error($conn);
        }
        mysqli_stmt_close($update_query_stmt);
    }

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="create_profile.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,600;1,600&family=Quicksand:wght@300..700&display=swap');
    </style>
</head>

<body>
    <!--Create Profile-->
    <div class="create">
        <h1>Create Profile</h1>

        <form id="form" action="src/create_profile.php" method="post">

            <label for="fname">First Name</label><br>
            <input type="text" name="fname" required><br>
            <label for="lname">Last Name</label><br>
            <input type="text" name="lname" required><br>
            <label for="major">Major</label><br>
            <input type="text" name="major" required><br>
            <label for="grad">Graduation Date</label><br>
            <input type="month" name="grad" required><br>

            <!--Multiselect-->
            <label id="pronouns" for="pronouns">Pronouns</label><br>
                <select name="pronouns" required>
                    <option value="sh">She/her</option>
                    <option value="hh">He/him</option>
                    <option value="tt">They/them</option>
                </select><br>

            <button type="submit">Create Profile</button>
        </form>    
    </div>
</body>
</html>
