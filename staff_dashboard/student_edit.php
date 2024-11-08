<?php
session_start();
include("../resources/connection.php");

if (!isset($_SESSION['staff_id'])) {
    header("Location: ../staff_login.php");
    exit();
}

$roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : null;
if (!$roll_no) {
    echo "Student Roll No. not specified!";
    exit();
}

$student_query = "SELECT * FROM students WHERE roll_no = ?";
$stmt = $conn->prepare($student_query);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("s", $roll_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No student found with Roll No.: " . htmlspecialchars($roll_no);
    exit();
}

$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formName = $_POST['form_name']; 
    $roll_no = $_POST['roll_no'];


    if ($formName == 'basic_details') {
        $name = $_POST['name'];
        $roll_no = $_POST['roll_no'];
        $department = $_POST['department'];
        $year = $_POST['year'];
        $dob = $_POST['dob'];
        $age = $_POST['Age'];
        $sex = $_POST['sex'];
        $community = $_POST['community'];
        $placeOfBirth = $_POST['place_of_birth'];
        $bloodGroup = $_POST['blood_group'];
        $caste = $_POST['caste'];
        $religion = $_POST['religion'];
        $motherTongue = $_POST['mother_tongue'];
        $personalIdentifications = $_POST['personal_identifications'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Update the basic details in the database
        $sqlUpdateBasicDetails = "
        UPDATE students SET 
            name = ?, 
            department = ?, 
            year = ?, 
            dob = ?,
            age = ?,
            sex = ?, 
            community = ?, 
            place_of_birth = ?, 
            blood_group = ?, 
            caste = ?, 
            religion = ?, 
            mother_tongue = ?, 
            personal_identifications = ?, 
            email = ?, 
            phone = ?
        WHERE roll_no = ?";

        $stmt = $conn->prepare($sqlUpdateBasicDetails);
        $stmt->bind_param(
            'ssssssssssssssss',
            $name,
            $department,
            $year,
            $dob,
            $age,
            $sex,
            $community,
            $placeOfBirth,
            $bloodGroup,
            $caste,
            $religion,
            $motherTongue,
            $personalIdentifications,
            $email,
            $phone,
            $roll_no
        );

        if ($stmt->execute()) {
            echo "Basic details updated successfully.";
        header("Location: ./student_edit.php?roll_no=$student[roll_no]");
        } else {
            echo "Error updating basic details: " . $conn->error;
        }
    }

    elseif ($formName == 'reference_persons') {
            $reference_name = $_POST["reference_name"];
            $reference_phone = $_POST["reference_phone"];
            $reference_address = $_POST["reference_text"];
            $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : null;
            
            $sqlInsertReferencePersons = "
            INSERT INTO reference_persons (student_roll_no, name, phone_no, address) 
            VALUES (?, ?, ?, ?)";
    
            $stmt = $conn->prepare($sqlInsertReferencePersons);
            $stmt->bind_param(
                'ssss',
                $roll_no,
                $reference_name,
                $reference_phone,
                $reference_address
            );
    
            if ($stmt->execute()) {
                echo "Reference person  details inserted successfully.<br>";
        header("Location: ./student_edit.php?roll_no=$student[roll_no]");
            } else {
                echo "Error inserting reference person details: " . $conn->error . "<br>";
            }
        
    }

    elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_name']) && $_POST['form_name'] == 'reference_persons_update') {
        $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : null;

    // Check for delete actions
    $i = 1;
    while (isset($_POST["delete_{$i}"])) {
        $reference_person_id = $_POST["delete_{$i}"];
        
        // Delete the reference person record
        $delete_query = "DELETE FROM reference_persons WHERE id = ? AND student_roll_no = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param('is', $reference_person_id, $roll_no);
        if ($stmt->execute()) {
            echo "Reference person {$i} deleted successfully.<br>";
        header("Location: ./student_edit.php?roll_no=$student[roll_no]");
        } else {
            echo "Error deleting reference person {$i}: " . $conn->error . "<br>";
        }
        $i++;
    }

    // Check for update actions
    $i = 1;
    while (isset($_POST["update_{$i}"])) {
        $reference_person_id = $_POST["update_{$i}"];
        $reference_name = $_POST["reference_name_{$i}"];
        $reference_phone = $_POST["reference_phone_{$i}"];
        $reference_address = $_POST["reference_text_{$i}"];

        // Ensure the fields are not empty
        if (!empty($reference_name) && !empty($reference_phone) && !empty($reference_address)) {
            // Prepare the update query
            $sqlUpdateReferencePersons = "
                UPDATE reference_persons 
                SET name = ?, phone_no = ?, address = ? 
                WHERE id = ? AND student_roll_no = ?";

            $stmt = $conn->prepare($sqlUpdateReferencePersons);
            $stmt->bind_param('sssis', $reference_name, $reference_phone, $reference_address, $reference_person_id, $roll_no);

            // Execute the query
            if ($stmt->execute()) {
                echo "Reference person {$i} updated successfully.<br>";
        header("Location: ./student_edit.php?roll_no=$student[roll_no]");

            } else {
                echo "Error updating reference person {$i}: " . $conn->error . "<br>";
            }
        } else {
            echo "Please fill all fields for reference person {$i}.<br>";
        }
        $i++;
    }
}

elseif ($formName == 'student_photo') {
    $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : null;
    $studentPhoto = null;

    // Handle student photo upload
    if (isset($_FILES['student-photo']) && $_FILES['student-photo']['error'] == 0) {
        $studentPhoto = $_FILES['student-photo']['name'];
        $studentPhotoPath = './student_details/student_photo/' . $studentPhoto;
        
        // Check for valid image format
        if (in_array(pathinfo($studentPhoto, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg'])) {
            if (move_uploaded_file($_FILES['student-photo']['tmp_name'], $studentPhotoPath)) {
                echo "Student photo uploaded successfully.";
            } else {
                echo "Error uploading student photo.";
                exit();
            }
        } else {
            echo "Invalid student photo format. Only jpg, png, and jpeg are allowed.";
            exit();
        }
    }


    // Update the student profile photos in the database
    $sqlUpdatePhotos = "
    UPDATE students 
    SET profile_photo = ?
    WHERE roll_no = ?";

    $stmt = $conn->prepare($sqlUpdatePhotos);
    $stmt->bind_param('ss', $studentPhoto,$roll_no);

    if ($stmt->execute()) {
        echo "Photos updated successfully.";
        header("Location: ./student_edit.php?roll_no=$student[roll_no]");
    } else {
        echo "Error updating photos: " . $conn->error;
    }
}

elseif ($formName == 'family_photo') {
    $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : null;
 
    $familyPhoto = null;


    // Handle family photo upload
    if (isset($_FILES['family-photo']) && $_FILES['family-photo']['error'] == 0) {
        $familyPhoto = $_FILES['family-photo']['name'];
        $familyPhotoPath = './student_details/family_photo/' . $familyPhoto;
        
        // Check for valid image format
        if (in_array(pathinfo($familyPhoto, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg'])) {
            if (move_uploaded_file($_FILES['family-photo']['tmp_name'], $familyPhotoPath)) {
                echo "Family photo uploaded successfully.";
            } else {
                echo "Error uploading family photo.";
                exit();
            }
        } else {
            echo "Invalid family photo format. Only jpg, png, and jpeg are allowed.";
            exit();
        }
    }

    // Update the student profile photos in the database
    $sqlUpdatePhotos = "
    UPDATE students 
    SET family_photo = ? 
    WHERE roll_no = ? ";

    $stmt = $conn->prepare($sqlUpdatePhotos);
    $stmt->bind_param('ss', $familyPhoto, $roll_no);

    if ($stmt->execute()) {
        echo "Photos updated successfully.";
        header("Location: ./student_edit.php?roll_no=$student[roll_no]");
    } else {
        echo "Error updating photos: " . $conn->error;
    }
}

    // CGPA SECTION

    elseif($formName == 'cgpa_section'){
        $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : '';

        $cgpaSemesters = [
            $_POST['cgpa_sem1'],
            $_POST['cgpa_sem2'],
            $_POST['cgpa_sem3'],
            $_POST['cgpa_sem4'],
            $_POST['cgpa_sem5'],
            $_POST['cgpa_sem6'],
            $_POST['cgpa_sem7'],
            $_POST['cgpa_sem8']
        ];
        $cgpa = $_POST['total_CGPA'];
    
        // Update the CGPA data
        $sqlUpdateCGPA = "
            UPDATE student_cgpa 
            SET 
                cgpa_sem1 = ?, 
                cgpa_sem2 = ?, 
                cgpa_sem3 = ?, 
                cgpa_sem4 = ?, 
                cgpa_sem5 = ?, 
                cgpa_sem6 = ?, 
                cgpa_sem7 = ?, 
                cgpa_sem8 = ?, 
                cgpa_cumulative = ? 
            WHERE student_roll_no = ?";
    
        $stmt = $conn->prepare($sqlUpdateCGPA);
        $stmt->bind_param(
            'ddddddddds',
            $cgpaSemesters[0],
            $cgpaSemesters[1],
            $cgpaSemesters[2],
            $cgpaSemesters[3],
            $cgpaSemesters[4],
            $cgpaSemesters[5],
            $cgpaSemesters[6],
            $cgpaSemesters[7],
            $cgpa,
            $roll_no
        );
    
        if ($stmt->execute()) {
            echo "CGPA data updated successfully.";
            header("Location: ./student_edit.php?roll_no=$student[roll_no]");
        } else {
            echo "Error updating CGPA data: " . $conn->error;
        }

    }
    
    elseif ($formName == 'parents_details') {
        $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : '';
    $fatherName = $_POST['Father_name'];
    $fatherOccupation = $_POST['Father_occupation'];
    $fatherMobile = $_POST['father_Mobile_number'];
    $motherName = $_POST['Mother_name'];
    $motherOccupation = $_POST['Mother_occupation'];
    $motherMobile = $_POST['mother_Mobile_number'];

        $sqlUpdateBasicDetails = "
        UPDATE students SET 
        father_name = ?, 
        father_occupation = ?, 
        father_phone = ?, 
        mother_name = ?, 
        mother_occupation = ?, 
        mother_phone = ?
        WHERE roll_no = ?";

        $stmt = $conn->prepare($sqlUpdateBasicDetails);
        $stmt->bind_param(
            'sssssss',
            $fatherName,
            $fatherOccupation,
            $fatherMobile,
            $motherName,
            $motherOccupation,
            $motherMobile,
            $roll_no
        );

        if ($stmt->execute()) {
            echo "Basic details updated successfully.";
        header("Location: ./student_edit.php?roll_no=$student[roll_no]");
        } else {
            echo "Error updating basic details: " . $conn->error;
        }
}
elseif($formName == 'disciplinary_issues_update' && !empty($issue_id)){
    $issue_id = isset($_GET['issue_id']) ? $_GET['issue_id'] : '';
    $issueDate = $_POST['issue_date'];
        $issueDescription = $_POST['issue_description'];
        $actionTaken = $_POST['action_taken'];
        $staffHandle = $_POST['staff_handle_name'];
        $documentUpload = '';

        // Handle file upload
        if (isset($_FILES['document_upload']) && $_FILES['document_upload']['error'] == 0) {
            // File path and validation
            $uploadDir = './student_details/disciplinary_issues_doc/';
            $documentUpload = $_FILES['document_upload']['name'];
            $uploadPath = $uploadDir . $documentUpload;

            // Only allow PDF files
            if (pathinfo($documentUpload, PATHINFO_EXTENSION) == 'pdf') {
                move_uploaded_file($_FILES['document_upload']['tmp_name'], $uploadPath);
            } else {
                echo "Only PDF files are allowed.";
                exit();
            }
        }

        $sqlUpdateDisciplinaryIssues = "UPDATE disciplinary_issues SET 
                                            issue_date = ?, 
                                            issue_description = ?, 
                                            action_taken = ?, 
                                            staff_handle = ?, 
                                            document_upload = ? 
                                        WHERE id = ?";

        $stmt = $conn->prepare($sqlUpdateDisciplinaryIssues);
        $stmt->bind_param('sssssi', $issueDate, $issueDescription, $actionTaken, $staffHandle, $documentUpload, $issue_id);

        if ($stmt->execute()) {
            echo "Disciplinary issue updated successfully.";
        } else {
            echo "Error updating disciplinary issue: " . $stmt->error;
        }
    }
    elseif($formName == 'disciplinary_issues_update' && !empty($issue_id)){
        $sqlDeleteDisciplinaryIssue = "DELETE FROM disciplinary_issues WHERE id = ?";
        $stmt = $conn->prepare($sqlDeleteDisciplinaryIssue);
        $stmt->bind_param('i', $issue_id);

        if ($stmt->execute()) {
            echo "Disciplinary issue deleted successfully.";
            // Redirect to avoid resubmission
            header("Location: student_edit.php?roll_no=" . urlencode($roll_no));
            exit();
        } else {
            echo "Error deleting disciplinary issue: " . $stmt->error;
        }
    }


}



$docPath = "./student_details/disciplinary_issues_doc/" . htmlspecialchars($student['document_upload']);
$docfile = file_exists($docPath);

$profilePath = "./student_details/student_photo/" . htmlspecialchars($student['profile_photo']);
$imageFound = file_exists($profilePath);

$familyPath = "./student_details/family_photo/" . htmlspecialchars($student['family_photo']);
$family_imageFound = file_exists($familyPath);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../static/dash/style.css">
    <link rel="stylesheet" href="../static/staffdash/studentedit.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Edit | <?php echo htmlspecialchars($student["name"]); ?></title>
    <style>
        .action_btn{
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
                <span class="text">Students</span>
            </div>

            <!-- Profile  -->
            <div class="container">

                    
            <form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data" name="basic_details">
            <input type="hidden" name="form_name" value="basic_details">
    <!-- Register Number (Read-only) -->
    <label for="Register_Number">Register Number</label>
    <input type="text" id="roll_nor" name="roll_no" value="<?php echo htmlspecialchars($student["roll_no"]); ?>" readonly>

    <!-- Name (Read-only) -->
    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student["name"]); ?>" readonly>

    <!-- Department and Year of Study -->
    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <!-- Department -->
        <div>
            <label for="department">Department</label>
            <input type="text" id="department" name="department" readonly value="<?php echo htmlspecialchars($student["department"]); ?>">
            <select id="department" name="department">
                <option selected disabled>Select</option>
                <option value="AI&DS">Artificial Intelligence and Data Science</option>
                <option value="IT">Information Technology</option>
                <option value="CSE">Computer Science</option>
                <option value="EEE">Electrical and Electronics Engineering</option>
                <option value="ECE">Electronics and Communication Engineering</option>
                <option value="MECH">Mechanical Engineering</option>
                <option value="CIVIL">Civil Engineering</option>
            </select>
        </div>

        <!-- Year of Study -->
        <div>
            <label for="year">Year of Study</label>
            <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($student["year"]); ?>">
        </div>
    </div>

    <!-- Date of Birth and Age -->
    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <!-- Date of Birth -->
        <div>
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($student['dob']); ?>">
        </div>

        <!-- Age -->
        <div>
            <label for="Age">Age</label>
            <input type="number" id="Age" name="Age" value="<?php echo htmlspecialchars($student['age']); ?>">
        </div>
    </div>

    <!-- Sex -->
    <label for="sex">Sex</label>
    <select id="sex" name="sex">
        <option value="male" <?php echo ($student['sex'] == 'male') ? 'selected' : ''; ?>>Male</option>
        <option value="female" <?php echo ($student['sex'] == 'female') ? 'selected' : ''; ?>>Female</option>
        <option value="other" <?php echo ($student['sex'] == 'other') ? 'selected' : ''; ?>>Other</option>
    </select>

    <!-- Additional Information -->
    <label for="community">Community</label>
    <input type="text" id="community" name="community" value="<?php echo htmlspecialchars($student['community']); ?>">

    <label for="place_of_birth">Place of Birth</label>
    <input type="text" id="place_of_birth" name="place_of_birth" value="<?php echo htmlspecialchars($student['place_of_birth']); ?>">

    <!-- Blood Group -->
    <label for="blood_group">Blood Group</label>
    <select id="blood_group" name="blood_group">
        <option value="A+" <?php echo ($student['blood_group'] == 'A+') ? 'selected' : ''; ?>>A+</option>
        <option value="A-" <?php echo ($student['blood_group'] == 'A-') ? 'selected' : ''; ?>>A-</option>
        <option value="B+" <?php echo ($student['blood_group'] == 'B+') ? 'selected' : ''; ?>>B+</option>
        <option value="B-" <?php echo ($student['blood_group'] == 'B-') ? 'selected' : ''; ?>>B-</option>
        <option value="AB+" <?php echo ($student['blood_group'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
        <option value="AB-" <?php echo ($student['blood_group'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
        <option value="O+" <?php echo ($student['blood_group'] == 'O+') ? 'selected' : ''; ?>>O+</option>
        <option value="O-" <?php echo ($student['blood_group'] == 'O-') ? 'selected' : ''; ?>>O-</option>
    </select>

    <!-- Additional Fields -->
    <label for="caste">Caste</label>
    <input type="text" id="caste" name="caste" value="<?php echo htmlspecialchars($student['caste']); ?>">

    <label for="religion">Religion</label>
    <input type="text" id="religion" name="religion" value="<?php echo htmlspecialchars($student['religion']); ?>">

    <label for="mother_tongue">Mother Tongue</label>
    <input type="text" id="mother_tongue" name="mother_tongue" value="<?php echo htmlspecialchars($student['mother_tongue']); ?>">

    <label for="personal_identifications">Personal Identifications</label>
    <textarea id="personal_identifications" name="personal_identifications" rows="3"><?php echo htmlspecialchars($student['personal_identifications']); ?></textarea>

    <!-- Contact Information -->
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>">

    <label for="phone">Phone</label>
    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>">

    <!-- Submit Button -->
    <button type="submit" class="submit-btn">Update</button>

</form>

<!-- REFERENCE PERSON UPDATE -->
<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data" name="reference_persons_update">
    <input type="hidden" name="form_name" value="reference_persons_update">
    
    <label for="reference-persons">Reference Persons</label><br>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Phone No</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetching reference persons from the database
            $reference_persons_query = "SELECT * FROM reference_persons WHERE student_roll_no = ?";
            $stmt = $conn->prepare($reference_persons_query);
            $stmt->bind_param('s', $roll_no);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$i}</td>
                        <td><input type='text' name='reference_name_{$i}' value='" . htmlspecialchars($row['name']) . "' placeholder='Enter name'></td>
                        <td><input type='text' name='reference_phone_{$i}' value='" . htmlspecialchars($row['phone_no']) . "' placeholder='Enter phone no'></td>
                        <td><textarea name='reference_text_{$i}' rows='2' placeholder='Enter address'>" . htmlspecialchars($row['address']) . "</textarea></td>
                        <td>
                            <button type='submit' class='action_btn' name='update_{$i}' value='{$row['id']}'>Update</button>
                            <button type='submit' class='action_btn' name='delete_{$i}' value='{$row['id']}'>Delete</button>
                        </td>
                    </tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>

</form>



<!-- REFERENCE PERSONINSERT -->
<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="reference_persons">

<input type="hidden" name="form_name" value="reference_persons">

                    <label for="reference-persons">Reference Persons Insert</label><br>
                    <table>
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Phone No</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><input type="text" name="reference_name" placeholder="Enter name"></td>
                                <td><input type="text" name="reference_phone" placeholder="Enter phone no"></td>
                                <td><textarea name="reference_text" rows="2" placeholder="Enter address" ></textarea></td>
                            </tr>
                        </tbody>
                    </table>


 <button type="submit" class="submit-btn">INSERT</button>

</form>

<!-- REFERENCE PERSON INSERT  END-->

<!-- CGPA INSERT UPDATE DELETE -->
<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="cgpa_section">
<input type="hidden" name="form_name" value="cgpa_section">
<?php
 $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : '';

// Fetch the existing CGPA data
$sqlFetchCGPA = "SELECT * FROM student_cgpa WHERE student_roll_no = ?";
$stmt = $conn->prepare($sqlFetchCGPA);
$stmt->bind_param('s', $roll_no);
$stmt->execute();
$result = $stmt->get_result();

$cgpaData = $result->fetch_assoc();

// Check if the CGPA data exists
if ($cgpaData) {
    $cgpaSemesters = [
        $cgpaData['cgpa_sem1'],
        $cgpaData['cgpa_sem2'],
        $cgpaData['cgpa_sem3'],
        $cgpaData['cgpa_sem4'],
        $cgpaData['cgpa_sem5'],
        $cgpaData['cgpa_sem6'],
        $cgpaData['cgpa_sem7'],
        $cgpaData['cgpa_sem8']
    ];
    $cgpa = $cgpaData['cgpa_cumulative'];
} else {
    // If no CGPA data exists for the student, initialize variables
    $cgpaSemesters = [null, null, null, null, null, null, null, null];
    $cgpa = null;
}?>
                    <label for="gpa">GPA</label><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <div>
            <label for="gpa">sem 1</label><br>
            <input type="number" id="gpa" name="cgpa_sem1" step="0.01" min="0" max="10" value="<?php echo htmlspecialchars($cgpaSemesters[0]); ?>"> <br>
        </div>

        <div>
            <label for="gpa">sem 2</label><br>
            <input type="number" id="gpa" name="cgpa_sem2" step="0.01" min="0" max="10" value="<?php echo htmlspecialchars($cgpaSemesters[1]); ?>"> <br>
        </div>
    </div><br>

    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <div>
            <label for="gpa">sem 3</label><br>
            <input type="number" id="gpa" name="cgpa_sem3" step="0.01" min="0" max="10" value="<?php echo htmlspecialchars($cgpaSemesters[2]); ?>"> <br>
        </div>
        <div>
            <label for="gpa">sem 4</label><br>
            <input type="number" id="gpa" name="cgpa_sem4" step="0.01" min="0" max="10" value="<?php echo htmlspecialchars($cgpaSemesters[3]); ?>"> <br>
        </div>
    </div><br>

    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <div>
            <label for="gpa">sem 5</label><br>
            <input type="number" id="gpa" name="cgpa_sem5" step="0.01" min="0" max="10" value="<?php echo htmlspecialchars($cgpaSemesters[4]); ?>"> <br>
        </div>
        <div>
            <label for="gpa">sem 6</label><br>
            <input type="number" id="gpa" name="cgpa_sem6" step="0.01" min="0" max="10" value="<?php echo htmlspecialchars($cgpaSemesters[5]); ?>"> <br>
        </div>
    </div><br>

    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <div>
            <label for="gpa">sem 7</label><br>
            <input type="number" id="gpa" name="cgpa_sem7" step="0.01" min="0" max="10" value="<?php echo htmlspecialchars($cgpaSemesters[6]); ?>"> <br>
        </div>
        <div>
            <label for="gpa">sem 8 </label><br>
            <input type="number" id="gpa" name="cgpa_sem8" step="0.01" min="0" max="10" value="<?php echo htmlspecialchars($cgpaSemesters[7]); ?>"> <br>
        </div>
    </div><br><br>

    <label for="CGPA">CGPA</label><br>
    <input type="number" id="CGPA" name="total_CGPA" step="0.01" min="0" max="10" value="<?php echo htmlspecialchars($cgpa); ?>"> <br>

                    <button type="submit" class="submit-btn">Update</button>

</form>
<!-- CGPA SECTION END -->



<!-- PHOTO SECTION START -->
<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  >
<input type="hidden" name="form_name" value="student_photo">

                    <label for="family-photo">Student Photo:</label><br>
                    <input type="file" id="student-photo" name="student-photo" accept="image/*" ><br>
                    <div class="student-photo-container">

                    <?php if ($imageFound): ?>
    <img src="./student_details/student_photo/<?php echo htmlspecialchars($student['profile_photo']); ?>" alt="Student Photo" class="student-photo">
<?php else: ?>
    <p style="color:red; font-weight: bold; margin-top:30px;">File not found</p>
<?php endif; ?>


                    </div>
                    <button type="submit" class="submit-btn">Update</button>

</form>

<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  >
<input type="hidden" name="form_name" value="family_photo">


                    <label for="family-photo">Family Photo:</label><br>
                    <input type="file" id="family-photo" name="family-photo" accept="image/*"><br>

                    <div class="family-photo-container">

                    <?php if ($family_imageFound): ?>
    <img src="./student_details/family_photo/<?php echo htmlspecialchars($student['family_photo']); ?>" alt="family Photo" class="family-photo"  style="width: 480px;object-fit:cover;">
<?php else: ?>
    <p style="color:red; font-weight: bold; margin-top:30px;">File not found</p>
<?php endif; ?>   </div>

<button type="submit" class="submit-btn">Update</button>

</form>

<!--  PHOTO SECTION END-->

<!-- PARENT DETAILS -->
<?php
 $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : '';

// Fetch the existing CGPA data
$sqlFetchCGPA = "SELECT * FROM students WHERE roll_no = ?";
$stmt = $conn->prepare($sqlFetchCGPA);
$stmt->bind_param('s', $roll_no);
$stmt->execute();
$result = $stmt->get_result();

$parent_details = $result->fetch_assoc();

?>
<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="parent_details">

<input type="hidden" name="form_name" value="parents_details">

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;margin-top:20px;">
                        <div>
                            <label for="Father-name">Father Name:</label>
                            <input type="text" id="Father-name" name="Father_name" placeholder="Enter Father name" value="<?php echo htmlspecialchars($parent_details['father_name']); ?>">
                        </div>

                        <div>
                            <label for="Age">Age</label>
                            <input type="number" id="Age" name="Age" placeholder="<?php echo htmlspecialchars($parent_details['father_age']); ?>">
                        </div>

                        <div>
                            <label for="Father-occupation">Father Occupation:</label>
                            <input type="text" id="Father-occupation" name="Father_occupation" placeholder="Enter occupation" value="<?php echo htmlspecialchars($parent_details['father_occupation']); ?>">
                        </div>

                        <div>
                            <label for="Mobile_number">Mobile number:</label>
                            <input type="text" id="father_Mobile_number" name="father_Mobile_number" placeholder="Enter Mobile number" value="<?php echo htmlspecialchars($parent_details['father_phone']); ?>">
                        </div>
                    </div><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="mother-name">Mother Name:</label>
                            <input type="text" id="Mother-name" name="Mother_name" placeholder="Enter Mother name" value="<?php echo htmlspecialchars($parent_details['mother_name']); ?>">
</div>
                        <div>
                            <label for="Age">Age</label>
                            <input type="number" id="Age" name="Age" placeholder="<?php echo htmlspecialchars($parent_details['mother_age']); ?>" >
                        </div>

                        <div>
                            <label for="Mother-occupation">Mother Occupation:</label>
                            <input type="text" id="Mother-occupation" name="Mother_occupation" placeholder="Enter occupation" value="<?php echo htmlspecialchars($parent_details['mother_occupation']); ?>">
                        </div>

                        <div>
                            <label for="Mobile_number">Mobile number:</label>
                            <input type="text" id="mother_Mobile_number" name="mother_Mobile_number" placeholder="Enter Mobile number" value="<?php echo htmlspecialchars($parent_details['mother_phone']); ?>">
                        </div>
                    </div><br>

                    <button type="submit" class="submit-btn">Update</button>

</form>

<!-- PARENT DETAIL END -->

<!-- Disciplinary_issues view -->

<?php
// Fetch all disciplinary issues for the student
$sqlFetchDisciplinaryIssues = "SELECT id, student_roll_no, issue_date, issue_description, action_taken, staff_handle, document_upload FROM disciplinary_issues WHERE student_roll_no = ?";
$stmt = $conn->prepare($sqlFetchDisciplinaryIssues);
$stmt->bind_param('s', $roll_no);
$stmt->execute();
$result = $stmt->get_result();

// Loop through all disciplinary issues and display the form for each
while ($disciplinaryData = $result->fetch_assoc()) {
    $issueDate = $disciplinaryData['issue_date'];
    $issueDescription = $disciplinaryData['issue_description'];
    $actionTaken = $disciplinaryData['action_taken'];
    $staffHandle = $disciplinaryData['staff_handle'];
    $documentUpload = $disciplinaryData['document_upload'];
?>
    <form action="student_edit.php?roll_no=<?php echo urlencode($roll_no); ?>&issue_id=<?php echo $disciplinaryData['id']; ?>" method="POST" enctype="multipart/form-data" name="disciplinary_issues_<?php echo $disciplinaryData['id']; ?>">
        <input type="hidden" name="form_name" value="disciplinary_issues_update">
        <label for="Student Disciplinary Issues">Disciplinary Issues View (Issue ID: <?php echo $disciplinaryData['id']; ?>)</label><br>

        <div style="margin-bottom: 10px;">
            <label for="issue-date-<?php echo $disciplinaryData['id']; ?>">Issue Date:</label>
            <input type="date" id="issue-date-<?php echo $disciplinaryData['id']; ?>" name="issue_date" value="<?php echo htmlspecialchars($issueDate); ?>">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="issue-description-<?php echo $disciplinaryData['id']; ?>">Issue Description:</label>
            <textarea id="issue-description-<?php echo $disciplinaryData['id']; ?>" name="issue_description" rows="3" placeholder="Describe the issue"><?php echo htmlspecialchars($issueDescription); ?></textarea>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="action-taken-<?php echo $disciplinaryData['id']; ?>">Action Taken:</label>
            <textarea id="action-taken-<?php echo $disciplinaryData['id']; ?>" name="action_taken" rows="2" placeholder="Describe action taken"><?php echo htmlspecialchars($actionTaken); ?></textarea>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="staff-handle-<?php echo $disciplinaryData['id']; ?>">Staff Handle:</label>
            <textarea id="staff-handle-<?php echo $disciplinaryData['id']; ?>" name="staff_handle_name" rows="2" placeholder="Enter staff name"><?php echo htmlspecialchars($staffHandle); ?></textarea>
        </div>

        <br>

        <label for="document-upload-<?php echo $disciplinaryData['id']; ?>">Document Upload (PDF only):</label><br>
        <input type="file" id="document-upload-<?php echo $disciplinaryData['id']; ?>" name="document_upload" accept="application/pdf"><br>

        <div class="disciplinary-proof mt-5">
            <?php if ($documentUpload && file_exists('./student_details/disciplinary_issues_doc/' . $documentUpload)): ?>
                <iframe src="./student_details/disciplinary_issues_doc/<?php echo htmlspecialchars($documentUpload); ?>" width="100%" height="600px" frameborder="0" style="border: none; margin-top: 20px;"></iframe>
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
<?php
}
?>



                <!--  Disciplinary_issues view end -->

<!-- Disciplinary_issues insert -->
                <form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="disciplinary_issues">
<input type="hidden" name="form_name" value="disciplinary_issues">


                    <div style="margin-bottom: 10px;">
                        <label for="Student Disciplinary Issues">Disciplinary_issues Add</label><br>

                        <label for="issue-date">Issue date</label>
                        <input type="date" id="issue-date" name="issue_date">
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="issue-description">Issue Description:</label><br>
                        <textarea id="issue-description" name="issue_description" rows="3" placeholder="Describe the issue"></textarea>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="action-taken">Action Taken:</label><br>
                        <textarea id="action-taken" name="action_taken" rows="2" placeholder="Describe action taken"></textarea>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="Staff_Handle">Staff_Handle</label><br>
                        <textarea id="Staff_Handle" name="Staff_Handle" rows="2" placeholder="Enter staff name"></textarea>
                    </div>


                    <br>

                    <label for="Document upload">Document upload</label><br>
                    <p>Note: Accept Pdf Only</p>
                    <input type="file" id="Document upload" name="Document_upload" accept="application/pdf" value="h"><br>



                    <div class="disciplinary-proof mt-5">

                    
                    <?php
$filePath = './student_details/disciplinary_issues_doc/' . htmlspecialchars($student['document_upload']);
if (file_exists($filePath) && !empty($student['document_upload'])): ?>
    <iframe 
        src="<?php echo $filePath; ?>" 
        width="100%" 
        height="600px" 
        frameborder="0" 
        style="border: none; margin-top: 20px;">
    </iframe>
<?php else: ?>
    <p style="color: red; font-weight: bold; margin-top: 30px;">File not found</p>
<?php endif; ?>


                        
                        </iframe>


                    </div>

                    <button type="submit" class="submit-btn">update</button>
                </form>



            </div>
        </div>
    </div>



    <script src="../static/dash/script.js"></script>
</body>

</html>