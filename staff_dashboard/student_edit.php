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
    $registerNumber = $_POST['Register_Number'];
    $name = $_POST['name'];
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
    $cgpa = $_POST['total_CGPA'];
    $cgpaSemesters = [
        $_POST['cgpa_sem1'], $_POST['cgpa_sem2'], $_POST['cgpa_sem3'],
        $_POST['cgpa_sem4'], $_POST['cgpa_sem5'], $_POST['cgpa_sem6'],
        $_POST['cgpa_sem7'], $_POST['cgpa_sem8']
    ];

    $fatherName = $_POST['Father_name'];
    $fatherOccupation = $_POST['Father_occupation'];
    $fatherMobile = $_POST['father_Mobile_number'];
    $motherName = $_POST['Mother_name'];
    $motherOccupation = $_POST['Mother_occupation'];
    $motherMobile = $_POST['mother_Mobile_number'];
    $issueDate = $_POST['issue_date'];
    $issueDescription = $_POST['issue_description'];
    $actionTaken = $_POST['action_taken'];
    $staffHandle = $_POST['Staff_Handle'];

    // File uploads
    $studentPhoto = null;
    $familyPhoto = null;
    $documentUpload = null;

    if (isset($_FILES['student-photo']) && $_FILES['student-photo']['error'] == 0) {
        $studentPhoto = $_FILES['student-photo']['name'];
        if (in_array(pathinfo($studentPhoto, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg'])) {
            move_uploaded_file($_FILES['student-photo']['tmp_name'], './student_details/student_photo/' . $studentPhoto);
        } else {
            echo "Invalid photo format.";
            exit();
        }
    }

    if (isset($_FILES['family-photo']) && $_FILES['family-photo']['error'] == 0) {
        $familyPhoto = $_FILES['family-photo']['name'];
        if (in_array(pathinfo($familyPhoto, PATHINFO_EXTENSION), ['jpg', 'png', 'jpeg'])) {
            move_uploaded_file($_FILES['family-photo']['tmp_name'], 'uploads/' . $familyPhoto);
        } else {
            echo "Invalid family photo format.";
            exit();
        }
    }

    if (isset($_FILES['Document upload']) && $_FILES['Document upload']['error'] == 0) {
        $documentUpload = $_FILES['Document upload']['name'];
        if (in_array(pathinfo($documentUpload, PATHINFO_EXTENSION), ['pdf', 'doc', 'docx'])) {
            move_uploaded_file($_FILES['Document upload']['tmp_name'], 'uploads/' . $documentUpload);
        } else {
            echo "Invalid document format.";
            exit();
        }
    }

    // Update student profile
    $sqlUpdateStudent = "
    UPDATE students SET 
        name = ?, 
        department = ?, 
        year = ?, 
        dob = ?,
        roll_no = ?,
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
        phone = ?, 
        profile_photo = ?, 
        family_photo = ?, 
        father_name = ?, 
        father_occupation = ?, 
        father_phone = ?, 
        mother_name = ?, 
        mother_occupation = ?, 
        mother_phone = ?, 
        issue_date = ?, 
        issue_description = ?, 
        action_taken = ?, 
        staff_handle = ?, 
        document_upload = ? 
    WHERE roll_no = ?";

$stmt = $conn->prepare($sqlUpdateStudent);
$stmt->bind_param(
    'ssssssssssssssssssssssssssssss',  
    $name, $department, $year, $dob, $roll_no, $age, $sex, $community, 
    $placeOfBirth, $bloodGroup, $caste, $religion, $motherTongue, 
    $personalIdentifications, $email, $phone, $studentPhoto, $familyPhoto, 
    $fatherName, $fatherOccupation, $fatherMobile, $motherName, $motherOccupation, 
    $motherMobile, $issueDate, $issueDescription, $actionTaken, $staffHandle, 
    $documentUpload, $roll_no
);


    if ($stmt->execute()) {
        echo "Student profile updated successfully.";
        header("Location: ./student_list.php");
    } else {
        echo "Error updating student profile: " . $conn->error;
    }

    // Update CGPA data
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
        WHERE student_id = ?";

    $stmt = $conn->prepare($sqlUpdateCGPA);
    $stmt->bind_param(
        'ddddddddds', 
        $cgpaSemesters[0], $cgpaSemesters[1], $cgpaSemesters[2], 
        $cgpaSemesters[3], $cgpaSemesters[4], $cgpaSemesters[5], 
        $cgpaSemesters[6], $cgpaSemesters[7], $cgpa, $roll_no
    );

    if ($stmt->execute()) {
        echo "CGPA data updated successfully.";
    } else {
        echo "Error updating CGPA data: " . $conn->error;
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

            <form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST"  enctype="multipart/form-data">
            <label for="Register_Number">Register Number</label>
            <input type="text" id="Register_Number" name="Register_Number"  value="<?php echo htmlspecialchars($student["roll_no"]); ?>" readonly>

            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student["name"]); ?>" readonly><br>

            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
              <div>  
                <label for="department">Department</label>
                <input type="text" id="department" name="department" readonly value="<?php echo htmlspecialchars($student["department"]); ?>"><br>
                    <select id="department" name="department" >
                        <option selected disabled >Select</option>
                        <option value="AI&DS">Artificial Intelligence and Data Science</option>
                        <option value="IT">Information Technology</option>
                        <option value="CSE">Computer Science</option>
                        <option value="EEE">Electrical and Electronics Engineering</option>
                        <option value="ECE">Electronics and Communication Engineering</option>
                        <option value="MECH">Mechanical Engineering</option>
                        <option value="CIVIL">Civil Engineering</option>
                <!-- Add more options as needed -->
                    </select>
              </div>

              <div>

                <label for="year">Year of Study</label>
                <input type="text" id="year" name="year"  value="<?php echo htmlspecialchars($student["year"]); ?>"><br>
                
              </div>
            </div><br>
            
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" >
                </div>
                <div>
                    <label for="Age">Age</label>
                    <input type="number" id="Age" name="Age">
                </div>
            </div>

            <label for="sex">Sex</label>
            <select id="sex" name="sex" >
                <option selected disabled>select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="community">Community</label>
            <input type="text" id="community" name="community">

            <label for="place-of-birth">Place of Birth</label>
            <input type="text" id="place-of-birth" name="place_of_birth" >

            <label for="blood-group">Blood Group</label>
            <select id="blood-group" name="blood_group" >
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="caste">Caste</label>
            <input type="text" id="caste" name="caste">

            <label for="religion">Religion</label>
            <input type="text" id="religion" name="religion">

            <label for="mother-tongue">Mother Tongue</label>
            <input type="text" id="mother-tongue" name="mother_tongue">

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
                    <td><input type="text" name="name_1" placeholder="Enter name"></td>
                    <td><input type="text" name="phone_1" placeholder="Enter phone no"></td>
                    <td><textarea name="address_1" rows="2" placeholder="Enter address"></textarea></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td><input type="text" name="name_1" placeholder="Enter name"></td>
                    <td><input type="text" name="phone_1" placeholder="Enter phone no"></td>
                    <td><textarea name="address_1" rows="2" placeholder="Enter address"></textarea></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td><input type="text" name="name_1" placeholder="Enter name"></td>
                    <td><input type="text" name="phone_1" placeholder="Enter phone no"></td>
                    <td><textarea name="address_1" rows="2" placeholder="Enter address"></textarea></td>
                  </tr>
                  <!-- Add more rows as needed -->
                </tbody>
              </table>
              

            <label for="personal-identifications">Personal Identifications</label>
            <textarea id="personal-identifications" name="personal_identifications" rows="3" placeholder="Enter unique identification marks or features"></textarea>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" >

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" >

            


            <label for="gpa">GPA</label><br>

            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="gpa">sem 1</label><br>
                    <input type="number" id="gpa" name="cgpa_sem1" step="0.01" min="0" max="10" >  <br>
            
                </div>

                <div>
                    <label for="gpa">sem 2</label><br>
                    <input type="number" id="gpa" name="cgpa_sem2" step="0.01" min="0" max="10" >  <br>
                </div>
            </div><br>
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="gpa">sem 3</label><br>
                    <input type="number" id="gpa" name="cgpa_sem3" step="0.01" min="0" max="10" >  <br>
                </div>
                <div>
                    <label for="gpa">sem 4</label><br>
                    <input type="number" id="gpa" name="cgpa_sem4" step="0.01" min="0" max="10" >  <br>
                </div>
            </div><br>
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="gpa">sem 5</label><br>
                    <input type="number" id="gpa" name="cgpa_sem5" step="0.01" min="0" max="10" >  <br>
                </div>
                <div>
                    <label for="gpa">sem 6</label><br>
                    <input type="number" id="gpa" name="cgpa_sem6" step="0.01" min="0" max="10" >  <br>
                </div>
            </div><br>
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="gpa">sem 7</label><br>
                    <input type="number" id="gpa" name="cgpa_sem7" step="0.01" min="0" max="10" >  <br>
                </div>
                <div>
                    <label for="gpa">sem 8 </label><br>
                    <input type="number" id="gpa" name="cgpa_sem8" step="0.01" min="0" max="10" >  <br>
                </div>
            </div><br><br>
            <label for="CGPA">CGPA</label><br>
            <input type="number" id="CGPA" name="total_CGPA" step="0.01" min="0" max="10" > <br>

            <label for="family-photo">Student Photo:</label><br>
            <input type="file" id="student-photo" name="student-photo" accept="image/*"><br>

            <div class="student-photo-container">

<img src="./student_details/student_photo/<?php echo htmlspecialchars($student['profile_photo']); ?>" alt="" class="student-photo">

</div>


            <label for="family-photo">Family Photo:</label><br>
            <input type="file" id="family-photo" name="family_photo" accept="image/*"><br>

            <div class="family-photo-container">

<img src="../static/img/profile.png" alt="" class="family-photo">

</div>

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


            <div style="margin-bottom: 10px;">
                  <label for="Student Disciplinary Issues">Student Disciplinary Issues</label><br>

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
                <input type="file" id="Document upload" name="Document upload" accept="image/*" ><br>
                   

                
                <div class="disciplinary-proof mt-5">

<img src="" alt="" class="disciplinary-proof-image">

</div>
                   
            <button type="submit" class="submit-btn">Submit Profile</button>
        </form>



        </div>
    </div>
</div>



            <script src="../static/dash/script.js"></script>
</body>

</html>