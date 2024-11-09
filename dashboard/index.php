<?php 
include("../resources/connection.php");
session_start();

if (!isset($_SESSION['roll_no'])) {
    header("Location: ../login.php");
    exit();
}

$roll_no = $_SESSION['roll_no'];
$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT * FROM students WHERE roll_no = ?");
$stmt->bind_param("s", $roll_no);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (isset($user['skills']) && !empty($user['skills'])) {
        $skills = json_decode($user['skills'], true); 
        
        if (is_array($skills)) {
            $user['skills'] = implode(', ', $skills);
        } else {
            $user['skills'] = $user['skills'];
        }
    } else {
        $user['skills'] = ''; 
    }

} else {
    echo "User not found.";
    exit();
}

$stmt->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/dash/style.css">
    <link rel="stylesheet" href="../static/dash/custom.css">
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

    <div class="profile-header">
        <img src="../static/img/profile.png" alt="Profile Picture" class="profile-pic">
        <h2 class="profile-name"><?php echo htmlspecialchars($user["name"]); ?></h2>
    </div>
    
    <div class="profile-info">
        <div class="info-box">
            <strong>Name:</strong>
            <span><?php echo htmlspecialchars($user["name"]); ?></span>
        </div>
        <div class="info-box">
            <strong>Roll No:</strong>
            <span><?php echo htmlspecialchars($user["roll_no"]); ?></span>
        </div>
       
        <div class="info-box">
            <strong>Email:</strong>
            <span><?php echo htmlspecialchars($user["email"]);?></span>
        </div>
      
      
        <div class="info-box">
            <strong>Department:</strong>
            <span><?php echo htmlspecialchars($user["department"]); ?></span>
        </div>
        <div class="info-box">
            <strong>Year:</strong>
            <span><?php echo htmlspecialchars($user["year"]); ?></span>
        </div>
        <div class="info-box">
            <strong>Branch:</strong>
            <span><?php echo htmlspecialchars($user["branch"]); ?></span>
        </div>
        <div class="info-box">
            <strong>Skills:</strong>
            <span><?php echo htmlspecialchars($user["skills"]); ?></span>
        </div>  <div class="info-box">
            <strong>GitHub:</strong>
            <span><a href="<?php echo htmlspecialchars($user["github_link"]);?>" target="_blank">bnaveenbharathi</a></span>
        </div>
        <div class="info-box">
            <strong>LinkedIn:</strong>
            <span><a href="<?php echo htmlspecialchars($user["linkedin_link"]); ?>" target="_blank">bnaveenbharathi</a></span>
        </div>
       
    </div>
</div>


            </div>
    </section>

    <script src="../static/dash/script.js"></script>
</body>
</html>