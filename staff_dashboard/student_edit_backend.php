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
    $fatherage = $_POST['father_age'];
    $fatherMobile = $_POST['father_Mobile_number'];
    $motherName = $_POST['Mother_name'];
    $motherOccupation = $_POST['Mother_occupation'];
    $motherage = $_POST['motherage'];
    
    $motherMobile = $_POST['mother_Mobile_number'];

        $sqlUpdateBasicDetails = "
        UPDATE students SET 
        father_name = ?, 
        father_occupation = ?,
        father_age = ?, 
        father_phone = ?, 
        mother_name = ?, 
        mother_age=?,
        mother_occupation = ?, 
        mother_phone = ?
        WHERE roll_no = ?";

        $stmt = $conn->prepare($sqlUpdateBasicDetails);
        $stmt->bind_param(
            'sssssssss',
            $fatherName,
            $fatherOccupation,
            $fatherage,
            $fatherMobile,
            $motherName,
            $motherage,
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


$profilePath = "./student_details/student_photo/" . htmlspecialchars($student['profile_photo']);
$imageFound = file_exists($profilePath);

$familyPath = "./student_details/family_photo/" . htmlspecialchars($student['family_photo']);
$family_imageFound = file_exists($familyPath);


?>