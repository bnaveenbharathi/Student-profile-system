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
    $roll_no = $_GET['roll_no'] ?? null;
    $studentPhoto = $_FILES['student-photo']['name'] ?? null;

    if ($studentPhoto && $_FILES['student-photo']['error'] == UPLOAD_ERR_OK) {
        $fileExtension = pathinfo($studentPhoto, PATHINFO_EXTENSION);

        $uniqueFileName = pathinfo($studentPhoto, PATHINFO_FILENAME) . '_' . time() . '.' . $fileExtension;
        $studentPhotoPath = "./student_details/student_photo/" . $uniqueFileName;

        if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($_FILES['student-photo']['tmp_name'], $studentPhotoPath)) {
                $sqlUpdatePhotos = "UPDATE students SET profile_photo = ? WHERE roll_no = ?";
                $stmt = $conn->prepare($sqlUpdatePhotos);
                $stmt->bind_param('ss', $uniqueFileName, $roll_no);

                if ($stmt->execute()) {
                    echo "Student photo updated successfully.";
                    header("Refresh: 2; URL=./student_edit.php?roll_no=$roll_no");
                } else {
                    echo "Database error: Unable to update photo.";
                }
            } else {
                echo "Error moving uploaded file.";
            }
        } else {
            echo "Invalid file format. Only JPG, PNG, and JPEG are allowed.";
        }
    } else {
        echo "File upload error: " . $_FILES['student-photo']['error'];
    }
}

elseif ($formName == 'family_photo') {
    $roll_no = $_GET['roll_no'] ?? null;
    $familyPhoto = $_FILES['family-photo']['name'] ?? null;

    if ($familyPhoto && $_FILES['family-photo']['error'] == UPLOAD_ERR_OK) {
        $fileExtension = pathinfo($familyPhoto, PATHINFO_EXTENSION);

        $uniqueFileName = pathinfo($familyPhoto, PATHINFO_FILENAME) . '_' . time() . '.' . $fileExtension;
        $familyPhotoPath = "./student_details/family_photo/" . $uniqueFileName;

        if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($_FILES['family-photo']['tmp_name'], $familyPhotoPath)) {
                $sqlUpdatePhotos = "UPDATE students SET family_photo = ? WHERE roll_no = ?";
                $stmt = $conn->prepare($sqlUpdatePhotos);
                $stmt->bind_param('ss', $uniqueFileName, $roll_no);

                if ($stmt->execute()) {
                    echo "Family photo updated successfully.";
                    header("Refresh: 2; URL=./student_edit.php?roll_no=$roll_no");
                } else {
                    echo "Database error: Unable to update photo.";
                }
            } else {
                echo "Error moving uploaded file.";
            }
        } else {
            echo "Invalid file format. Only JPG, PNG, and JPEG are allowed.";
        }
    } else {
        echo "File upload error: " . $_FILES['family-photo']['error'];
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
elseif($formName=='disciplinary_issues'){
    $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : '';
      $issue_date = $_POST['issue_date'];
      $issue_description = $_POST['issue_description'];
      $action_taken = $_POST['action_taken'];
      $staff_handle = $_POST['Staff_Handle']; 

      $uniqueFileName = null;
      if (isset($_FILES['Document_upload']) && $_FILES['Document_upload']['error'] === UPLOAD_ERR_OK) {
          $fileTmpPath = $_FILES['Document_upload']['tmp_name'];
          $originalFileName = $_FILES['Document_upload']['name'];
          $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
          $uniqueFileName = uniqid('doc_', true) . '.' . $fileExtension;
          $filePath = './student_details/disciplinary_issues_doc/' . $uniqueFileName;

          if (move_uploaded_file($fileTmpPath, $filePath)) {
              echo "File uploaded successfully!";
          } else {
              echo "Error uploading the file.";
          }
      }

      $sqlInsertIssue = "INSERT INTO disciplinary_issues (student_roll_no, issue_date, issue_description, action_taken, staff_handle, document_upload) 
                         VALUES (?, ?, ?, ?, ?, ?)";
      $stmtInsert = $conn->prepare($sqlInsertIssue);
      $stmtInsert->bind_param("ssssss", $roll_no, $issue_date, $issue_description, $action_taken, $staff_handle, $uniqueFileName);

      if ($stmtInsert->execute()) {
          echo "Disciplinary issue added successfully!";
        header("Location: ./student_edit.php?roll_no=$student[roll_no]");

          exit();
      } else {
          echo "Error inserting data into the database: " . $stmtInsert->error;
      }
  }

}



$profilePhoto = isset($student['profile_photo']) && $student['profile_photo'] !== NULL ? $student['profile_photo'] : '';
$profilePath = "./student_details/student_photo/" . $profilePhoto;
$imageFound = file_exists($profilePath);

$familyPhoto = isset($student['family_photo']) && $student['family_photo'] !== NULL ? $student['family_photo'] : '';
$familyPath = "./student_details/family_photo/" . $familyPhoto;
$family_imageFound = file_exists($familyPath);



function safe_htmlspecialchars($value) {
    return htmlspecialchars($value !== NULL ? $value : '', ENT_QUOTES, 'UTF-8');
}


?>

