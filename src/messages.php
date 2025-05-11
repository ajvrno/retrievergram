<?php
// Mareisha Banga
// direct messaging w/ friendships

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit();
}

$db = mysqli_connect("studentdb-maria.gl.umbc.edu", "aroka1", "aroka1", "aroka1");
if (mysqli_connect_errno()) {
    exit("Connection error: " . mysqli_connect_error());
}

$current_user_id = $_SESSION['user_id'];
$current_username = $_SESSION['username'];

// this handles sending a message
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['receiver_id'], $_POST['message'])) {
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    $stmt = mysqli_prepare($db, "INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iis", $current_user_id, $receiver_id, $message);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// this gets all accepted friendships or friends only
$friends = [];
$friend_query = "
    SELECT u.user_id, u.username
    FROM USERS u
    JOIN friendships f ON (
        (f.user_id_1 = ? AND f.user_id_2 = u.user_id)
        OR
        (f.user_id_2 = ? AND f.user_id_1 = u.user_id)
    )
    WHERE f.status = 'accepted'
";
$stmt = mysqli_prepare($db, $friend_query);
mysqli_stmt_bind_param($stmt, "ii", $current_user_id, $current_user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $friend_id, $friend_username);
while (mysqli_stmt_fetch($stmt)) {
    $friends[] = ['id' => $friend_id, 'username' => $friend_username];
}
mysqli_stmt_close($stmt);

// this basically loads messages with selected friend
$selected_id = $_GET['chat'] ?? null;
$messages = [];
if ($selected_id) {
    $msg_stmt = mysqli_prepare($db, "SELECT sender_id, message_text FROM messages 
        WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
        ORDER BY sent_at ASC");
    mysqli_stmt_bind_param($msg_stmt, "iiii", $current_user_id, $selected_id, $selected_id, $current_user_id);
    mysqli_stmt_execute($msg_stmt);
    mysqli_stmt_bind_result($msg_stmt, $sender_id, $msg_text);
    while (mysqli_stmt_fetch($msg_stmt)) {
        $messages[] = ['sender' => $sender_id, 'text' => $msg_text];
    }
    mysqli_stmt_close($msg_stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Messages</title>
  <link rel="stylesheet" href="messages.css">
</head>
<body>
<div class="main-container">
  <div class="nav-bar">
    <div></div>
    <div class="plus-btn" onclick="startNewChat()">+</div>
  </div>

  <div class="threads-list">
    <?php foreach ($friends as $friend): ?>
      <div class="thread">
        <a href="messages.php?chat=<?= $friend['id'] ?>">
          <?= htmlspecialchars($friend['username']) ?>
        </a>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="chat-window">
    <?php if (!$selected_id): ?>
      <div class="chat-header">Messages</div>
      <div class="chat-empty">Click + to start a new chat.</div>
    <?php else: ?>
      <?php
        $selected_user = array_filter($friends, fn($f) => $f['id'] == $selected_id);
        $display_name = $selected_user ? $selected_user[array_key_first($selected_user)]['username'] : 'Unknown';
      ?>
      <div class="chat-header">@<?= htmlspecialchars($display_name) ?></div>
      <div class="messages">
        <?php foreach ($messages as $msg): ?>
          <div class="message <?= $msg['sender'] == $current_user_id ? 'you' : '' ?>">
            <?= htmlspecialchars($msg['text']) ?>
          </div>
        <?php endforeach; ?>
      </div>
      <form class="message-input-area" method="POST" action="messages.php?chat=<?= $selected_id ?>">
        <input type="hidden" name="receiver_id" value="<?= $selected_id ?>">
        <input type="text" name="message" placeholder="Message..." required>
        <button type="submit">Send</button>
      </form>
    <?php endif; ?>
  </div>
</div>

<script>
  function startNewChat() {
    alert("To start a new chat, send a friend request and wait for it to be accepted.");
  }
</script>
</body>
</html>
