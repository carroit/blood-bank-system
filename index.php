<?php
include '../includes/db_connection.php';

session_start();

// Fetch all available blood samples along with hospital information
$sql = "SELECT bs.*, h.name AS hospital_name 
        FROM blood_samples bs 
        JOIN hospitals h ON bs.hospital_id = h.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Blood Samples</title>
    <link rel="stylesheet" href="">
</head>
<body>
<div class="navbar">
        <h1>Blood Bank System</h1>
      <div class="nav-buttons">
            <a href="../login.php" class="button">Login</a>
            <div class="dropdown">
                <button class="button dropdown-button">Register</button>
                <div class="dropdown-content">
                    <a href="./hosipital registration.php" class="button">Register as Hosipital</a>
                    <a href="../Reciver register.php" class="button">Register as Reciver</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="table-container">
            <h2>Available Blood Samples</h2>
            <table>
                <thead>
                    <tr>
                        <th>Blood Type</th>
                        <th>Quantity</th>
                        <th>Hospital</th>
                        <th>Request</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['blood_type'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['hospital_name'] . "</td>";

                            if (isset($_SESSION['user'])) {
                                if ($_SESSION['user_type'] == 'receiver') {
                                    $receiver_blood_group = $_SESSION['user']['blood_group'];
                                    if ($row['blood_type'] == $receiver_blood_group) {
                                        echo "<td><a href='request_blood.php?id=" . $row['id'] . "' class='button'>Request Sample</a></td>";
                                    } else {
                                        echo "<td>Not Eligible</td>";
                                    }
                                } else {
                                    echo "<td>Not Allowed</td>";
                                }
                            } else {
                                echo "<td><a href='login.php' class='button'>Request Sample</a></td>";
                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No blood samples available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
