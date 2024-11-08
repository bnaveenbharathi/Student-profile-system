<?php 

include("./student_edit_backend.php")

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

    <title>Student Edit | <?php echo safe_htmlspecialchars($student["name"]); ?></title>
    <style>
        .action_btn{
            padding: 6px;
            color: white;
            background: #007bff;
            border: none;
            border-radius: 5px;
        }
    
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4); 
    }

    /* Modal content */
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%; 
        border-radius: 8px;
    }

    /* Close button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
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
                <span class="text">Students</span>
            </div>

            <!-- Profile  -->
            <div class="container">

                    
            <form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data" name="basic_details">
            <input type="hidden" name="form_name" value="basic_details">
    <!-- Register Number -->
    <label for="Register_Number">Register Number</label>
    <input type="text" id="roll_nor" name="roll_no" value="<?php echo safe_htmlspecialchars(isset($student["roll_no"]) ? $student['roll_no']  : '' ); ?>" readonly>

    <!-- Name-->
    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="<?php echo safe_htmlspecialchars($student["name"]); ?>" readonly>

    <!-- Department and Year of Study -->
    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <!-- Department -->
        <div>
            <label for="department">Department</label>
            <input type="text" id="department" name="department" readonly value="<?php echo safe_htmlspecialchars($student["department"]); ?>">
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
            <input type="text" id="year" name="year" value="<?php echo safe_htmlspecialchars($student["year"]); ?>">
        </div>
    </div>

    <!-- Date of Birth and Age -->
    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <!-- Date of Birth -->
        <div>
            <label for="dob">Date of Birth</label>
            <input type="text" id="dob" name="dob" value="<?php echo safe_htmlspecialchars($student['dob']); ?>" readonly>
            <input type="date" id="dob" name="dob" >
        </div>

        <!-- Age -->
        <div>
            <label for="Age">Age</label>
            <input type="number" id="Age" name="Age" value="<?php echo safe_htmlspecialchars($student['age']); ?>">
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
    <input type="text" id="community" name="community" value="<?php echo safe_htmlspecialchars($student['community']); ?>">

    <label for="place_of_birth">Place of Birth</label>
    <input type="text" id="place_of_birth" name="place_of_birth" value="<?php echo safe_htmlspecialchars(isset($student['place_of_birth']) ? $student['place_of_birth'] : ' '); ?>">

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
    <input type="text" id="caste" name="caste" value="<?php echo safe_htmlspecialchars($student['caste']); ?>">

    <label for="religion">Religion</label>
    <input type="text" id="religion" name="religion" value="<?php echo safe_htmlspecialchars($student['religion']); ?>">

    <label for="mother_tongue">Mother Tongue</label>
    <input type="text" id="mother_tongue" name="mother_tongue" value="<?php echo safe_htmlspecialchars($student['mother_tongue']); ?>">
   

    <label for="personal_identifications">Personal Identifications</label>
    <textarea id="personal_identifications" name="personal_identifications" rows="3"><?php echo safe_htmlspecialchars($student['personal_identifications']); ?></textarea>

    <!-- Contact Information -->
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo safe_htmlspecialchars($student['email']); ?>" readonly required>

    <label for="phone">Phone</label>
    <input type="text" id="phone" name="phone" value="<?php echo safe_htmlspecialchars($student['phone']); ?>">

    <button type="submit" class="submit-btn">Update</button>

</form>

<!-- REFERENCE PERSON UPDATE -->
<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data" name="reference_persons_update">
    <input type="hidden" name="form_name" value="reference_persons_update">
    
    <label for="reference-persons">Reference Persons</label><br>
    <label ><button onclick="openModal()" class="open-modal-btn action_btn" type="button">Add Reference Persons</button></label><br>
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
            $reference_persons_query = "SELECT * FROM reference_persons WHERE student_roll_no = ?";
            $stmt = $conn->prepare($reference_persons_query);
            $stmt->bind_param('s', $roll_no);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$i}</td>
                        <td><input type='text' name='reference_name_{$i}' value='" . safe_htmlspecialchars($row['name']) . "' placeholder='Enter name'></td>
                        <td><input type='text' name='reference_phone_{$i}' value='" . safe_htmlspecialchars($row['phone_no']) . "' placeholder='Enter phone no'></td>
                        <td><textarea name='reference_text_{$i}' rows='2' placeholder='Enter address'>" . safe_htmlspecialchars($row['address']) . "</textarea></td>
                        <td>
                            <button type='submit' class='action_btn' name='update_{$i}' value='{$row['id']}'>Update</button>
                            <button type='submit' class='action_btn' name='delete_{$i}' value='{$row['id']}' onclick='return confirmDelete()' >Delete</button>
                        </td>
                    </tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>

</form>



<!-- REFERENCE PERSONINSERT -->
<div id="referenceModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Reference Persons Insert</h2>
        
        <form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data" name="reference_persons">
            <input type="hidden" name="form_name" value="reference_persons">
            
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
                        <td><input type="text" name="reference_name" placeholder="Enter name" required></td>
                        <td><input type="text" name="reference_phone" placeholder="Enter phone no" required></td>
                        <td><textarea name="reference_text" rows="2" placeholder="Enter address" required></textarea></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="submit-btn">INSERT</button>
        </form>
    </div>
</div>
<!-- REFERENCE PERSON INSERT  END-->


<!-- CGPA INSERT UPDATE DELETE -->
<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data"  name="cgpa_section">
<input type="hidden" name="form_name" value="cgpa_section">
<?php
 $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : '';

$sqlFetchCGPA = "SELECT * FROM student_cgpa WHERE student_roll_no = ?";
$stmt = $conn->prepare($sqlFetchCGPA);
$stmt->bind_param('s', $roll_no);
$stmt->execute();
$result = $stmt->get_result();

$cgpaData = $result->fetch_assoc();

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
    $cgpaSemesters = [null, null, null, null, null, null, null, null];
    $cgpa = null;
}?>
                    <label for="gpa">GPA</label><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <div>
            <label for="gpa">sem 1</label><br>
            <input type="number" id="gpa" name="cgpa_sem1" step="0.01" min="0" max="10" value="<?php echo safe_htmlspecialchars($cgpaSemesters[0]); ?>"> <br>
        </div>

        <div>
            <label for="gpa">sem 2</label><br>
            <input type="number" id="gpa" name="cgpa_sem2" step="0.01" min="0" max="10" value="<?php echo safe_htmlspecialchars($cgpaSemesters[1]); ?>"> <br>
        </div>
    </div><br>

    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <div>
            <label for="gpa">sem 3</label><br>
            <input type="number" id="gpa" name="cgpa_sem3" step="0.01" min="0" max="10" value="<?php echo safe_htmlspecialchars($cgpaSemesters[2]); ?>"> <br>
        </div>
        <div>
            <label for="gpa">sem 4</label><br>
            <input type="number" id="gpa" name="cgpa_sem4" step="0.01" min="0" max="10" value="<?php echo safe_htmlspecialchars($cgpaSemesters[3]); ?>"> <br>
        </div>
    </div><br>

    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <div>
            <label for="gpa">sem 5</label><br>
            <input type="number" id="gpa" name="cgpa_sem5" step="0.01" min="0" max="10" value="<?php echo safe_htmlspecialchars($cgpaSemesters[4]); ?>"> <br>
        </div>
        <div>
            <label for="gpa">sem 6</label><br>
            <input type="number" id="gpa" name="cgpa_sem6" step="0.01" min="0" max="10" value="<?php echo safe_htmlspecialchars($cgpaSemesters[5]); ?>"> <br>
        </div>
    </div><br>

    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
        <div>
            <label for="gpa">sem 7</label><br>
            <input type="number" id="gpa" name="cgpa_sem7" step="0.01" min="0" max="10" value="<?php echo safe_htmlspecialchars($cgpaSemesters[6]); ?>"> <br>
        </div>
        <div>
            <label for="gpa">sem 8 </label><br>
            <input type="number" id="gpa" name="cgpa_sem8" step="0.01" min="0" max="10" value="<?php echo safe_htmlspecialchars($cgpaSemesters[7]); ?>"> <br>
        </div>
    </div><br><br>

    <label for="CGPA">CGPA</label><br>
    <input type="number" id="CGPA" name="total_CGPA" step="0.01" min="0" max="10" value="<?php echo safe_htmlspecialchars($cgpa); ?>"> <br>

                    <button type="submit" class="submit-btn">Update</button>

</form>
<!-- CGPA SECTION END -->



<!-- PHOTO SECTION START -->

<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="form_name" value="student_photo">
    <label for="student-photo">Student Photo:</label><br>
    <input type="file" id="student-photo" name="student-photo" accept="image/*"><br>
    <div class="student-photo-container">
        <?php if ($imageFound): ?>
            <img src="./student_details/student_photo/<?php echo safe_htmlspecialchars($student['profile_photo']); ?>" alt="Student Photo" class="student-photo">
        <?php else: ?>
            <p style="color:red; font-weight: bold; margin-top:30px;">File not found</p>
        <?php endif; ?>
    </div>
    <button type="submit" class="submit-btn">Update</button>
</form>

<form action="student_edit.php?roll_no=<?php echo urlencode($student['roll_no']); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="form_name" value="family_photo">
    <label for="family-photo">Family Photo:</label><br>
    <input type="file" id="family-photo" name="family-photo" accept="image/*"><br>
    <div class="family-photo-container">
        <?php if ($family_imageFound): ?>
            <img src="./student_details/family_photo/<?php echo safe_htmlspecialchars($student['family_photo']); ?>" alt="Family Photo" class="family-photo" style="width: 480px; object-fit: cover;">
        <?php else: ?>
            <p style="color:red; font-weight: bold; margin-top:30px;">File not found</p>
        <?php endif; ?>
    </div>
    <button type="submit" class="submit-btn">Update</button>
</form>


<!--  PHOTO SECTION END-->


<!-- PARENT DETAILS -->
<?php
 $roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : '';

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
                            <input type="text" id="Father-name" name="Father_name" placeholder="Enter Father name" value="<?php echo safe_htmlspecialchars($parent_details['father_name']); ?>">
                        </div>

                        <div>
                            <label for="Age">Age</label>
                            <input type="number" id="Age" name="father_age" placeholder="<?php echo safe_htmlspecialchars($parent_details['father_age']); ?>">
                        </div>

                        <div>
                            <label for="Father-occupation">Father Occupation:</label>
                            <input type="text" id="Father-occupation" name="Father_occupation" placeholder="Enter occupation" value="<?php echo safe_htmlspecialchars($parent_details['father_occupation']); ?>">
                        </div>

                        <div>
                            <label for="Mobile_number">Mobile number:</label>
                            <input type="text" id="father_Mobile_number" name="father_Mobile_number" placeholder="Enter Mobile number" value="<?php echo safe_htmlspecialchars($parent_details['father_phone']); ?>">
                        </div>
                    </div><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="mother-name">Mother Name:</label>
                            <input type="text" id="Mother-name" name="Mother_name" placeholder="Enter Mother name" value="<?php echo safe_htmlspecialchars($parent_details['mother_name']); ?>">
</div>
                        <div>
                            <label for="Age">Age</label>
                            <input type="number" id="Age" name="motherage" placeholder="<?php echo safe_htmlspecialchars($parent_details['mother_age']); ?>" >
                        </div>

                        <div>
                            <label for="Mother-occupation">Mother Occupation:</label>
                            <input type="text" id="Mother-occupation" name="Mother_occupation" placeholder="Enter occupation" value="<?php echo safe_htmlspecialchars($parent_details['mother_occupation']); ?>">
                        </div>

                        <div>
                            <label for="Mobile_number">Mobile number:</label>
                            <input type="text" id="mother_Mobile_number" name="mother_Mobile_number" placeholder="Enter Mobile number" value="<?php echo safe_htmlspecialchars($parent_details['mother_phone']); ?>">
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

                    
                   


                        
                        </iframe>


                    </div>

                    <button type="submit" class="submit-btn">update</button>
                </form>



            </div>
        </div>
    </div>


    <script>
    // Function to open the modal
    function openModal() {
        document.getElementById("referenceModal").style.display = "block";
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById("referenceModal").style.display = "none";
    }

    // Close the modal when the user clicks anywhere outside of it
    window.onclick = function(event) {
        var modal = document.getElementById("referenceModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    function confirmDelete() {
        return confirm("Are you sure you want to delete this item?");
    }
</script>
    <script src="../static/dash/script.js"></script>
</body>

</html>