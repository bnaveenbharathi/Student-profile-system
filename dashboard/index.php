<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../static/dash/style.css">
    <link rel="stylesheet" href="../static/dash/custom.css">
     
    <!----===== Iconscout CSS ===== -->
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
                <div class="profile-box">
                <i class="uil uil-edit edit-icon"></i>

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
</div>


            </div>
    </section>

    <script src="../static/dash/script.js"></script>
</body>
</html>