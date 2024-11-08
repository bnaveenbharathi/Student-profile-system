

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
    <title>Dashboard Panel</title> 
</head>
<body>
     
<?php include("./sidebar.php") ?>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                <i class="uil uil-user"></i>

                    <span class="text">Profile</span> 
                </div>
               
                <!-- Profile  -->
                <div class="container">
                <?php
$sqlFetchDisciplinaryIssues = "SELECT * FROM disciplinary_issues WHERE student_roll_no = ?";
$stmt = $conn->prepare($sqlFetchDisciplinaryIssues);
$stmt->bind_param('s', $roll_no);
$stmt->execute();
$result = $stmt->get_result();

while ($disciplinaryData = $result->fetch_assoc()) {
    $issueDate = $disciplinaryData['issue_date'];
    $issueDescription = $disciplinaryData['issue_description'];
    $actionTaken = $disciplinaryData['action_taken'];
    $staffHandle = $disciplinaryData['staff_handle'];
    $documentUpload = $disciplinaryData['document_upload'];
?>
   
<?php
}
?>
                <form action="student_edit.php?roll_no=<?php echo urlencode($roll_no); ?>&issue_id=<?php echo $disciplinaryData['id']; ?>" method="POST" enctype="multipart/form-data" name="disciplinary_issues_<?php echo $disciplinaryData['id']; ?>">
        <input type="hidden" name="form_name" value="disciplinary_issues_update">
        <label for="Student Disciplinary Issues">Disciplinary Issues View (Issue ID: <?php echo $disciplinaryData['id']; ?>)</label><br>

        <div style="margin-bottom: 10px;">
            <label for="issue-date-<?php echo $disciplinaryData['id']; ?>">Issue Date:</label>
            <input type="date" id="issue-date-<?php echo $disciplinaryData['id']; ?>" name="issue_date" value="<?php echo safe_htmlspecialchars($issueDate); ?>">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="issue-description-<?php echo $disciplinaryData['id']; ?>">Issue Description:</label>
            <textarea id="issue-description-<?php echo $disciplinaryData['id']; ?>" name="issue_description" rows="3" placeholder="Describe the issue"><?php echo safe_htmlspecialchars($issueDescription); ?></textarea>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="action-taken-<?php echo $disciplinaryData['id']; ?>">Action Taken:</label>
            <textarea id="action-taken-<?php echo $disciplinaryData['id']; ?>" name="action_taken" rows="2" placeholder="Describe action taken"><?php echo safe_htmlspecialchars($actionTaken); ?></textarea>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="staff-handle-<?php echo $disciplinaryData['id']; ?>">Staff Handle:</label>
            <textarea id="staff-handle-<?php echo $disciplinaryData['id']; ?>" name="staff_handle_name" rows="2" placeholder="Enter staff name"><?php echo safe_htmlspecialchars($staffHandle); ?></textarea>
        </div>

        <br>

        <label for="document-upload-<?php echo $disciplinaryData['id']; ?>">Document Upload (PDF only):</label><br>
        <input type="file" id="document-upload-<?php echo $disciplinaryData['id']; ?>" name="document_upload" accept="application/pdf"><br>

        <div class="disciplinary-proof mt-5">
            <?php if ($documentUpload && file_exists('./student_details/disciplinary_issues_doc/' . $documentUpload)): ?>
                <iframe src="./student_details/disciplinary_issues_doc/<?php echo safe_htmlspecialchars($documentUpload); ?>" width="100%" height="600px" frameborder="0" style="border: none; margin-top: 20px;"></iframe>
            <?php else: ?>
                <p style="color: red; font-weight: bold; margin-top: 30px;">File not found</p>
            <?php endif; ?>
        </div>

        <button type="submit" class="submit-btn">Update</button>
    </form>

    <!-- Delete button form for this specific disciplinary record -->
    <form action="student_edit.php?roll_no=<?php echo urlencode($roll_no); ?>&issue_id=<?php echo $disciplinaryData['id']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this disciplinary issue?');">
        <input type="hidden" name="form_name" value="disciplinary_issues_delete">
        <button type="submit" class="delete-btn">Delete Disciplinary Issue</button>
    </form>

                    

            </div>
    </section>

    <script src="../static/dash/script.js"></script>
</body>
</html>










































