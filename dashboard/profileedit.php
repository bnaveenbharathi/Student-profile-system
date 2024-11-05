<?php 
include("../resources/connection.php");
session_start();

if (!isset($_SESSION['roll_no'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data from the database
$roll_no = $_SESSION['roll_no'];
$query = "SELECT * FROM users WHERE roll_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $roll_no);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Set the skills for display
$skills = $user['skills']; // Assuming 'skills' is a column in the users table
$user['skills'] = $skills ? $skills : '';

// Assuming 'skills' is stored as a JSON array, convert it to a comma-separated string for display
$skills = json_decode($user['skills'], true); // Decode JSON into an array
$user['skills'] = is_array($skills) ? implode(', ', $skills) : ''; // Convert to comma-separated string

$message = '';if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $github_link = $_POST['github_link'];
    $linkedin_link = $_POST['linkedin_link'];
    $occupation = $_POST['occupation'];
    $experience = $_POST['experience'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $skills = $_POST['skills']; // This should be a comma-separated string
    $branch = $_POST['branch'];

    // Convert the comma-separated string of skills into a JSON array
    $skillArray = array_map('trim', explode(',', $skills)); // Split and trim spaces
    $skillsJson = json_encode($skillArray); // Convert to JSON

    if (empty($name) || empty($email)) {
        $message = "Name and email are required.";
    } else {
        // Update user data in the database
        $updateQuery = "UPDATE users SET 
            name = ?, 
            email = ?, 
            github_link = ?, 
            linkedin_link = ?, 
            occupation = ?, 
            experience = ?, 
            department = ?, 
            year = ?, 
            semester = ?, 
            branch = ?, 
            skills = ?  -- Update skills in JSON format
            WHERE roll_no = ?";

        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ssssssssssss", 
            $name, 
            $email, 
            $github_link, 
            $linkedin_link, 
            $occupation, 
            $experience, 
            $department, 
            $year, 
            $semester, 
            $branch, 
            $skillsJson, // Store the JSON skills here
            $roll_no);

        if ($updateStmt->execute()) {
            $message = "Profile updated successfully!";
    header("Location: ./index.php");
            
            // Refresh user data
            $user = array_merge($user, [
                'name' => $name,
                'email' => $email,
                'github_link' => $github_link,
                'linkedin_link' => $linkedin_link,
                'occupation' => $occupation,
                'experience' => $experience,
                'department' => $department,
                'year' => $year,
                'semester' => $semester,
                'branch' => $branch,
                'skills' => $skillsJson // Update skills in JSON format
            ]);
        } else {
            $message = "Error updating profile.";
        }

        $updateStmt->close();
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

        .action-icon {
            margin-top: 20px;
        }

        .info-box {
            margin-bottom: 15px;
        }
        input{
            border: none;
            background: transparent;
            color: #7ad100;
           
            border: 1px solid #9747FF;
            padding: 15px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
     
<?php include("./sidebar.php") ?>

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-user"></i>
            <span class="text">Edit Profile</span>
        </div>
        
        <div class="profile-box">
            <div class="profile-header">
                <img src="../static/img/profile.png" alt="Profile Picture" class="profile-pic">
                <h2 class="profile-name"><?php echo htmlspecialchars($user['name']); ?></h2>
            </div>

            <form class="profile-info" method="POST">
                <div class="info-box">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="info-box">
                    <strong>Email:</strong>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="info-box">
                    <strong>Occupation:</strong>
                    <input type="text" name="occupation" value="<?php echo htmlspecialchars($user['occupation']); ?>" required>
                </div>
                <div class="info-box">
                    <strong>Experience:</strong>
                    <input type="text" name="experience" value="<?php echo htmlspecialchars($user['experience']); ?>" required>
                </div>
                <div class="info-box">
                    <strong>Department:</strong>
                    <input type="text" name="department" value="<?php echo htmlspecialchars($user['department']); ?>" required>
                </div>
                <div class="info-box">
                    <strong>Year:</strong>
                    <input type="number" name="year" value="<?php echo htmlspecialchars($user['year']); ?>" required>
                </div>
                <div class="info-box">
                    <strong>Semester:</strong>
                    <input type="number" name="semester" value="<?php echo htmlspecialchars($user['semester']); ?>" required>
                </div>
                <div class="info-box">
                    <strong>Skills:</strong>
                    <input type="text" name="skills" value="<?php echo htmlspecialchars($user['skills']); ?>" required>
                </div>
                <div class="info-box">
                    <strong>Branch:</strong>
                    <input type="text" name="branch" value="<?php echo htmlspecialchars($user['branch']); ?>" required>
                </div>
                <div class="info-box">
                    <strong>GitHub:</strong>
                    <input type="url" name="github_link" value="<?php echo htmlspecialchars($user['github_link']); ?>">
                </div>
                <div class="info-box">
                    <strong>LinkedIn:</strong>
                    <input type="url" name="linkedin_link" value="<?php echo htmlspecialchars($user['linkedin_link']); ?>">
                </div>
                <div class="action-icon mt-3">
                    <a href="./index.php"><button type="button" class="update-button">Back</button></a>
                    <button type="submit" class="update-button">Update</button>
                </div>
            </form>

            <?php if ($message): ?>
                <div class="alert alert-success">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../static/dash/script.js"></script>
</body>
</html>
