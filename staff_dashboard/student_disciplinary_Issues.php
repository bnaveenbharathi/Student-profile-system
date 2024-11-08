<?php 
include("../resources/connection.php");
session_start();

if (!isset($_SESSION['staff_id'])) {
    header("Location: ../staff_login.php");
    exit();
}

$roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : null;
if (!$roll_no) {
    echo "Student Roll No. not specified!";
    exit();
}

$sqlFetchStudent = "SELECT * FROM students WHERE roll_no = ?";
$stmtStudent = $conn->prepare($sqlFetchStudent);
$stmtStudent->bind_param("s", $roll_no);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();

if ($resultStudent->num_rows === 0) {
    echo "No student found with Roll No.: " . htmlspecialchars($roll_no);
    exit();
}

$student = $resultStudent->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_issue'])) {
        $issue_id = $_POST['issue_id'];
        $issue_date = $_POST['issue_date'];
        $issue_description = $_POST['issue_description'];
        $action_taken = $_POST['action_taken'];
        $staff_handle_name = $_POST['staff_handle_name'];

        // Check if a new file was uploaded
        if (isset($_FILES['document_upload']) && $_FILES['document_upload']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['document_upload']['tmp_name'];
            $originalFileName = $_FILES['document_upload']['name'];
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            // Generate a unique file name
            $uniqueFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_' . time() . '.' . $fileExtension;
            $filePath = './student_details/disciplinary_issues_doc/' . $uniqueFileName;
            move_uploaded_file($fileTmpPath, $filePath);
        } else {
            // No new file uploaded; fetch the existing file name from the database
            $sqlFetchExistingFile = "SELECT document_upload FROM disciplinary_issues WHERE id = ?";
            $stmtFetchExistingFile = $conn->prepare($sqlFetchExistingFile);
            $stmtFetchExistingFile->bind_param("i", $issue_id);
            $stmtFetchExistingFile->execute();
            $resultFetchExistingFile = $stmtFetchExistingFile->get_result();
            $existingFile = $resultFetchExistingFile->fetch_assoc();
            $uniqueFileName = $existingFile['document_upload'];
        }

        $sqlUpdateIssue = "UPDATE disciplinary_issues SET issue_date = ?, issue_description = ?, action_taken = ?, staff_handle = ?, document_upload = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdateIssue);
        $stmtUpdate->bind_param("sssssi", $issue_date, $issue_description, $action_taken, $staff_handle_name, $uniqueFileName, $issue_id);
        $stmtUpdate->execute();
        echo "Disciplinary issue updated successfully!";
        header("Location: ./student_disciplinary_Issues.php?roll_no=$student[roll_no]");
        exit();
    }

    if (isset($_POST['delete_issue'])) {
        $issue_id = $_POST['issue_id'];
        $sqlDeleteIssue = "DELETE FROM disciplinary_issues WHERE id = ?";
        $stmtDelete = $conn->prepare($sqlDeleteIssue);
        $stmtDelete->bind_param("i", $issue_id);
        $stmtDelete->execute();
        echo "Disciplinary issue deleted successfully!";
        header("Location: ./student_disciplinary_Issues.php?roll_no=$student[roll_no]");
        exit();
    }
}

$sqlFetchDisciplinaryIssues = "SELECT * FROM disciplinary_issues WHERE student_roll_no = ?";
$stmtIssues = $conn->prepare($sqlFetchDisciplinaryIssues);
$stmtIssues->bind_param('s', $roll_no);
$stmtIssues->execute();
$resultIssues = $stmtIssues->get_result();

function safe_htmlspecialchars($value) {
    return htmlspecialchars($value !== NULL ? $value : '', ENT_QUOTES, 'UTF-8');
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/dash/style.css">
    <link rel="stylesheet" href="../static/staffdash/studentedit.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <title>Disciplinary Issues | <?php echo safe_htmlspecialchars($student["name"]); ?></title> 
    <style>  .action_btn{
            padding: 6px;
            color: white;
            background: #007bff;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<?php include("./sidebar.php") ?>

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-user"></i>
            <span class="text">Profile</span> 
        </div>
        <div class="container">
            <?php if ($resultIssues->num_rows > 0): ?>
                <?php while ($disciplinaryData = $resultIssues->fetch_assoc()): ?>
                    <form action="student_disciplinary_issues.php?roll_no=<?php echo urlencode($roll_no); ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="issue_id" value="<?php echo $disciplinaryData['id']; ?>">

                        <label for="Student Disciplinary Issues">Disciplinary Issues View (Issue ID: <?php echo $disciplinaryData['id']; ?>)</label><br>

                        <div style="margin-bottom: 10px;">
                            <label for="issue-date-<?php echo $disciplinaryData['id']; ?>">Issue Date:</label>
                            <input type="date" id="issue-date-<?php echo $disciplinaryData['id']; ?>" name="issue_date" value="<?php echo safe_htmlspecialchars($disciplinaryData['issue_date']); ?>">
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label for="issue-description-<?php echo $disciplinaryData['id']; ?>">Issue Description:</label>
                            <textarea id="issue-description-<?php echo $disciplinaryData['id']; ?>" name="issue_description" rows="3" placeholder="Describe the issue"><?php echo safe_htmlspecialchars($disciplinaryData['issue_description']); ?></textarea>
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label for="action-taken-<?php echo $disciplinaryData['id']; ?>">Action Taken:</label>
                            <textarea id="action-taken-<?php echo $disciplinaryData['id']; ?>" name="action_taken" rows="2" placeholder="Describe action taken"><?php echo safe_htmlspecialchars($disciplinaryData['action_taken']); ?></textarea>
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label for="staff-handle-<?php echo $disciplinaryData['id']; ?>">Staff Handle:</label>
                            <textarea id="staff-handle-<?php echo $disciplinaryData['id']; ?>" name="staff_handle_name" rows="2" placeholder="Enter staff name"><?php echo safe_htmlspecialchars($disciplinaryData['staff_handle']); ?></textarea>
                        </div>

                        <label for="document-upload-<?php echo $disciplinaryData['id']; ?>">Document Upload (PDF only):</label><br>
                        <input type="file" id="document-upload-<?php echo $disciplinaryData['id']; ?>" name="document_upload" accept="application/pdf"><br>

                        <div class="disciplinary-proof mt-5">
                            <?php if ($disciplinaryData['document_upload'] && file_exists('./student_details/disciplinary_issues_doc/' . $disciplinaryData['document_upload'])): ?>
                                <iframe src="./student_details/disciplinary_issues_doc/<?php echo safe_htmlspecialchars($disciplinaryData['document_upload']); ?>" width="100%" height="600px" frameborder="0" style="border: none; margin-top: 20px;"></iframe>
                            <?php else: ?>
                                <p style="color: red; font-weight: bold; margin-top: 30px;">File not found</p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" name="update_issue" class="submit-btn">Update</button>
                        <button type="submit" name="delete_issue" class="delete-btn action_btn" onclick="return confirm('Are you sure you want to delete this disciplinary issue?');" style="margin-top: 10px;">Delete</button>
                    </form>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color: red; font-weight: bold; margin-top: 30px;">No disciplinary issues found for this student.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../static/staff_dash/script.js"></script>
</body>
</html>
