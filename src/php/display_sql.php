<?php
$db = mysqli_connect("studentdb-maria.gl.umbc.edu", "aroka1", "aroka1", "aroka1");

if (mysqli_connect_errno()) {
    exit("Error - could not connect to MySQL: " . mysqli_connect_error());
}

$tables = ['USERS', 'posts', 'comments', 'likes', 'friendships', 'messages'];

foreach ($tables as $table) {
    echo "<h2>Contents of $table</h2>";
    $query = "SELECT * FROM $table";
    $result = mysqli_query($db, $query);

    if (!$result) {
        echo "Error displaying $table: " . mysqli_error($db) . "<br>";
        continue;
    }

    if (mysqli_num_rows($result) == 0) {
        echo "No records found in $table.<br>";
        continue;
    }

    echo "<table border='1' cellpadding='5'><tr>";
    // Table headers
    while ($fieldinfo = mysqli_fetch_field($result)) {
        echo "<th>" . htmlspecialchars($fieldinfo->name) . "</th>";
    }
    echo "</tr>";

    // Table rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
    }

    echo "</table><br><hr>";
}

mysqli_close($db);
?>
