<?php
session_start();

include("../resources/connection.php");

if (!isset($_SESSION['staff_id'])) {
    header("Location: ../staff_login.php");
    exit();
}

$staff_id = $_SESSION['staff_id'];

$staff_query = "SELECT department, year FROM staff WHERE staff_id = ?";
$stmt = $conn->prepare($staff_query);

if (!$stmt) {
    die("Error preparing statement (staff query): " . $conn->error);
}

$stmt->bind_param("i", $staff_id);
$stmt->execute();

if (!$stmt->execute()) {
    die("Error executing staff query: " . $stmt->error);
}

$stmt->bind_result($staff_department, $staff_year);
$stmt->fetch();
$stmt->close();

$student_query = "SELECT roll_no, name FROM students WHERE department = ? AND year = ?";
$stmt = $conn->prepare($student_query);

if (!$stmt) {
    die("Error preparing statement (student query): " . $conn->error);
}

$stmt->bind_param("si", $staff_department, $staff_year);

if (!$stmt->execute()) {
    die("Error executing student query: " . $stmt->error);
}

$result = $stmt->get_result();

if (!$result) {
    die("Error retrieving student result: " . $stmt->error);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/dash/style.css">
    <link rel="stylesheet" href="../static/staffdash/custom.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Student List</title> 
    <style>
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-btn {
            padding: 6px 12px;
            margin: 0 5px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
<?php include("./sidebar.php") ?>
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-user"></i>
            <span class="text">Students</span> 
        </div>

        <!-- Profile  -->
        <div class="container">
            <h1>Student List</h1>
            <h1>Department: <?php echo htmlspecialchars($staff_department); ?>, Year: <?php echo htmlspecialchars($staff_year); ?></h1>

            <table>
                <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['roll_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>
                                <a href="student_view.php?roll_no=<?php echo urlencode($row['roll_no']); ?>" class="action-btn">View Profile</a>
                                <a href="student_edit.php?roll_no=<?php echo urlencode($row['roll_no']); ?>" class="action-btn" style="background-color: #f39c12;">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$stmt->close();
$conn->close();
?>

    <script src="../static/dash/script.js"></script>
</body>
</html>