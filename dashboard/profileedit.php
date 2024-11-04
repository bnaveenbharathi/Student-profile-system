<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <link rel="stylesheet" href="../static/dash/style.css">
    <link rel="stylesheet" href="../static/dash/custom.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Edit Profile</title> 
  <style>
.update-button {
    background-color: #7ad100; 
    color: white;
    padding: 10px 20px;
    border: none; 
    border-radius: 5px;
    font-size: 16px; 
    font-weight: bold; 
    cursor: pointer; 
    transition: background-color 0.3s ease, transform 0.2s ease; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.update-button:hover {
    background-color: #9747FF; 
    transform: translateY(-2px); 
}

.update-button:focus {
    outline: none; 
    box-shadow: 0 0 0 2px rgba(121, 189, 249, 0.5); 
}
.action-icon{
    margin-top: 20px;
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
               
                <!-- Profile3  -->
               

                <div class="profile-box">
                  
    <div class="profile-header">
        <img src="../static/img/profile.png" alt="Profile Picture" class="profile-pic">
        <h2 class="profile-name">John Doe</h2>
    </div>
    
    <div class="profile-info">
        <div class="info-box">
            <strong>Name:</strong>
            <span>John Doe</span>
        </div>
        <div class="info-box">
            <strong>Roll No:</strong>
            <span>12345</span>
        </div>
        <div class="info-box">
            <strong>Occupation:</strong>
            <span>Web Developer</span>
        </div>
        <div class="info-box">
            <strong>Email:</strong>
            <span>john.doe@example.com</span>
        </div>
        <div class="info-box">
            <strong>GitHub:</strong>
            <span><a href="https://github.com/johndoe" target="_blank">bnaveenbharathi</a></span>
        </div>
        <div class="info-box">
            <strong>LinkedIn:</strong>
            <span><a href="https://linkedin.com/in/johndoe" target="_blank">bnaveenbharathi</a></span>
        </div>
        <div class="info-box">
            <strong>Experience:</strong>
            <span>3 Years</span>
        </div>
        <div class="info-box">
            <strong>Department:</strong>
            <span>Computer Science</span>
        </div>
        <div class="info-box">
            <strong>Year:</strong>
            <span>2024</span>
        </div>
        <div class="info-box">
            <strong>Semester:</strong>
            <span>5</span>
        </div>
        <div class="info-box">
            <strong>Skills:</strong>
            <span>HTML, CSS, JavaScript, React, Node.js</span>
        </div>
        <div class="info-box">
            <strong>Branch:</strong>
            <span>Engineering</span>
        </div>
    </div>
  <div class="action-icon mt-3">
  <a href="./index.php"><button class="update-button">Back</button></a>
  <button class="update-button">Update</button>
  </div>
</div>


            </div>
    </section>

    <script src="../static/dash/script.js"></script>
</body>
</html>