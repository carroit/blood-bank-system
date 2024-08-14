<?php
include './includes/db_connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; // 'hospital' or 'receiver'

    if ($user_type == 'hospital') {
        $sql = "SELECT * FROM hospitals WHERE username = ?";
    } else {
        $sql = "SELECT * FROM receivers WHERE username = ?";
    }

    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

   

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['user_type'] = $user_type;
            if ($user_type == 'hospital') {
                header("Location: Hosipital/add blood.php");
            } else {
                header("Location: Reciver/request.php");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="glass-form">
            <h2>Login</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <select name="user_type">
                        <option value="hospital">Hospital</option>
                        <option value="receiver">Receiver</option>
                    </select>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
