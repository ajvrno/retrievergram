<?php
    $email = $_POST['email'] ?? '';
    $password = $_POST['pass'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $username = $_POST['user'] ?? '';
?>

<!--Ashley Rabino-->
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

        <form id="form" action="confirmation.php" method="POST">
            <!-- Hidden inputs to keep login info -->
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <input type="hidden" name="pass" value="<?php echo htmlspecialchars($password); ?>">
            <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            <input type="hidden" name="user" value="<?php echo htmlspecialchars($username); ?>">

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