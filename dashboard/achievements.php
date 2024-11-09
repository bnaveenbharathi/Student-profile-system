<?php
include("../resources/connection.php");
session_start();

if (!isset($_SESSION['roll_no'])) {
    header("Location: ../login.php");
    exit();
}

$roll_no = $_SESSION['roll_no'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'insert') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $link = $_POST['link'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $originalFileName = $_FILES['image']['name'];
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $uniqueFileName = $roll_no . '_' . time() . '.' . $fileExtension;
            $filePath = './uploads/achievements/' . $uniqueFileName;

            move_uploaded_file($fileTmpPath, $filePath);

            $stmt = $conn->prepare("INSERT INTO achievements (student_roll_no, name, photo, description, link) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $roll_no, $name, $uniqueFileName, $description, $link);
            $stmt->execute();
            $stmt->close();
            header("Location: achievements.php");
            exit();
        }
    } elseif ($action === 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $link = $_POST['link'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $originalFileName = $_FILES['image']['name'];
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $uniqueFileName = $roll_no . '_' . time() . '.' . $fileExtension;
            $filePath = './uploads/achievements/' . $uniqueFileName;

            move_uploaded_file($fileTmpPath, $filePath);

            $stmt = $conn->prepare("UPDATE achievements SET name=?, photo=?, description=?, link=? WHERE id=? AND student_roll_no=?");
            $stmt->bind_param("sssssi", $name, $uniqueFileName, $description, $link, $id, $roll_no);
        } else {
            $stmt = $conn->prepare("UPDATE achievements SET name=?, description=?, link=? WHERE id=? AND student_roll_no=?");
            $stmt->bind_param("sssii", $name, $description, $link, $id, $roll_no);
        }

        $stmt->execute();
        $stmt->close();
        header("Location: achievements.php");
        exit();
    } elseif ($action === 'delete') {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM achievements WHERE id=? AND student_roll_no=?");
        $stmt->bind_param("is", $id, $roll_no);
        $stmt->execute();
        $stmt->close();
        header("Location: achievements.php");
        exit();
    }
}

$stmt = $conn->prepare("SELECT * FROM achievements WHERE student_roll_no = ?");
$stmt->bind_param("s", $roll_no);
$stmt->execute();
$achievements = $stmt->get_result();
$stmt->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/dash/style.css">
    <link rel="stylesheet" href="../static/dash/achievements.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Dashboard | Achievements</title>
    <style>
        .edit-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .edit-popup .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }
        .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php include("./sidebar.php") ?>

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-user"></i>
            <span class="text">Achievements</span>
        </div>

        <div class="container-Achievements">
            <div class="form-container">
                <h1>Achievements</h1>

                <form action="achievements.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="insert">
                    <label for="name">Achievement Name:</label>
                    <input type="text" name="name" required>

                    <label for="image">Upload Image:</label>
                    <input type="file" name="image" accept="image/*" required>

                    <label for="description">Description:</label>
                    <textarea name="description" required></textarea>

                    <label for="link">Link:</label>
                    <input type="url" name="link">

                    <button type="submit" class="edit-button">Add Achievement</button>
                </form>

                <h2 style="margin-top: 30px;">Your Achievements</h2>
                <div class="achievements-list">
                    <?php while ($row = $achievements->fetch_assoc()) { ?>
                        <div class="achievement-item">
                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                            <img src="./uploads/achievements/<?php echo htmlspecialchars($row['photo']); ?>" alt="Achievement Image" width="200px">
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <a href="<?php echo htmlspecialchars($row['link']); ?>">Learn More</a>

                            <div class="achievement-actions">
                                <button type="button" onclick="toggleEditForm(<?php echo $row['id']; ?>)" class="edit-button">Edit</button>
                                <form action="achievements.php" method="POST">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="edit-button">Delete</button>
                                </form>
                            </div>

                            <div id="editForm<?php echo $row['id']; ?>" class="edit-popup">
                                <div class="popup-content">
                                    <span class="close" onclick="closeEditForm(<?php echo $row['id']; ?>)">&times;</span>
                                    <h2>Edit Achievement</h2>
                                    <form action="achievements.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                        <label>Achievement Name:</label>
                                        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>

                                        <label>Upload New Image:</label>
                                        <input type="file" name="image" accept="image/*">

                                        <label>Description:</label>
                                        <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>

                                        <label>Link:</label>
                                        <input type="url" name="link" value="<?php echo htmlspecialchars($row['link']); ?>">

                                        <button type="submit" class="edit-button">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../static/dash/script.js"></script>
<script>
    function toggleEditForm(id) {
        document.getElementById(`editForm${id}`).style.display = 'flex';
    }

    function closeEditForm(id) {
        document.getElementById(`editForm${id}`).style.display = 'none';
    }

    window.onclick = function(event) {
        const popups = document.getElementsByClassName("edit-popup");
        for (let i = 0; i < popups.length; i++) {
            if (event.target === popups[i]) {
                popups[i].style.display = "none";
            }
        }
    };
</script>

</body>
</html>
