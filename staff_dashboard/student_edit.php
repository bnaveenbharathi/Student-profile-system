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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

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

            <form action="/submit-profile" method="POST">
            <label for="Register_Number">Register Number</label>
            <input type="text" id="Register_Number" name="Register_Number" required>

            <label for="name">Name</label>
            <input type="text" id="name" name="name" required><br>

            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
              <div>  
                <label for="department">Department</label>
                    <select id="department" name="department" required>
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
                <select id="year" name="year" required>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                </select>
              </div>
            </div><br>
            
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <div>
                    <label for="Age">Age</label>
                    <input type="number" id="Age" name="Age">
                </div>
            </div>

            <label for="sex">Sex</label>
            <select id="sex" name="sex" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="community">Community</label>
            <input type="text" id="community" name="community">

            <label for="place-of-birth">Place of Birth</label>
            <input type="text" id="place-of-birth" name="place_of_birth" required>

            <label for="blood-group">Blood Group</label>
            <select id="blood-group" name="blood_group" required>
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
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" required>

            


            <label for="gpa">GPA</label><br>

            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="gpa">sem 1</label><br>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10" required>  <br>
            
                </div>

                <div>
                    <label for="gpa">sem 2</label><br>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10" required>  <br>
                </div>
            </div><br>
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="gpa">sem 3</label><br>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10" required>  <br>
                </div>
                <div>
                    <label for="gpa">sem 4</label><br>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10" required>  <br>
                </div>
            </div><br>
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="gpa">sem 5</label><br>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10" required>  <br>
                </div>
                <div>
                    <label for="gpa">sem 6</label><br>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10" required>  <br>
                </div>
            </div><br>
            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 10px;">
                <div>
                    <label for="gpa">sem 7</label><br>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10" required>  <br>
                </div>
                <div>
                    <label for="gpa">sem 8 </label><br>
                    <input type="number" id="gpa" name="gpa" step="0.01" min="0" max="10" required>  <br>
                </div>
            </div><br><br>
            <label for="CGPA">CGPA</label><br>
            <input type="number" id="CGPA" name="CGPA" step="0.01" min="0" max="10" required> <br>

            <label for="family-photo">Student Photo:</label><br>
            <input type="file" id="student-photo" name="student-photo" accept="image/*"><br>

            <div class="student-photo-container">

<img src="../static/img/profile.png" alt="" class="student-photo">

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
                    <label for="Mobile number">Mobile number:</label>
                    <input type="text" id="Mobile number" name="Mobile number" placeholder="Enter Mobile number">
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
                    <label for="Mobile number">Mobile number:</label>
                    <input type="text" id="Mobile number" name="Mobile number" placeholder="Enter Mobile number">
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
                <label for="Staff Handle">Staff Handle</label><br>
                <textarea id="Staff Handle" name="Staff Handle" rows="2" placeholder="Enter staff name"></textarea>
            </div>
          
              
            <div style="margin-bottom: 10px;">
                  <label for="comments">Additional Comments:</label><br>
                  <textarea id="comments" name="comments" rows="2" placeholder="Any additional comments"></textarea>
            </div><br>

                <label for="Document upload">Document upload</label><br>
                <input type="file" id="Document upload" name="Document upload" accept="image/*" ><br>
                   

                
                <div class="disciplinary-proof mt-5">

<img src="" alt="" class="disciplinary-proof-image">

</div>
                   
           

            <button type="submit" class="submit-btn">Submit Profile</button>
        </form>



            </div>



            <script src="../static/dash/script.js"></script>
</body>

</html>