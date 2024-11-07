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
    // Check if the form is 'basic_details' and update the basic details
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
        } else {
            echo "Error updating basic details: " . $conn->error;
        }
    }

    elseif ($formName == 'reference_persons') {
        $name = $_POST["name_$i"];
        $phone = $_POST["phone_$i"];
        $address = $_POST["address_$i"];

        $sqlUpdateReferencePersons = "
        UPDATE students SET 
            father_name = ?, 
            father_occupation = ?, 
            father_phone = ?, 
            mother_name = ?, 
            mother_occupation = ?, 
            mother_phone = ? 
        WHERE roll_no = ?";

        $stmt = $conn->prepare($sqlUpdateReferencePersons);
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
            echo "Reference person details updated successfully.";
        } else {
            echo "Error updating reference person details: " . $conn->error;
        }
    }

    elseif ($formName == 'profile_photos') {
        // File uploads for profile photos, family photos, and documents
        $studentPhoto = null;
        $familyPhoto = null;


        // Handle student photo upload
        if (isset($_FILES['student-photo']) && $_FILES['student-photo']['error'] == 0) {
            $studentPhoto = $_FILES['student-photo']['name'];
            if (in_array(pathinfo($studentPhoto, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg'])) {
                move_uploaded_file($_FILES['student-photo']['tmp_name'], './student_details/student_photo/' . $studentPhoto);
            } else {
                echo "Invalid student photo format.";
                exit();
            }
        }

        // Handle family photo upload
        if (isset($_FILES['family-photo']) && $_FILES['family-photo']['error'] == 0) {
            $familyPhoto = $_FILES['family-photo']['name'];
            if (in_array(pathinfo($familyPhoto, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg'])) {
                move_uploaded_file($_FILES['family-photo']['tmp_name'], './student_details/family_photo/' . $familyPhoto);
            } else {
                echo "Invalid family photo format.";
                exit();
            }
        }

        // Handle document upload
       

        // Update the student profile photos and documents
        $sqlUpdatePhotos = "
        UPDATE students SET 
            profile_photo = ?, 
            family_photo = ?, 
        WHERE roll_no = ?";

        $stmt = $conn->prepare($sqlUpdatePhotos);
        $stmt->bind_param(
            'sss',
            $studentPhoto,
            $familyPhoto,
            $roll_no
        );

        if ($stmt->execute()) {
            echo "Photos and document updated successfully.";
        } else {
            echo "Error updating photos and document: " . $conn->error;
        }
    }
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

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Edit | <?php echo htmlspecialchars($student["name"]); ?></title>

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


<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="reference_persons">

<input type="hidden" name="form_name" value="reference_persons">

                    <label for="reference-persons">Reference Persons</label><br>
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
                                <td><textarea name="address_1" rows="2" placeholder="Enter address" name='reference_text'></textarea></td>
                            </tr>
                        </tbody>
                    </table>


 <button type="submit" class="submit-btn">Update</button>

</form>
           
<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="cgpa_section">
                    <label for="gpa">GPA</label><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="gpa">sem 1</label><br>
                            <input type="number" id="gpa" name="cgpa_sem1" step="0.01" min="0" max="10"> <br>

                        </div>

                        <div>
                            <label for="gpa">sem 2</label><br>
                            <input type="number" id="gpa" name="cgpa_sem2" step="0.01" min="0" max="10"> <br>
                        </div>
                    </div><br>
                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="gpa">sem 3</label><br>
                            <input type="number" id="gpa" name="cgpa_sem3" step="0.01" min="0" max="10"> <br>
                        </div>
                        <div>
                            <label for="gpa">sem 4</label><br>
                            <input type="number" id="gpa" name="cgpa_sem4" step="0.01" min="0" max="10"> <br>
                        </div>
                    </div><br>
                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="gpa">sem 5</label><br>
                            <input type="number" id="gpa" name="cgpa_sem5" step="0.01" min="0" max="10"> <br>
                        </div>
                        <div>
                            <label for="gpa">sem 6</label><br>
                            <input type="number" id="gpa" name="cgpa_sem6" step="0.01" min="0" max="10"> <br>
                        </div>
                    </div><br>
                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="gpa">sem 7</label><br>
                            <input type="number" id="gpa" name="cgpa_sem7" step="0.01" min="0" max="10"> <br>
                        </div>
                        <div>
                            <label for="gpa">sem 8 </label><br>
                            <input type="number" id="gpa" name="cgpa_sem8" step="0.01" min="0" max="10"> <br>
                        </div>
                    </div><br><br>
                    <label for="CGPA">CGPA</label><br>
                    <input type="number" id="CGPA" name="total_CGPA" step="0.01" min="0" max="10"> <br>

                    <button type="submit" class="submit-btn">Update</button>

</form>
<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="photo_person">

                    <label for="family-photo">Student Photo:</label><br>
                    <input type="file" id="student-photo" name="student-photo" accept="image/*"><br>

                    <div class="student-photo-container">

                    <?php if ($imageFound): ?>
    <img src="./student_details/student_photo/<?php echo htmlspecialchars($student['profile_photo']); ?>" alt="Student Photo" class="student-photo">
<?php else: ?>
    <p style="color:red; font-weight: bold; margin-top:30px;">File not found</p>
<?php endif; ?>


                    </div>


                    <label for="family-photo">Family Photo:</label><br>
                    <input type="file" id="family-photo" name="family-photo" accept="image/*"><br>

                    <div class="family-photo-container">


                    <?php if ($family_imageFound): ?>
    <img src="./student_details/family_photo/<?php echo htmlspecialchars($student['family_photo']); ?>" alt="family Photo" class="family-photo">
<?php else: ?>
    <p style="color:red; font-weight: bold; margin-top:30px;">File not found</p>
<?php endif; ?>   </div>

<button type="submit" class="submit-btn">Update</button>

</form>

<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="parent_details">


                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;margin-top:20px;">
                        <div>
                            <label for="Father-name">Father Name:</label>
                            <input type="text" id="Father-name" name="Father_name" placeholder="Enter Father name">
                        </div>

                        <div>
                            <label for="Age">Age</label>
                            <input type="number" id="Age" name="Age" placeholder="Enter Age">
                        </div>

                        <div>
                            <label for="Father-occupation">Father Occupation:</label>
                            <input type="text" id="Father-occupation" name="Father_occupation" placeholder="Enter occupation">
                        </div>

                        <div>
                            <label for="Mobile_number">Mobile number:</label>
                            <input type="text" id="father_Mobile_number" name="father_Mobile_number" placeholder="Enter Mobile number">
                        </div>
                    </div><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="mother-name">Mother Name:</label>
                            <input type="text" id="Mother-name" name="Mother_name" placeholder="Enter Mother name">
                        </div>
                        <div>
                            <label for="Age">Age</label>
                            <input type="number" id="Age" name="Age" placeholder="Enter Age">
                        </div>

                        <div>
                            <label for="Mother-occupation">Mother Occupation:</label>
                            <input type="text" id="Mother-occupation" name="Mother_occupation" placeholder="Enter occupation">
                        </div>

                        <div>
                            <label for="Mobile_number">Mobile number:</label>
                            <input type="text" id="mother_Mobile_number" name="mother_Mobile_number" placeholder="Enter Mobile number">
                        </div>
                    </div><br>

                    <button type="submit" class="submit-btn">Update</button>

</form>

<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="disciplinary_issues">


                    <div style="margin-bottom: 10px;">
                        <label for="Student Disciplinary Issues">Student </label><br>

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