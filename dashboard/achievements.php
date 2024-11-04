<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <link rel="stylesheet" href="../static/dash/style.css">
    <link rel="stylesheet" href="../static/dash/achievements.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Dashboard | Achievements</title> 
    <style>
    p a{
    color: #4CAF50;
    text-decoration: none ;
}</style>
</head>
<body>
     
<?php include("./sidebar.php") ?>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                <i class="uil uil-user"></i>

                    <span class="text">Achievements</span>
                </div>
               
                <!-- Achievements  -->
                 <div class="container-Achievements">

                 <div class="form-container">
        <h1>Add Achievement</h1>
        <form id="achievement-form">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="image">Image URL:</label>
                <input type="file" id="image" name="image" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="link">Link:</label>
                <input type="url" id="link" name="link" required>
            </div>
            <button type="submit" class="submit-button">Submit</button>
        </form>
    </div>
    <div class="form-container Achievements">
    <h1>Achievements</h1>

    <div class="achievements-list">
        <h3>Name</h3>
        <img src="../static/img/profile.png" alt="" width="280px" style="object-fit: cover;">
        <textarea name="" id="" readonly>
            welcome
        </textarea>
        <p >
            <a href="">Click Here</a>
        </p>
    </div>
    
          
    </div>


                 </div>
              


            </div>
    </section>

    <script src="../static/dash/script.js"></script>
</body>
</html>