<?php
include '../includes/db_connection.php';

// SQL query to get all available blood samples with hospital details
$sql = "SELECT blood_samples.*, hospitals.name AS hospital_name 
        FROM blood_samples 
        JOIN hospitals ON blood_samples.hospital_id = hospitals.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Blood Samples</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Available Blood Samples</h2>
        <table>
            <thead>
                <tr>
                    <th>Hospital Name</th>
                    <th>Blood Type</th>
                    <th>Quantity</th>
                    <th>Request</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['hospital_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['blood_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                        echo "<td><a href='../Receiver/request.php?blood_sample_id=" . htmlspecialchars($row['id']) . "'>Request Sample</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No blood samples available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
