<?php
include './includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $blood_group = $_POST['blood_group'];

    // SQL query to insert receiver into the database
    $sql = "INSERT INTO receivers (username, password, blood_group) VALUES ('$username', '$password', '$blood_group')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        // Redirect to login page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receiver Registration</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container">
        <div class="glass-form">
            <h2>Receiver Registration</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <input type="text" name="blood_group" placeholder="Blood Group" required>
                </div>
                <button type="submit" name="register">Register</button>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
