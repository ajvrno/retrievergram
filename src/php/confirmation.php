<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $username = $_POST['username'] ?? '';
        $firstname = $_POST['fname'] ?? '';
        $lastname = $_POST['lname'] ?? '';    
        $year = $_POST['year'] ?? '';
        $major = $_POST['major'] ?? '';
        $pronouns = $_POST['pronouns'] ?? '';

        // Hash password for safety
        $password = password_hash($password, PASSWORD_DEFAULT);

        // CSV-style data line
        $line = "$email,$password,$phone,$username,$firstname,$lastname,$year,$major,$pronouns\n";

        // Append to file
        $file = fopen("users.txt", "a");
        fwrite($file, $line);
        fclose($file);
?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>You're signed in!</title>
            <link rel="stylesheet" href="create_profile.css">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,600;1,600&family=Quicksand:wght@300..700&display=swap');
            </style>
        </head>

        <body>
            <div class="register">
                <h1>Thanks for signing up!</h1>
                <p>Click below to go home.</p>
                <form id="form3" action="/src/main.html" method="get">
                    <button type="submit">Home</button>
                </form>    
            </div>

        </body>
        </html>

<?php
    } else {
        echo "Invalid request.";
    }
?>