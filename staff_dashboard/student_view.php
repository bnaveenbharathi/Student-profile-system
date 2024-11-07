<?php

session_start();

include("../resources/connection.php");

if (!isset($_SESSION['staff_id'])) {
    header("Location: ../staff_login.php");
    exit();
}

$roll_no = isset($_GET['roll_no']) ? $_GET['roll_no'] : null;

if (!isset($_GET['roll_no']) || empty($_GET['roll_no'])) {
    echo "Student Roll No. not specified!";
    exit();
} else {
    $roll_no = $_GET['roll_no'];
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
$stmt->close();
?>

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../static/dash/style.css">
    <link rel="stylesheet" href="../static/staffdash/custom.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student View | Name</title>
    <style>
       /* General Form Styling */
form {
    width: 80%;
    margin: auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

form label {
    font-weight: bold;
    color: #333;
}

form input[type="text"],
form input[type="number"],
form input[type="date"],
form input[type="email"],
form select,
form textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f0f0f0;
    color: #666;
}

form input[readonly],
form select[readonly],
form textarea[readonly] {
    background-color: #e9ecef;
    cursor: not-allowed;
}

form input[type="file"] {
    padding: 5px;
    margin-top: 10px;
    color: #666;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table th, table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #f5f5f5;
    color: #333;
}

.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
}

.submit-btn:hover {
    background-color: #0056b3;
}

/* Flexbox for Two-Column Layout */
div[style*="display: flex;"] {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 10px;
}

div[style*="display: flex;"] > div {
    flex: 1;
}

textarea {
    resize: vertical;
}

/* Styles for File Uploads */
input[type="file"] {
    background-color: #e9ecef;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 100%;
}

input[type="file"]::file-selector-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
}

input[type="file"]::file-selector-button:hover {
    background-color: #0056b3;
}

.student-photo-container,.family-photo-container{
    display: flex;
    justify-content: center;
    padding: 10px;

}
.student-photo{ 
    min-width: 220px;
    height: 220px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #7ad100;
    transition: border-color 0.3s ease, transform 0.3s ease;
}
.family-photo{ 
    max-width: 580px;
    height: 380px;
    border-radius: 10px;
    object-fit: cover;
    border: 4px solid #7ad100;
    transition: border-color 0.3s ease, transform 0.3s ease;
}
.disciplinary-proof{
    display: flex;
    justify-content: center;

}
.disciplinary-proof-image{
    width: 580px;
    height: 280px;

}
/* Additional Comments Section */
#comments {
    margin-top: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        width: 100%;
        padding: 10px;
    }

    div[style*="display: flex;"] {
        flex-direction: column;
    }

    .submit-btn {
        font-size: 14px;
        padding: 8px;
    }
}

    </style>

    <title>Staff Dashboard </title>
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

                <form action="" method="POST">
                    <label for="Register_Number">Register Number</label>
                    <input type="text" id="Register_Number" name="Register_Number"  readonly value="<?php echo htmlspecialchars($student["roll_no"]); ?>">

                    <label for="name">Name</label>
                    <input type="text" id="name" name="name"  readonly value="<?php echo htmlspecialchars($student["name"]); ?>"><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="department">Department</label>
                    <input type="text" id="department" name="department"  readonly value="<?php echo htmlspecialchars($student["department"]); ?>"><br>
                          
                        </div>
                        <div>
                            <label for="year">Year of Study</label>
                            <input type="text" id="year" name="year" readonly value="<?php echo htmlspecialchars($student["year"]); ?>">
                        </div>
                    </div><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob"  readonly>
                        </div>
                        <div>
                            <label for="Age">Age</label>
                            <input type="number" id="Age" name="Age" readonly>
                        </div>
                    </div>

                    <label for="sex">Sex</label>
                    <input type="text" id="sex" name="sex" readonly>

                    <label for="community">Community</label>
                    <input type="text" id="community" name="community" readonly>

                    <label for="place-of-birth">Place of Birth</label>
                    <input type="text" id="place-of-birth" name="place_of_birth"  readonly>

                    <label for="blood-group">Blood Group</label>
                    <input type="text" id="blood-group" name="blood-group" readonly>
  

                    <label for="caste">Caste</label>
                    <input type="text" id="caste" name="caste" readonly>

                    <label for="religion">Religion</label>
                    <input type="text" id="religion" name="religion" readonly>

                    <label for="mother-tongue">Mother Tongue</label>
                    <input type="text" id="mother-tongue" name="mother_tongue" readonly>

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
                                <td><input type="text" name="name_1" placeholder="Enter name" readonly></td>
                                <td><input type="text" name="phone_1" placeholder="Enter phone no" readonly></td>
                                <td><textarea name="address_1" rows="2" placeholder="Enter address" readonly></textarea></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><input type="text" name="name_1" placeholder="Enter name" readonly></td>
                                <td><input type="text" name="phone_1" placeholder="Enter phone no" readonly></td>
                                <td><textarea name="address_1" rows="2" placeholder="Enter address" readonly></textarea></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><input type="text" name="name_1" placeholder="Enter name" readonly></td>
                                <td><input type="text" name="phone_1" placeholder="Enter phone no" readonly></td>
                                <td><textarea name="address_1" rows="2" placeholder="Enter address" readonly></textarea></td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>


                    <label for="personal-identifications">Personal Identifications</label>
                    <textarea id="personal-identifications" name="personal_identifications" rows="3" placeholder="Enter unique identification marks or features" readonly></textarea>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"  readonly>

                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone"  readonly>


                    <label for="gpa">GPA</label><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="gpa">sem 1</label><br>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10"  readonly> <br>

                        </div>

                        <div>
                            <label for="gpa">sem 2</label><br>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10"  readonly> <br>
                        </div>
                    </div><br>
                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="gpa">sem 3</label><br>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10"  readonly> <br>
                        </div>
                        <div>
                            <label for="gpa">sem 4</label><br>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10"  readonly> <br>
                        </div>
                    </div><br>
                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="gpa">sem 5</label><br>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10"  readonly> <br>
                        </div>
                        <div>
                            <label for="gpa">sem 6</label><br>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10"  readonly> <br>
                        </div>
                    </div><br>
                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="gpa">sem 7</label><br>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10"  readonly> <br>
                        </div>
                        <div>
                            <label for="gpa">sem 8 </label><br>
                            <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10"  readonly> <br>
                        </div>
                    </div><br><br>
                    <label for="CGPA">CGPA</label><br>
                    <input type="number" id="CGPA" name="CGPA" step="0.01" min="0" max="10"  readonly> <br>

                   
              <!-- student photo -->
                    <div>
                    <label for="student-photo">Student Photo:</label><br>

                    <div class="student-photo-container">

                           <img src="../static/img/profile.png" alt="" class="student-photo">

                    </div>

                      
                        </div>

                        <div>
                        <label for="family-photo">Family Photo:</label><br>
                        <div class="family-photo-container">

                           <img src="../static/img/profile.png" alt="" class="family-photo">

                    </div>

                      
                        </div>


                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px; margin-top:20px;">
                        <div>
                            <label for="Father-name">Father Name:</label>
                            <input type="text" id="Father-name" name="Father_name" placeholder="Enter Father name" readonly>
                        </div>

                        <div>
                            <label for="Age">Age</label>
                            <input type="number" id="Age" name="Age" placeholder="Enter Age" readonly>
                        </div>

                        <div>
                            <label for="Father-occupation">Father Occupation:</label>
                            <input type="text" id="Father-occupation" name="Father_occupation" placeholder="Enter occupation" readonly>
                        </div>

                        <div>
                            <label for="Mobile number">Mobile number:</label>
                            <input type="text" id="Mobile number" name="Mobile number" placeholder="Enter Mobile number" readonly>
                        </div>
                    </div><br>

                    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                        <div>
                            <label for="mother-name">Mother Name:</label>
                            <input type="text" id="Mother-name" name="Mother_name" placeholder="Enter Mother name" readonly>
                        </div>
                        <div>
                            <label for="Age">Age</label>
                            <input type="number" id="Age" name="Age" placeholder="Enter Age" readonly>
                        </div>

                        <div>
                            <label for="Mother-occupation">Mother Occupation:</label>
                            <input type="text" id="Mother-occupation" name="Mother_occupation" placeholder="Enter occupation" readonly>
                        </div>

                        <div>
                            <label for="Mobile number">Mobile number:</label>
                            <input type="text" id="Mobile number" name="Mobile number" placeholder="Enter Mobile number" readonly>
                        </div>
                    </div><br>


                    <div style="margin-bottom: 10px; margin-top:15px;">
                        <label for="Student Disciplinary Issues">Student Disciplinary Issues</label><br>

                        <label for="issue-date">Issue date</label>
                        <input type="date" id="issue-date" name="issue_date" readonly>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="issue-description">Issue Description:</label><br>
                        <textarea id="issue-description" name="issue_description" rows="3" placeholder="Describe the issue" readonly></textarea>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="action-taken">Action Taken:</label><br>
                        <textarea id="action-taken" name="action_taken" rows="2" placeholder="Describe action taken" readonly></textarea>
                    </div>

                    <div style="margin-bottom: 10px;">
                        <label for="Staff Handle">Staff Handle</label><br>
                        <textarea id="Staff Handle" name="Staff Handle" rows="2" placeholder="Enter staff name" readonly></textarea>
                    </div>


                    <div style="margin-bottom: 10px;">
                        <label for="comments">Additional Comments:</label><br>
                        <textarea id="comments" name="comments" rows="2" placeholder="Any additional comments" readonly></textarea>
                    </div><br>

                    <label for="Document upload">Document</label><br>

                    <div class="disciplinary-proof">


                    </div>

  


                    <button type="submit" class="submit-btn">Submit Profile</button>
                </form>



            </div>
            </div>
            </div>



            <script src="../static/dash/script.js"></script>
</body>

</html>